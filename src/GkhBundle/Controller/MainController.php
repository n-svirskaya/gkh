<?php

namespace GkhBundle\Controller;

use GkhBundle\Entity\ElectronicTreatment;
use GkhBundle\Form\ElectronicTreatmentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * @Route("/", name="main_index")
     */
    public function indexAction(Request $request)
    {
        $elTreatment = new ElectronicTreatment();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ElectronicTreatmentType(), $elTreatment);
$error = 0;
        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $elTreatment->upload();

                $em->persist($elTreatment);
                $em->flush($elTreatment);

                return new RedirectResponse($this->generateUrl('main_index', array('success' => 1)));
            } else {
                $error = 1;
            }
        }



        return $this->render('GkhBundle:Main:index.html.twig', array('form' => $form->createView(), 'error' => $error));
    }
}
