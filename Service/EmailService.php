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

    public function __construct(\Swift_Mailer $mailer, \Doctrine\ORM\EntityManagerInterface $em)
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

        if ($validator->isValid($email->getSentTo(), $multipleValidations)) {
            $send = true;
            $message = (new \Swift_Message())
                ->setFrom($email->getSentFrom())
                ->setSubject($email->getSubject())
                ->setTo($email->getSentTo())
                ->setBody($email->getBody())
                ->setContentType('text/html');

            //SentCC
            if ($email->getSentCc() !== '' && $validator->isValid($email->getSentCc(), $multipleValidations)) {
                $message->setCc($email->getSentCc());
            }
            //Sent Bcc
            if ($email->getSentBcc() !== '' && $validator->isValid($email->getSentBcc(), $multipleValidations)) {
                $message->setBcc($email->getSentBcc());
            }
            //Tests ReplyTo to not send email if not passed, to avoid spam
            if ($email->getReplyTo() !== '') {
                if ($validator->isValid($email->getReplyTo(), $multipleValidations)) {
                    $message->setReplyTo($email->getReplyTo());
                } else {
                    $send = false;
                }
            }

            //Attach file
            if (array_key_exists('attach', $emailData) && $emailData['attach'] != '' && $emailData['attach'] != null) {
                $attachment = new \Swift_Attachment($emailData['attach'][0], $emailData['attach'][1], $emailData['attach'][2]);
                $message->attach($attachment);
            }

            //Sends email
            if ($send === true) {
                $this->mailer->send($message);

                //Persists Email in DB
                if ($saveDatabase === true) {
                    $this->em->persist($email);
                    $this->em->flush();
                }
            }
        }
    }
}