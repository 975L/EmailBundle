<?php
/*
 * (c) 2018: 975L <contact@975l.com>
 * (c) 2018: Laurent Marquet <laurent.marquet@laposte.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace c975L\EmailBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Knp\Component\Pager\PaginatorInterface;
use c975L\EmailBundle\Entity\Email;
use c975L\EmailBundle\Service\EmailServiceInterface;

/**
 * Main Controller class
 * @author Laurent Marquet <laurent.marquet@laposte.net>
 * @copyright 2018 975L <contact@975l.com>
 */
class EmailController extends Controller
{
//DASHBOARD
    /**
     * Displays the dashboard
     * @return Response
     * @throws AccessDeniedException
     *
     * @Route("/email/dashboard",
     *      name="email_dashboard")
     * @Method({"GET", "HEAD"})
     */
    public function dashboard(Request $request, EmailServiceInterface $emailService, PaginatorInterface $paginator)
    {
        $this->denyAccessUnlessGranted('dashboard', null);

        //Renders the dashboard
        $emails = $paginator->paginate(
            $emailService->getEmails(),
            $request->query->getInt('p', 1),
            50
        );
        return $this->render('@c975LEmail/pages/dashboard.html.twig', array(
            'emails' => $emails,
        ));
    }

//DISPLAY
    /**
     * Displays the email corresponding to its id
     * @return Response
     * @throws AccessDeniedException
     *
     * @Route("/email/{id}",
     *      name="email_display",
     *      requirements={
     *          "id": "^([0-9]+)"
     *      })
     * @Method({"GET", "HEAD"})
     */
    public function display(Email $email)
    {
        $this->denyAccessUnlessGranted('display', $email);

        //Renders the email
        return $this->render('@c975LEmail/pages/display.html.twig', array(
            'email' => $email,
        ));
    }

//HELP
    /**
     * Displays the help
     * @return Response
     * @throws AccessDeniedException
     *
     * @Route("/email/help",
     *      name="email_help")
     * @Method({"GET", "HEAD"})
     */
    public function help()
    {
        $this->denyAccessUnlessGranted('help', null);

        //Renders the help
        return $this->render('@c975LEmail/pages/help.html.twig');
    }
}
