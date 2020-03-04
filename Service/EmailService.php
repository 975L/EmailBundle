<?php
/*
 * (c) 2017: 975L <contact@975l.com>
 * (c) 2017: Laurent Marquet <laurent.marquet@laposte.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace c975L\EmailBundle\Service;

use c975L\ConfigBundle\Service\ConfigServiceInterface;
use c975L\EmailBundle\Entity\Email;
use c975L\EmailBundle\Service\EmailServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email as Message;

/**
 * Main services related to Email
 * @author Laurent Marquet <laurent.marquet@laposte.net>
 * @copyright 2017 975L <contact@975l.com>
 */
class EmailService implements EmailServiceInterface
{
    /**
     * Stores ConfigServiceInterface
     * @var ConfigServiceInterface
     */
    private $configService;

    /**
     * Stores EntityManagerInterface
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * Stores Email Entity
     * @var Email
     */
    private $email;

    /**
     * Stores mailer
     * @var MailerInterface
     */
    private $mailer;

    /**
     * Stores message
     * @var Swift_Message
     */
    private $message;

    public function __construct(
        ConfigServiceInterface $configService,
        EntityManagerInterface $em,
        MailerInterface $mailer
    ) {
        $this->configService = $configService;
        $this->em = $em;
        $this->mailer = $mailer;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $emailData)
    {
        $this->email = new Email();
        $this->email->setDataFromArray($emailData);
        $this->email->setDateSent(new \DateTime());

        $this->message = new Message();
    }

    /**
     * {@inheritdoc}
     */
    public function getEmails()
    {
        return $this->em
            ->getRepository('c975LEmailBundle:Email')
            ->findAll(array(), array('dateSent' => 'DESC'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter(string $parameter)
    {
        return $this->configService->getParameter($parameter);
    }

    /**
     * {@inheritdoc}
     */
    public function persist(bool $saveDatabase)
    {
        if ($saveDatabase) {
            $this->em->persist($this->email);
            $this->em->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function send(array $emailData, bool $saveDatabase = false)
    {
        $this->create($emailData);
        $this->validate($emailData);
        $this->persist($saveDatabase);

        //Sends email
        if ($this->message instanceof Message) {
            $this->message
                ->from($this->email->getSentFrom())
                ->subject($this->email->getSubject())
                ->html($this->email->getBody())
                ->priority(Message::PRIORITY_NORMAL)
            ;
            $this->mailer->send($this->message);

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(array $emailData)
    {
        $validator = new EmailValidator();
        $multipleValidations = new MultipleValidationWithAnd([
            new RFCValidation(),
            new DNSCheckValidation()
        ]);

        //Validates SentTo to not send email if not passed, to avoid spam
        if (null !== $this->email->getSentTo() && $validator->isValid($this->email->getSentTo(), $multipleValidations)) {
            $this->message->to($this->email->getSentTo());
        } else {
            $this->message = false;

            return false;
        }

        //Validates ReplyTo to not send email if not passed, to avoid spam
        if (null !== $this->email->getReplyTo()) {
            if ($validator->isValid($this->email->getReplyTo(), $multipleValidations)) {
                $this->message->replyTo($this->email->getReplyTo());
            } else {
                $this->message = false;

                return false;
            }
        }

        //SentCC
        if (null !== $this->email->getSentCc() && $validator->isValid($this->email->getSentCc(), $multipleValidations)) {
            $this->message->cc($this->email->getSentCc());
        }

        //Sent Bcc
        if (null !== $this->email->getSentBcc() && $validator->isValid($this->email->getSentBcc(), $multipleValidations)) {
            $this->message->bcc($this->email->getSentBcc());
        }

        //Attach files
        if (array_key_exists('attach', $emailData) && is_array($emailData['attach'])) {
            foreach ($emailData['attach'] as $attach) {
                $this->message->attachFromPath($attach[0], $attach[1], $attach[2]);
            }
        }

        return true;
    }
}
