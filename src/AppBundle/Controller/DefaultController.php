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
     * @Route("/p", name="p_page")
     */
    public function pAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/pages/product.html.twig');
    }


     /**
     * @Route("/ch", name="ch_page")
     */
    public function chAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/pages/checkout.html.twig');
    }

    
    /**
     * @Route("/store", name="store_page")
     */
    public function storeAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/pages/store.html.twig');
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

