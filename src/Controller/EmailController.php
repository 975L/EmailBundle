<?php
/*
 * (c) 2018: 975L <contact@975l.com>
 * (c) 2018: Laurent Marquet <laurent.marquet@laposte.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace c975L\EmailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Knp\Component\Pager\PaginatorInterface;
use c975L\ConfigBundle\Service\ConfigServiceInterface;
use c975L\EmailBundle\Entity\Email;
use c975L\EmailBundle\Service\EmailServiceInterface;

/**
 * Main Controller class
 * @author Laurent Marquet <laurent.marquet@laposte.net>
 * @copyright 2018 975L <contact@975l.com>
 */
class EmailController extends AbstractController
{
//DASHBOARD
    /**
     * Displays the dashboard
     * @return Response
     * @throws AccessDeniedException
     */
    #[Route(
        '/email/dashboard',
        name: 'email_dashboard',
        methods: ['GET']
    )]
    public function dashboard(Request $request, EmailServiceInterface $emailService, PaginatorInterface $paginator)
    {
        $this->denyAccessUnlessGranted('c975LEmail-dashboard', null);

        //Renders the dashboard
        $emails = $paginator->paginate(
            $emailService->getEmails(),
            $request->query->getInt('p', 1),
            50
        );
        return $this->render('@c975LEmail/pages/dashboard.html.twig', ['emails' => $emails])->setMaxAge(3600);
    }

//DISPLAY
    /**
     * Displays the email corresponding to its id
     * @return Response
     * @throws AccessDeniedException
     */
    #[Route(
        '/email/{id}',
        name: 'email_display',
        requirements: [
            'id' => '^([0-9]+)'
        ],
        methods: ['GET']
    )]
    public function display(Email $email)
    {
        $this->denyAccessUnlessGranted('c975LEmail-display', $email);

        //Renders the email
        return $this->render('@c975LEmail/pages/display.html.twig', ['email' => $email])->setMaxAge(3600);
    }

//CONFIG
    /**
     * Displays the configuration
     * @return Response
     * @throws AccessDeniedException
     */
    #[Route(
        '/email/config',
        name: 'email_config',
        methods: ['GET', 'POST']
    )]
    public function config(Request $request, ConfigServiceInterface $configService)
    {
        $this->denyAccessUnlessGranted('c975LEmail-config', null);

        //Defines form
        $form = $configService->createForm('c975l/email-bundle');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Validates config
            $configService->setConfig($form);

            //Redirects
            return $this->redirectToRoute('email_dashboard');
        }

        //Renders the config form
        return $this->render('@c975LConfig/forms/config.html.twig', ['form' => $form->createView(), 'toolbar' => '@c975LEmail'])->setMaxAge(3600);
    }

//HELP
    /**
     * Displays the help
     * @return Response
     * @throws AccessDeniedException
     */
    #[Route(
        '/email/help',
        name: 'email_help',
        methods: ['GET']
    )]
    public function help()
    {
        $this->denyAccessUnlessGranted('c975LEmail-help', null);

        //Renders the help
        return $this->render('@c975LEmail/pages/help.html.twig')->setMaxAge(3600);
    }
}
