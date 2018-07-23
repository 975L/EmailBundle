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

class EmailService
{
    private $email;
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
        $this->email = new Email();
        $this->email->setDataFromArray($emailData);
        $this->email->setDateSent(new \DateTime());
    }

    //Validates email addresses and creates message
    public function validate($emailData)
    {
        $validator = new EmailValidator();
        $multipleValidations = new MultipleValidationWithAnd([
            new RFCValidation(),
            new DNSCheckValidation()
        ]);

        //Creates message
        $this->message = new \Swift_Message();

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
    }

    //Persists Email in DB
    public function persist($saveDatabase)
    {
        if (true === $saveDatabase) {
            $this->em->persist($this->email);
            $this->em->flush();
        }
    }

    //Creates and sends the email
    public function send($emailData, $saveDatabase = false)
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
}