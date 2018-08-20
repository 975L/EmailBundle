<?php
/*
 * (c) 2018: 975L <contact@975l.com>
 * (c) 2018: Laurent Marquet <laurent.marquet@laposte.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace c975L\EmailBundle\Service;

interface EmailServiceInterface
{
    /**
     * Creates email object
     */
    public function create(array $emailData);

    /**
     * Gets the emails
     * @return \Knp\Component\Pager\PaginatorInterface
     */
    public function getEmails(int $number);

    /**
     * Persists Email in DB
     */
    public function persist(bool $saveDatabase);

    /**
     * Creates and sends the email
     *
     * @return boolean
     */
    public function send(array $emailData, bool $saveDatabase = false);

    /**
     * Validates email addresses and creates message
     *
     * @return boolean
     */
    public function validate(array $emailData);
}
