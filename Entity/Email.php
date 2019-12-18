<?php
/*
 * (c) 2017: 975L <contact@975l.com>
 * (c) 2017: Laurent Marquet <laurent.marquet@laposte.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace c975L\EmailBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity Email (linked to DB table `emails`)
 * @author Laurent Marquet <laurent.marquet@laposte.net>
 * @copyright 2017 975L <contact@975l.com>
 *
 * @ORM\Table(name="emails")
 * @ORM\Entity
 */
class Email
{
    /**
     * Email unique id
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * DateTime email has been sent
     * @var DateTime
     *
     * @ORM\Column(name="date_sent", type="datetime", nullable=true)
     */
    protected $dateSent;

    /**
     * Subject of the email
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=256, nullable=true)
     */
    protected $subject;

    /**
     * Email address sent from
     * @var string
     *
     * @ORM\Column(name="sent_from", type="string", length=128, nullable=true)
     */
    protected $sentFrom;

    /**
     * Email address sent to
     * @var string
     *
     * @ORM\Column(name="sent_to", type="string", length=128, nullable=true)
     */
    protected $sentTo;

    /**
     * Email address sent cc
     * @var string
     *
     * @ORM\Column(name="sent_cc", type="string", length=128, nullable=true)
     */
    protected $sentCc;

    /**
     * Email address sent bcc (not mapped in DB)
     * @var string
     */
    protected $sentBcc;

    /**
     * Email address reply to (not mapped in DB)
     * @var string
     */
    protected $replyTo;

    /**
     * Body of email
     * @var string
     *
     * @ORM\Column(name="body", type="text", length=65000, nullable=true)
     */
    protected $body;

    /**
     * IP address
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=48, nullable=true)
     */
    protected $ip;

    /**
     * Hydrates entity from associative array
     */
    public function setDataFromArray(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * Get id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set dateSent
     * @param DateTime
     * @return Email
     */
    public function setDateSent(?DateTime $dateSent)
    {
        $this->dateSent = $dateSent;

        return $this;
    }

    /**
     * Get dateSent
     * @return DateTime
     */
    public function getDateSent(): ?DateTime
    {
        return $this->dateSent;
    }

    /**
     * Set subject
     * @param string
     * @return Email
     */
    public function setSubject(?string $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     * @return string
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * Set sentFrom
     * @param string
     * @return Email
     */
    public function setSentFrom(?string $sentFrom)
    {
        $this->sentFrom = $sentFrom;

        return $this;
    }

    /**
     * Get sentFrom
     * @return string|null
     */
    public function getSentFrom(): ?string
    {
        return '' === $this->sentFrom ? null : $this->sentFrom;
    }

    /**
     * Set sentTo
     * @param string
     * @return Email
     */
    public function setSentTo(?string $sentTo)
    {
        $this->sentTo = $sentTo;

        return $this;
    }

    /**
     * Get sentTo
     * @return string|null
     */
    public function getSentTo(): ?string
    {
        return '' === $this->sentTo ? null : $this->sentTo;
    }

    /**
     * Set sentCc
     * @param string
     * @return Email
     */
    public function setSentCc(?string $sentCc)
    {
        $this->sentCc = $sentCc;

        return $this;
    }

    /**
     * Get sentCc
     * @return string|null
     */
    public function getSentCc(): ?string
    {
        return '' === $this->sentCc ? null : $this->sentCc;
    }

    /**
     * Set sentBcc
     * @param string
     * @return Email
     */
    public function setSentBcc(?string $sentBcc)
    {
        $this->sentBcc = $sentBcc;

        return $this;
    }

    /**
     * Get sentBcc
     * @return string|null
     */
    public function getSentBcc(): ?string
    {
        return '' === $this->sentBcc ? null : $this->sentBcc;
    }

    /**
     * Set replyTo
     * @param string
     * @return Email
     */
    public function setReplyTo(?string $replyTo)
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    /**
     * Get replyTo
     * @return string
     */
    public function getReplyTo(): ?string
    {
        return '' === $this->replyTo ? null : $this->replyTo;
    }

    /**
     * Set body
     * @param string
     * @return Email
     */
    public function setBody(?string $body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     * @return string
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * Set ip
     * @param string
     * @return Email
     */
    public function setIp(?string $ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     * @return string
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }
}
