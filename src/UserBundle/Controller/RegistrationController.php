<?php

namespace UserBundle\Controller;

use  FOS\UserBundle\Controller\RegistrationController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\RegistrationStep1Type;
use UserBundle\Form\RegistrationStep2Type;
use UserBundle\Form\RegistrationStep3Type;
use FOS\UserBundle\Controller\RegistrationController as ParentController;

class RegistrationController extends Controller
{
   /* public function confirmAction(Request $request, $token)
    {
        $parent = new ParentController;
        return $parent->confirmAction($request, $token);
    }
*/
    /**
     * @Route("/register_step1", name="user_register_step1")
     */
    public function registerStep1Action(Request $request)
    {
        $form = $this->createForm(new RegistrationStep1Type());
        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $session = $this->get('session');
                $session->set('gkhNumber', $form->get('gkhNumber')->getData());
                $session->set('privateNumber', $form->get('privateNumber')->getData());

                return new JsonResponse(array(
                    'status' => true
                ));
            } else {

                if($form->get('email')->getData()) {
                    $id = $this->get('user_request_manager')->writeEmailRequest($form->get('email')->getData());

                    return new JsonResponse(array(
                        'status' => false,
                        'id' => $id,
                    ));
                } else {
                    return new JsonResponse(array(
                        'status' => false,
                        'html' => $this->renderView('UserBundle:Registration:register_step1.html.twig', array('form' => $form->createView())),
                    ));
                }
            }
        }


        return $this->render('UserBundle:Registration:register_step1.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/register_step2", name="user_register_step2")
     */
    public function registerStep2Action(Request $request)
    {
        $form = $this->createForm(new RegistrationStep2Type());

        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $session = $this->get('session');
                $session->set('email', $form->get('email')->getData());
                $session->set('password', $form->get('password')->getData());

                return new JsonResponse(array(
                    'status' => true
                ));
            } else {
                return new JsonResponse(array(
                    'status' => false,
                    'html' => $this->renderView('UserBundle:Registration:register_step2.html.twig', array('form' => $form->createView())),
                ));
            }
        }

        return $this->render('UserBundle:Registration:register_step2.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/register_step3", name="user_register_step3")
     */
    public function registerStep3Action(Request $request)
    {
        $form = $this->createForm(new RegistrationStep3Type());

        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $session = $this->get('session');
                $session->set('name', $form->get('name')->getData());
                $this->get('user_manager')->createNewUser();

                return new JsonResponse(array(
                    'status' => true
                ));
            } else {
                return new JsonResponse(array(
                    'status' => false,
                    'html' => $this->renderView('UserBundle:Registration:register_step3.html.twig', array('form' => $form->createView())),
                ));
            }
        }

        return $this->render('UserBundle:Registration:register_step3.html.twig', array('form' => $form->createView()));
    }
}
