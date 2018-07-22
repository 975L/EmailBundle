<?php
/*
 * (c) 2017: 975L <contact@975l.com>
 * (c) 2017: Laurent Marquet <laurent.marquet@laposte.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace c975L\EmailBundle\Service;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use c975L\EmailBundle\Entity\Email;

class EmailService
{
    private $mailer;
    private $message;
    private $em;

    public function __construct(
        \Swift_Mailer $mailer,
        \Doctrine\ORM\EntityManagerInterface $em
        ) {
        $this->mailer = $mailer;
        $this->em = $em;
    }

    //Creates email object
    public function create($emailData)
    {
        $email = new Email();
        $email
            ->setDataFromArray($emailData)
            ->setDateSent(new \DateTime())
        ;

        return $email;
    }

    //Validates email addresses and creates message
    public function validate($email)
    {
        $validator = new EmailValidator();
        $multipleValidations = new MultipleValidationWithAnd([
            new RFCValidation(),
            new DNSCheckValidation()
        ]);

        //Creates message
        $this->message = new \Swift_Message();

        //Validates SentTo to not send email if not passed, to avoid spam
        if (null !== $email->getSentTo() && $validator->isValid($email->getSentTo(), $multipleValidations)) {
            $this->message->setTo($email->getSentTo());
        } else {
            $this->message = false;
        }

        //Validates ReplyTo to not send email if not passed, to avoid spam
        if (null !== $email->getReplyTo()) {
            if ($validator->isValid($email->getReplyTo(), $multipleValidations)) {
                $this->message->setReplyTo($email->getReplyTo());
            } else {
                $this->message = false;
            }
        }

        //SentCC
        if (null !== $email->getSentCc() && $validator->isValid($email->getSentCc(), $multipleValidations)) {
            $this->message->setCc($email->getSentCc());
        }

        //Sent Bcc
        if (null !== $email->getSentBcc() && $validator->isValid($email->getSentBcc(), $multipleValidations)) {
            $this->message->setBcc($email->getSentBcc());
        }

        //Attach files
        if (array_key_exists('attach', $emailData) && is_array($emailData['attach'])) {
            foreach ($emailData['attach'] as $attach) {
                $this->message->attach(new \Swift_Attachment($attach[0], $attach[1], $attach[2]));
            }
        }
    }

    //Persists Email in DB
    public function persist($saveDatabase, $email)
    {
        if (true === $saveDatabase) {
            $this->em->persist($email);
            $this->em->flush();
        }
    }

    //Creates and sends the email
    public function send($emailData, $saveDatabase = false)
    {
        //Creates email
        $email = $this->create($emailData);

        //Validates addresses
        $this->validate($email);

        //Persists Email in DB
        $this->persist($saveDatabase);

        //Sends email
        if ($this->message instanceof Swift_Message) {
            $this->message
                ->setFrom($email->getSentFrom())
                ->setSubject($email->getSubject())
                ->setBody($email->getBody())
                ->setContentType('text/html');
            return $this->mailer->send($this->message);
        }

        return false;
    }
}