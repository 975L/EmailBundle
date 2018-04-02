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
    public function dashboardAction(Request $request)
    {
        //Gets the user
        $user = $this->getUser();

        //Returns the dashboard content
        if ($user !== null && $this->get('security.authorization_checker')->isGranted($this->getParameter('c975_l_email.roleNeeded'))) {
            //Gets the manager
            $em = $this->getDoctrine()->getManager();

            //Gets repository
            $repository = $em->getRepository('c975LEmailBundle:Email');

            //Pagination
            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $repository->findAll(array(), array('dateSent' => 'DESC')),
                $request->query->getInt('p', 1),
                50
            );

            //Defines toolbar
            $tools  = $this->renderView('@c975LEmail/tools.html.twig', array(
                'type' => 'dashboard',
            ));
            $toolbar = $this->forward('c975L\ToolbarBundle\Controller\ToolbarController::displayAction', array(
                'tools'  => $tools,
                'dashboard'  => 'email',
            ))->getContent();

            //Returns the dashboard
            return $this->render('@c975LEmail/pages/dashboard.html.twig', array(
                'emails' => $pagination,
                'toolbar' => $toolbar,
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
    public function displayAction($id)
    {
        //Gets the user
        $user = $this->getUser();

        if ($user !== null && $this->get('security.authorization_checker')->isGranted($this->getParameter('c975_l_email.roleNeeded'))) {
            //Gets the manager
            $em = $this->getDoctrine()->getManager();

            //Gets repository
            $repository = $em->getRepository('c975LEmailBundle:Email');

            //Gets email
            $email = $repository->find(array('id' =>$id));

            //Defines toolbar
            $tools  = $this->renderView('@c975LEmail/tools.html.twig', array(
                'type' => 'display',
            ));
            $toolbar = $this->forward('c975L\ToolbarBundle\Controller\ToolbarController::displayAction', array(
                'tools'  => $tools,
                'dashboard'  => 'email',
            ))->getContent();

            return $this->render('@c975LEmail/pages/display.html.twig', array(
                'toolbar' => $toolbar,
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
    public function helpAction()
    {
        //Gets the user
        $user = $this->getUser();

        //Returns the dashboard content
        if ($user !== null && $this->get('security.authorization_checker')->isGranted($this->getParameter('c975_l_email.roleNeeded'))) {
            //Defines toolbar
            $tools  = $this->renderView('@c975LEmail/tools.html.twig', array(
                'type' => 'help',
            ));
            $toolbar = $this->forward('c975L\ToolbarBundle\Controller\ToolbarController::displayAction', array(
                'tools'  => $tools,
                'dashboard'  => 'email',
            ))->getContent();

            //Returns the help
            return $this->render('@c975LEmail/pages/help.html.twig', array(
                'toolbar' => $toolbar,
            ));
        }

        //Access is denied
        throw $this->createAccessDeniedException();
    }
}