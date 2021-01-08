<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // get id catagory_smartphone
         $ctg_phone  = $this->container->getParameter('smartphone_et_tablette');

         $em = $this->getDoctrine()->getManager();
         $categories = $em->getRepository("AdminBundle:Category")->findAll();

         // get last 5 products / accessories
         $new_products_access = $em->createQuery(
                'SELECT p FROM AdminBundle:Product p WHERE p.category <> '.$ctg_phone.'
                ORDER BY p.createdAt DESC')->setMaxResults(5)->getResult();
         // get last 5 products / smartphones
         $new_products_smartphones = $em->createQuery(
                'SELECT p FROM AdminBundle:Product p WHERE p.category = '.$ctg_phone.'
                ORDER BY p.createdAt DESC')->setMaxResults(5)->getResult();
       
        // replace this example code with whatever you need
        return $this->render('@App/pages/home.html.twig', [
            'categories' => $categories,
            'new_products_access' => $new_products_access,
            'new_products_smartphones' => $new_products_smartphones,
        ]);
    }

     /**
     * @Route("/p", name="p_page")
     */
    public function pAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@App/pages/product.html.twig');
    }


     /**
     * @Route("/ch", name="ch_page")
     */
    public function chAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@App/pages/checkout.html.twig');
    }

    
    /**
     * @Route("/store", name="store_page")
     */
    public function storeAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@App/pages/store.html.twig');
    }


    /**
     * @Route("/admin", name="adminpage")
     */
    public function adminAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/admin.html.twig');
    }

    /**
     * @Route("/sma", name="smartphone_page")
     */
    public function pdAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@App/pages/store.html.twig');
    }

    /**
     * @Route("/pgfrr", name="accessories_page")
     */
    public function pfdefrAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@App/pages/product.html.twig');
    }

       /**
     * @Route("/prtr", name="repair_page")
     */
    public function prewtAction(Request $request)
    {
         
         return $this->render('@App/pages/test.html.twig');
    }


     /**
     * @Route("/test", name="test_page")
     * @Method( "POST")
     */
      public function ajaxAction(Request $request){
        $arrayAjax = array("position" => "fasle");
         if (($request->getMethod() == Request::METHOD_POST) && ($request->isXmlHttpRequest())) {
            $personnage = $request->request->get('personnage');

            $em = $this->getDoctrine()->getManager();
            $categories = $em->getRepository("AdminBundle:Category")->findAll();

            $arrayAjax = array(
                "categories" => $categories[0]->getName(),
            );
         }
        return new JsonResponse($arrayAjax);
       }

}

