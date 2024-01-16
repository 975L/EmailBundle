<?php
/*
 * (c) 2018: 975L <contact@975l.com>
 * (c) 2018: Laurent Marquet <laurent.marquet@laposte.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace c975L\EmailBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use c975L\EmailBundle\Service\EmailService;

class EmailServiceTest extends TestCase
{
    private $mailer;
    private $em;
    private $emailService;
    private $emailData;

    protected function setUp(): void
    {
        //Defines needed mocks
        $this->mailer = $this->getMockBuilder('\Swift_Mailer')
            ->disableOriginalConstructor()
            ->getMock();
        $this->em = $this->getMockBuilder(\Doctrine\ORM\EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        //Defines data
        $this->emailService = new EmailService($this->mailer, $this->em);
        $this->emailData = ['subject' => 'YOUR_SUBJECT', 'sentFrom' => 'contact@example.com', 'sentTo' => 'contact@example.com', 'sentCc' => 'contact@example.com', 'sentBcc' => 'contact@example.com', 'replyTo' => 'contact@example.com', 'body' => 'body', 'attach' => [['data', 'filename', 'text/html']], 'ip' => 'IP_ADDRESS'];
    }

    //Test sending a good email
    public function testSendEmail()
    {
        $this->assertTrue($this->emailService->send($this->emailData));
    }

    //Test sending a wrong sentTo
    public function testSendWrongSentToEmail()
    {
        $this->emailData['sentTo'] = null;
        $this->assertFalse($this->emailService->send($this->emailData));
    }

    //Test sending a wrong replyTo
    public function testSendWrongReplyToEmail()
    {
        $this->emailData['replyTo'] = 'bad_email';
        $this->assertFalse($this->emailService->send($this->emailData));
    }

    //Test sending a wrong sentCc
    public function testSendWrongSentCcEmail()
    {
        $this->emailData['sentCc'] = 'bad_email';
        $this->assertTrue($this->emailService->send($this->emailData));
    }

    //Test sending a wrong sentBcc
    public function testSendWrongSentBccEmail()
    {
        $this->emailData['sentBcc'] = 'bad_email';
        $this->assertTrue($this->emailService->send($this->emailData));
    }
}
