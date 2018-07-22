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
use c975L\EmailBundle\Entity\Email;
use c975L\EmailBundle\Service\EmailService;

class EmailServiceTest extends TestCase
{
    public function testCreateEmailObject()
    {
        //Defines data
        $emailService = new EmailService();
        $emailData = array(
            'subject' => 'YOUR_SUBJECT',
            'sentFrom' => 'contact@example.com',
            'sentTo' => 'contact@example.com',
            'sentCc' => 'contact@example.com',
            'sentBcc' => 'contact@example.com',
            'replyTo' => 'contact@example.com',
            'body' => 'body',
            'attach' => array(
                array('data', 'filename', 'text/html'),
            ),
            'ip' => 'IP_ADDRESS',
            );

        //Tests email
        $this->assertInstanceOf('Email', $emailService->create($emailData));
    }
}