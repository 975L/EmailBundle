<?php
/*
 * (c) 2017: 975L <contact@975l.com>
 * (c) 2017: Laurent Marquet <laurent.marquet@laposte.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace c975L\EmailBundle\Service;

use Doctrine\ORM\EntityManager;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use c975L\EmailBundle\Entity\Email;

class EmailService
{
    private $mailer;
    private $em;

    public function __construct(\Swift_Mailer $mailer, EntityManager $em)
    {
        $this->mailer = $mailer;
        $this->em = $em;
    }

    //Creates and sends the email
    public function send($emailData)
    {
        //Creates email
        $email = new Email();
        $email->setDataFromArray($emailData);
        $email->setDateSent(new \DateTime());

        //Validates addresses
        $validator = new EmailValidator();
        if ($validator->isValid($email->getSentTo(), new RFCValidation())) {
            $message = (new \Swift_Message())
                ->setFrom($email->getSentFrom())
                ->setSubject($email->getSubject())
                ->setTo($email->getSentTo())
                ->setBody($email->getBody())
                ->setContentType('text/html');

            //Adds other address
            if ($email->getSentCc() !== '' && $validator->isValid($email->getSentCc(), new RFCValidation())) $message->setCc($email->getSentCc());
            if ($email->getSentBcc() !== '' && $validator->isValid($email->getSentBcc(), new RFCValidation())) $message->setBcc($email->getSentBcc());
            if ($email->getReplyTo() !== '' && $validator->isValid($email->getReplyTo(), new RFCValidation())) $message->setReplyTo($email->getReplyTo());
        }

        //Persists Email in DB
        $this->em->persist($email);

        //Sends email
        $this->mailer->send($message);

        //Flush DB
        $this->em->flush();
    }
}