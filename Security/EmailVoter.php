<?php
/*
 * (c) 2018: 975L <contact@975l.com>
 * (c) 2018: Laurent Marquet <laurent.marquet@laposte.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace c975L\EmailBundle\Security;

use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use c975L\EmailBundle\Entity\Email;

/**
 * Voter for Email access
 * @author Laurent Marquet <laurent.marquet@laposte.net>
 * @copyright 2018 975L <contact@975l.com>
 */
class EmailVoter extends Voter
{
    /**
     * @var AccessDecisionManagerInterface
     */
    private $decisionManager;

    /**
     * The role needed to be allowed access (defined in config)
     * @var string
     */
    private $roleNeeded;

    /**
     * Used for access to dashboard
     * @var string
     */
    public const DASHBOARD = 'c975LEmail-dashboard';

    /**
     * Used for access to display of email
     * @var string
     */
    public const DISPLAY = 'c975LEmail-display';

    /**
     * Used for access to help
     * @var string
     */
    public const HELP = 'c975LEmail-help';

    /**
     * Contains all the available attributes to check with in supports()
     * @var array
     */
    private const ATTRIBUTES = array(
        self::DASHBOARD,
        self::DISPLAY,
        self::HELP,
    );

    public function __construct(AccessDecisionManagerInterface $decisionManager, string $roleNeeded)
    {
        $this->decisionManager = $decisionManager;
        $this->roleNeeded = $roleNeeded;
    }

    /**
     * Checks if attribute and subject are supported
     * @return bool
     */
    protected function supports($attribute, $subject)
    {
        if (null !== $subject) {
            return $subject instanceof Email && in_array($attribute, self::ATTRIBUTES);
        }

        return in_array($attribute, self::ATTRIBUTES);
    }

    /**
     * Votes if access is granted
     * @return bool
     * @throws \LogicException
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        //Defines access rights
        switch ($attribute) {
            case self::DASHBOARD:
            case self::DISPLAY:
            case self::HELP:
                return $this->decisionManager->decide($token, array($this->roleNeeded));
        }

        throw new \LogicException('Invalid attribute: ' . $attribute);
    }
}