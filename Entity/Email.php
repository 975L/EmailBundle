<?php
/*
 * (c) 2017: 975L <contact@975l.com>
 * (c) 2017: Laurent Marquet <laurent.marquet@laposte.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace c975L\EmailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Email
 *
 * @ORM\Table(name="emails")
 * @ORM\Entity
 */
class Email
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_sent", type="datetime", nullable=true)
     */
    protected $dateSent;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=256, nullable=true)
     */
    protected $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="sent_from", type="string", length=128, nullable=true)
     */
    protected $sentFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="sent_to", type="string", length=128, nullable=true)
     */
    protected $sentTo;

    /**
     * @var string
     *
     * @ORM\Column(name="sent_cc", type="string", length=128, nullable=true)
     */
    protected $sentCc;

    /**
     * @var string
     */
    protected $sentBcc;

    /**
     * @var string
     */
    protected $replyTo;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="string", length=65000, nullable=true)
     */
    protected $body;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=48, nullable=true)
     */
    protected $ip;


    public function setDataFromArray($data)
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
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateSent
     *
     * @return Email
     */
    public function setDateSent($dateSent)
    {
        $this->dateSent = $dateSent;

        return $this;
    }

    /**
     * Get dateSent
     *
     * @return \DateTime
     */
    public function getDateSent()
    {
        return $this->dateSent;
    }

    /**
     * Set subject
     *
     * @return Email
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set sentFrom
     *
     * @return Email
     */
    public function setSentFrom($sentFrom)
    {
        $this->sentFrom = $sentFrom;

        return $this;
    }

    /**
     * Get sentFrom
     *
     * @return string
     */
    public function getSentFrom()
    {
        return $this->sentFrom;
    }

    /**
     * Set sentTo
     *
     * @return Email
     */
    public function setSentTo($sentTo)
    {
        $this->sentTo = $sentTo;

        return $this;
    }

    /**
     * Get sentTo
     *
     * @return string
     */
    public function getSentTo()
    {
        return $this->sentTo;
    }

    /**
     * Set sentCc
     *
     * @return Email
     */
    public function setSentCc($sentCc)
    {
        $this->sentCc = $sentCc;

        return $this;
    }

    /**
     * Get sentCc
     *
     * @return string
     */
    public function getSentCc()
    {
        return $this->sentCc;
    }

    /**
     * Set sentBcc
     *
     * @return Email
     */
    public function setSentBcc($sentBcc)
    {
        $this->sentBcc = $sentBcc;

        return $this;
    }

    /**
     * Get sentBcc
     *
     * @return string
     */
    public function getSentBcc()
    {
        return $this->sentBcc;
    }

    /**
     * Set replyTo
     *
     * @return Email
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    /**
     * Get replyTo
     *
     * @return string
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * Set body
     *
     * @return Email
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set ip
     *
     * @return Email
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }
}