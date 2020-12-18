<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
         $categories = $em->getRepository("AdminBundle:Category")->findAll();
        // replace this example code with whatever you need
        return $this->render('default/pages/home.html.twig', [
            'categories' => $categories,
        ]);
    }


    /**
     * @Route("/admin", name="adminpage")
     */
    public function adminAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/admin.html.twig');
    }
}

