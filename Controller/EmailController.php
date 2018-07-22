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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use c975L\EmailBundle\Entity\Email;

class EmailController extends Controller
{
//DASHBOARD
    /**
     * @Route("/email/dashboard",
     *      name="email_dashboard")
     * @Method({"GET", "HEAD"})
     */
    public function dashboard(Request $request)
    {
        //Returns the dashboard content
        if (null !== $this->getUser() && $this->get('security.authorization_checker')->isGranted($this->getParameter('c975_l_email.roleNeeded'))) {
            //Gets the repository
            $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('c975LEmailBundle:Email');

            //Pagination
            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $repository->findAll(array(), array('dateSent' => 'DESC')),
                $request->query->getInt('p', 1),
                50
            );

            //Returns the dashboard
            return $this->render('@c975LEmail/pages/dashboard.html.twig', array(
                'emails' => $pagination,
            ));
        }

        //Access is denied
        throw $this->createAccessDeniedException();
    }

//DISPLAY
    /**
     * @Route("/email/{id}",
     *      name="email_display",
     *      requirements={
     *          "id": "^([0-9]+)"
     *      })
     * @Method({"GET", "HEAD"})
     */
    public function display($id)
    {
        if (null !== $this->getUser() && $this->get('security.authorization_checker')->isGranted($this->getParameter('c975_l_email.roleNeeded'))) {
            //Gets the email
            $email = $this->getDoctrine()
                ->getManager()
                ->getRepository('c975LEmailBundle:Email')
                ->findOneById($id);

            return $this->render('@c975LEmail/pages/display.html.twig', array(
                'email' => $email,
            ));
        }

        //Access is denied
        throw $this->createAccessDeniedException();
    }

//HELP
    /**
     * @Route("/email/help",
     *      name="email_help")
     * @Method({"GET", "HEAD"})
     */
    public function help()
    {
        //Returns the help
        if (null !== $this->getUser() && $this->get('security.authorization_checker')->isGranted($this->getParameter('c975_l_email.roleNeeded'))) {
            return $this->render('@c975LEmail/pages/help.html.twig');
        }

        //Access is denied
        throw $this->createAccessDeniedException();
    }
}