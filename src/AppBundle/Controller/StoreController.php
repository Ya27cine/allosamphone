<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


define('Category_Smartphone_et_tablette', 12);



class StoreController extends Controller
{

    /**
     * @Route("/store/phone", name="store_phone_page")
     */
    public function samrtphoneAction()
    {
        $em = $this->getDoctrine()->getManager();

        // Get all marques :
        $marques  = $em->getRepository('AdminBundle:Marque')->findAll();

        // Get Prodects Phone :
         $products  = $em->getRepository('AdminBundle:Product')->findBy([
                'category' => Category_Smartphone_et_tablette,
         ]);

    
        return $this->render('@App/Store/samrtphone.html.twig', array(
             'marques' => $marques,
              'products' => $products,
        ));
    }

    /**
     * @Route("/store/accessories", name="store_access_page")
     */
    public function accessoriesAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        $marques  = $em->getRepository('AdminBundle:Marque')->findAll();

        // get access :
        $access = $em->createQuery("select p FROM AdminBundle:Product p where p.category <> :category")
                      ->setParameter("category", Category_Smartphone_et_tablette);


        return $this->render('@App/Store/accessories.html.twig', array(
            'marques' => $marques,
            'access' => $access->getResult(),

        ));
    }

    /**
     * @Route("/store/repair", name="store_repair_page")
     */
    public function repairAction()
    {
        $em = $this->getDoctrine()->getManager();
        $marques  = $em->getRepository('AdminBundle:Marque')->findAll();

        return $this->render('@App/Store/repair.html.twig', array(
            'marques' => $marques,
        ));
    }













     /**
     * @Route("/store/detail/{id_product}", name="store_detail_page")
     */
    public function detailAction($id_product)
    {
        $em = $this->getDoctrine()->getManager();
        $varients  = $em->getRepository('AppBundle:Stock')->findBy([
            'product' => $id_product,
        ]);

        return $this->render('@App/pages/product.html.twig', array(
            'id' => $id_product,
            'varient' => $varients[0],
        ));
    }

}
