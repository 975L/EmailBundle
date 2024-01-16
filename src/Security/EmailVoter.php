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
     * Used for access to config
     * @var string
     */
    final public const CONFIG = 'c975LEmail-config';

    /**
     * Used for access to dashboard
     * @var string
     */
    final public const DASHBOARD = 'c975LEmail-dashboard';

    /**
     * Used for access to display of email
     * @var string
     */
    final public const DISPLAY = 'c975LEmail-display';

    /**
     * Used for access to help
     * @var string
     */
    final public const HELP = 'c975LEmail-help';

    /**
     * Contains all the available attributes to check with in supports()
     * @var array
     */
    private const ATTRIBUTES = [self::CONFIG, self::DASHBOARD, self::DISPLAY, self::HELP];

    public function __construct(
        /**
         * Stores ConfigServiceInterface
         */
        private readonly ConfigServiceInterface $configService,
        /**
         * Stores AccessDecisionManagerInterface
         */
        private readonly AccessDecisionManagerInterface $decisionManager
    )
    {
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
        return match ($attribute) {
            self::CONFIG, self::DASHBOARD, self::DISPLAY, self::HELP => $this->decisionManager->decide($token, [$this->configService->getParameter('c975LEmail.roleNeeded', 'c975l/email-bundle')]),
            default => throw new \LogicException('Invalid attribute: ' . $attribute),
        };
    }
}