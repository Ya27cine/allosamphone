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
 * @Route("stock")
 */
class StockController extends Controller
{
    /**
     * Lists all stock entities.
     *
     * @Route("/{id_prod}/variant/{libelle}", name="stock_index")
     * @Method("GET")
     */
    public function indexAction($id_prod, $libelle)
    {
        $em = $this->getDoctrine()->getManager();

        $stocks = $em->createQuery("select p FROM AppBundle:Stock p where p.product = :id")
                      ->setParameter("id", $id_prod);

        return $this->render('stock/index.html.twig', array(
            'stocks' => $stocks->getResult(),
            'id_prod' => $id_prod,
            'libelle' => $libelle
        ));
    }

    /**
     * Creates a new stock entity.
     *
     * @Route("/{id_prod}/new", name="stock_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id_prod)
    {
        // get product 
         $produit = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Product')->find($id_prod);
 

        $stock = new Stock();
        $form = $this->createForm('AppBundle\Form\StockType', $stock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
        
            $em = $this->getDoctrine()->getManager();
            $em->persist($stock);  
            $em->flush();
            $stock->setProduct( $produit );//select product auto.   


            $em->flush();

            return $this->redirectToRoute('stock_show', array('id' => $stock->getId()));
        }
       
        return $this->render('stock/new.html.twig', array(
            'stock' => $stock,
            'form' => $form->createView(),
            'produit' => $produit->getLibelle(),
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
        $deleteForm = $this->createDeleteForm($stock);
        $editForm = $this->createForm('AppBundle\Form\StockType', $stock);
        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stock_edit', array('id' => $stock->getId()));
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
