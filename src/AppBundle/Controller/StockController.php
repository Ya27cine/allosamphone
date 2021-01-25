<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Stock;
use AdminBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Stock controller.
 *
 * @Route("admin/stock")
 */
class StockController extends Controller
{
    /**
     * Lists all stock entities.
     *
     * @Route("/{id_prod}/variant/{libelle}/{category}", name="stock_index")
     * @Method("GET")
     */
    public function indexAction($id_prod, $libelle, $category)
    {
        $em = $this->getDoctrine()->getManager();

        $stocks = $em->createQuery("select p FROM AppBundle:Stock p where p.product = :id")
                      ->setParameter("id", $id_prod);

        return $this->render('stock/index.html.twig', array(
            'stocks' => $stocks->getResult(),
            'id_prod' => $id_prod,
            'libelle' => $libelle,
            'category' => $category
        ));
    }

    /**
     * Creates a new stock entity.
     *
     * @Route("/{id_prod}/new/{category}", name="stock_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id_prod, $category)
    {
        // get product 
         $produit = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Product')->find($id_prod);
 

        $stock = new Stock();
        $form = $this->createForm('AppBundle\Form\StockType', $stock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
        
            $em = $this->getDoctrine()->getManager();

                $file = $stock->getImg1();
                $fileName = md5( uniqid() ).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory_varient'), $fileName);
                $stock->setImg1( $fileName );

                $file2 = $stock->getImg2();
                $fileName = md5( uniqid() ).'.'.$file2->guessExtension();
                $file2->move($this->getParameter('upload_directory_varient'), $fileName);
                $stock->setImg2( $fileName );

                $file3 = $stock->getImg3();
                $fileName = md5( uniqid() ).'.'.$file3->guessExtension();
                $file3->move($this->getParameter('upload_directory_varient'), $fileName);
                $stock->setImg3( $fileName );

                $file4 = $stock->getImg4();
                $fileName = md5( uniqid() ).'.'.$file4->guessExtension();
                $file4->move($this->getParameter('upload_directory_varient'), $fileName);
                $stock->setImg4( $fileName );


            $stock->setCreatedAt( new \DateTime('now') );
            $em->persist($stock);  
            $stock->setProduct( $produit );//select product auto.   

           /* $images = [$stock->getImg1(), $stock->getImg2(), $stock->getImg3(), $stock->getImg4()];
            foreach ($images  as  $img) {
                $file = $img;
                $fileName = md5( uniqid() ).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory_varient'), $fileName);

                $stock->setImage( $fileName );
            }*/

          
            $em->flush();

            return $this->redirectToRoute('stock_show', array('id' => $stock->getId()));
        }
       
        return $this->render('stock/new.html.twig', array(
            'stock' => $stock,
            'form' => $form->createView(),
            'produit' => $produit->getLibelle(),
            'category' => $category
        ));
    }

    /**
     * Finds and displays a stock entity.
     *
     * @Route("/{id}", name="stock_show")
     * @Method("GET")
     */
    public function showAction(Stock $stock)
    {
        $deleteForm = $this->createDeleteForm($stock);

        return $this->render('stock/show.html.twig', array(
            'stock' => $stock,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing stock entity.
     *
     * @Route("/{id}/edit", name="stock_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Stock $stock)
    {

        // get phoots :
        $photos = [1 => $stock->getImg1(), 2 => $stock->getImg2(), $stock->getImg3(), $stock->getImg4()];

        $deleteForm = $this->createDeleteForm($stock);
        $editForm = $this->createForm('AppBundle\Form\StockType', $stock);
        $editForm->handleRequest($request);



        if ($editForm->isSubmitted() && $editForm->isValid()) {

           /* $stock->getImgX() get new value the forms */

             if ( $stock->getImg1() == null) {
                     $stock->setImg1( $photos[1] );
             }else{
                $file = $stock->getImg1();
                $fileName = md5( uniqid() ).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory_varient'), $fileName);
                $stock->setImg1( $fileName );
             } 

             if ( $stock->getImg2() == null) {
                     $stock->setImg2( $photos[2] );
             }else{
                $file = $stock->getImg2();
                $fileName = md5( uniqid() ).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory_varient'), $fileName);
                $stock->setImg2( $fileName );
             } 

             if ( $stock->getImg3() == null) {
                     $stock->setImg3( $photos[3] );
             }else{
                $file = $stock->getImg3();
                $fileName = md5( uniqid() ).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory_varient'), $fileName);
                $stock->setImg3( $fileName );
             } 

             if ( $stock->getImg4() == null) {
                     $stock->setImg4( $photos[4] );
             }else{
                $file = $stock->getImg4();
                $fileName = md5( uniqid() ).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory_varient'), $fileName);
                $stock->setImg4( $fileName );
             } 
            


            $this->getDoctrine()->getManager()->flush();

           // return $this->redirectToRoute('stock_edit', array('id' => $stock->getId()));
             return $this->redirectToRoute('stock_show', array('id' => $stock->getId()));
        }

        return $this->render('stock/edit.html.twig', array(
            'stock' => $stock,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a stock entity.
     *
     * @Route("/{id}", name="stock_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Stock $stock)
    {
        $form = $this->createDeleteForm($stock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($stock);
            $em->flush();
        }

        return $this->redirectToRoute('stock_index');
    }

    /**
     * Creates a form to delete a stock entity.
     *
     * @param Stock $stock The stock entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Stock $stock)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('stock_delete', array('id' => $stock->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
