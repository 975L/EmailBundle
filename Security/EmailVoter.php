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
use c975L\ConfigBundle\Service\ConfigServiceInterface;
use c975L\EmailBundle\Entity\Email;

/**
 * Voter for Email access
 * @author Laurent Marquet <laurent.marquet@laposte.net>
 * @copyright 2018 975L <contact@975l.com>
 */
class EmailVoter extends Voter
{
    /**
     * Stores ConfigServiceInterface
     * @var ConfigServiceInterface
     */
    private $configService;

    /**
     * Stores AccessDecisionManagerInterface
     * @var AccessDecisionManagerInterface
     */
    private $decisionManager;

    /**
     * Used for access to config
     * @var string
     */
    public const CONFIG = 'c975LEmail-config';

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
        self::CONFIG,
        self::DASHBOARD,
        self::DISPLAY,
        self::HELP,
    );

    public function __construct(
        ConfigServiceInterface $configService,
        AccessDecisionManagerInterface $decisionManager
    ) {
        $this->configService = $configService;
        $this->decisionManager = $decisionManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject): bool
    {
        if (null !== $subject) {
            return $subject instanceof Email && in_array($attribute, self::ATTRIBUTES);
        }

        return in_array($attribute, self::ATTRIBUTES);
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        //Defines access rights
        switch ($attribute) {
            case self::CONFIG:
            case self::DASHBOARD:
            case self::DISPLAY:
            case self::HELP:
                return $this->decisionManager->decide($token, array($this->configService->getParameter('c975LEmail.roleNeeded', 'c975l/email-bundle')));
                break;
        }

        throw new \LogicException('Invalid attribute: ' . $attribute);
    }
}