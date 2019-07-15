<?php
/*
 * (c) 2018: 975L <contact@975l.com>
 * (c) 2018: Laurent Marquet <laurent.marquet@laposte.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace c975L\EmailBundle\Service;

/**
 * Interface to be called for DI for Email Main related services
 * @author Laurent Marquet <laurent.marquet@laposte.net>
 * @copyright 2018 975L <contact@975l.com>
 */
interface EmailServiceInterface
{
    /**
     * Creates email object
     */
    public function create(array $emailData);

    /**
     * Gets the emails
     * @return array
     */
    public function getEmails();

    /**
     * Returns the value of parameter
     * @return mixed
     * @throws \LogicException
     */
    public function getParameter(string $parameter);

    /**
     * Persists Email in DB
     */
    public function persist(bool $saveDatabase);

    /**
     * Creates and sends the email
     * @return bool
     */
    public function send(array $emailData, bool $saveDatabase = false);

    /**
     * Validates email addresses and creates message
     * @return bool
     */
    public function validate(array $emailData);
}
