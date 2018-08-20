<?php
/*
 * (c) 2017: 975L <contact@975l.com>
 * (c) 2017: Laurent Marquet <laurent.marquet@laposte.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace c975L\EmailBundle\Service;

use \Swift_Message;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use c975L\EmailBundle\Entity\Email;
use c975L\EmailBundle\Service\EmailServiceInterface;

class EmailService implements EmailServiceInterface
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    /**
     * @var \c975L\EmailBundle\Entity\Email
     */
    private $email;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Swift_Message
     */
    private $message;

    /**
     * @var \Knp\Component\Pager\Pagination\PaginatorInterface
     */
    private $paginator;

    public function __construct(
        \Doctrine\ORM\EntityManagerInterface $em,
        \Swift_Mailer $mailer,
        \Knp\Component\Pager\PaginatorInterface $paginator
    )
    {
        $this->em = $em;
        $this->mailer = $mailer;
        $this->paginator = $paginator;
        $this->message = new \Swift_Message();
        $this->email = new Email();
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $emailData)
    {
        $this->email->setDataFromArray($emailData);
        $this->email->setDateSent(new \DateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function getEmails(int $number)
    {
        //Gets the emails
        $emails = $this->em
            ->getRepository('c975LEmailBundle:Email')
            ->findAll(array(), array('dateSent' => 'DESC'))
        ;

        //Pagination
        return $this->paginator->paginate(
            $emails,
            $number,
            50
        );
    }

    /**
     * {@inheritdoc}
     */
    public function persist(bool $saveDatabase)
    {
        if (true === $saveDatabase) {
            $this->em->persist($this->email);
            $this->em->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function send(array $emailData, bool $saveDatabase = false)
    {
        //Creates email
        $this->create($emailData);

        //Validates addresses
        $this->validate($emailData);

        //Persists Email in DB
        $this->persist($saveDatabase);

        //Sends email
        if ($this->message instanceof Swift_Message) {
            $this->message
                ->setFrom($this->email->getSentFrom())
                ->setSubject($this->email->getSubject())
                ->setBody($this->email->getBody())
                ->setContentType('text/html');
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
            $this->message->setTo($this->email->getSentTo());
        } else {
            $this->message = false;
            return false;
        }

        //Validates ReplyTo to not send email if not passed, to avoid spam
        if (null !== $this->email->getReplyTo()) {
            if ($validator->isValid($this->email->getReplyTo(), $multipleValidations)) {
                $this->message->setReplyTo($this->email->getReplyTo());
            } else {
                $this->message = false;
                return false;
            }
        }

        //SentCC
        if (null !== $this->email->getSentCc() && $validator->isValid($this->email->getSentCc(), $multipleValidations)) {
            $this->message->setCc($this->email->getSentCc());
        }

        //Sent Bcc
        if (null !== $this->email->getSentBcc() && $validator->isValid($this->email->getSentBcc(), $multipleValidations)) {
            $this->message->setBcc($this->email->getSentBcc());
        }

        //Attach files
        if (array_key_exists('attach', $emailData) && is_array($emailData['attach'])) {
            foreach ($emailData['attach'] as $attach) {
                $this->message->attach(new \Swift_Attachment($attach[0], $attach[1], $attach[2]));
            }
        }

        return true;
    }
}
