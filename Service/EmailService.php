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
    private $em;

    public function __construct(
        \Swift_Mailer $mailer,
        \Doctrine\ORM\EntityManagerInterface $em
        )
    {
        $this->mailer = $mailer;
        $this->em = $em;
    }

    //Creates and sends the email
    public function send($emailData, $saveDatabase = false)
    {
        //Creates email
        $email = new Email();
        $email->setDataFromArray($emailData);
        $email->setDateSent(new \DateTime());

        //Validates addresses
        $validator = new EmailValidator();
        $multipleValidations = new MultipleValidationWithAnd([
            new RFCValidation(),
            new DNSCheckValidation()
        ]);

        //Creates message
        $message = new \Swift_Message();

        //Validates SentTo to not send email if not passed, to avoid spam
        if ($email->getSentTo() !== null && $validator->isValid($email->getSentTo(), $multipleValidations)) {
            $message->setTo($email->getSentTo());
        } else {
            return false;
        }

        //Validates ReplyTo to not send email if not passed, to avoid spam
        if ($email->getReplyTo() !== null) {
            if ($validator->isValid($email->getReplyTo(), $multipleValidations)) {
                $message->setReplyTo($email->getReplyTo());
            } else {
                return false;
            }
        }

        //SentCC
        if ($email->getSentCc() !== null && $validator->isValid($email->getSentCc(), $multipleValidations)) {
            $message->setCc($email->getSentCc());
        }

        //Sent Bcc
        if ($email->getSentBcc() !== null && $validator->isValid($email->getSentBcc(), $multipleValidations)) {
            $message->setBcc($email->getSentBcc());
        }

        //Attach files
        if (array_key_exists('attach', $emailData) && is_array($emailData['attach'])) {
            foreach ($emailData['attach'] as $attach) {
                $message->attach(new \Swift_Attachment($attach[0], $attach[1], $attach[2]));
            }
        }

        //Sends email
        $message
            ->setFrom($email->getSentFrom())
            ->setSubject($email->getSubject())
            ->setBody($email->getBody())
            ->setContentType('text/html');
        $this->mailer->send($message);

        //Persists Email in DB
        if ($saveDatabase === true) {
            $this->em->persist($email);
            $this->em->flush();
        }

        return true;
    }
}