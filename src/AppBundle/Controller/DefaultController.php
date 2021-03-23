<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Repository\StockRepository;
use AdminBundle\Entity\Product;

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

         // get All categories :
         $categories = $em->getRepository("AdminBundle:Category")->findAll();

         // get last 5 products / accessories
         $new_products_access = 
                        $this->getLastProdcutAcce($em, $ctg_phone, 5);
        
         // get last 5 products / smartphones
         $new_products_smartphones = 
                        $this->getLastProdcut($em, $ctg_phone , 5);


        // get last 5 products / smartphones
         $top_sell_products_acc = 
                        $this->getTpoSellingAcc($em, $ctg_phone , 5);

         // get last 5 products / smartphones
         $top_sell_products_smartphones = 
                        $this->getTpoSelling($em, $ctg_phone , 5);
       
        // replace this example code with whatever you need
        return $this->render('@App/pages/home.html.twig', [
            'categories' => $categories,
            'new_products_access' => $new_products_access,
            'new_products_smartphones' => $new_products_smartphones,
            'top_sell_products_smartphones' => $top_sell_products_smartphones,
            'top_sell_products_acc' => $top_sell_products_acc,
        ]);
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



    /**
    * ===>  Methods
    *
    */

    // get last 5 products / samrtphone
    private function getLastProdcut($em, $category, $max){
        
        return  $em->createQuery(
                   'SELECT varient FROM AppBundle:Stock varient, AdminBundle:Product p  
                    WHERE varient.product = p.id and  p.category = '.$category.'
                        ORDER BY varient.createdAt DESC')
        ->setMaxResults($max)->getResult();
    }

    // get last 5 products / expet samrtphone
    private function getLastProdcutAcce($em, $category, $max){
        
        return  $em->createQuery(
                   'SELECT varient FROM AppBundle:Stock varient, AdminBundle:Product p  
                    WHERE varient.product = p.id and  p.category <> '.$category.'
                        ORDER BY varient.createdAt DESC')
        ->setMaxResults($max)->getResult();
    }


    // get top selling 5 products / expet samrtphone
    private function getTpoSellingAcc($em, $category, $max){
        
        return  $em->createQuery(
                   'SELECT varient FROM AppBundle:Stock varient, AdminBundle:Product p  
                    WHERE varient.product = p.id and  p.category <> '.$category.'
                        ORDER BY varient.sold DESC')
        ->setMaxResults($max)->getResult();
    }


    // get top selling 5 products / samrtphone
    private function getTpoSelling($em, $category, $max){
        
        return  $em->createQuery(
                   'SELECT varient FROM AppBundle:Stock varient, AdminBundle:Product p  
                    WHERE varient.product = p.id and  p.category = '.$category.'
                        ORDER BY varient.sold DESC')
        ->setMaxResults($max)->getResult();
    }

}

