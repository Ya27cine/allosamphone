<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 * @Route("admin/product")
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     * @Route("/", name="product_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //$products = $em->getRepository('AdminBundle:Product')->findAll();
        $categories = $em->getRepository('AdminBundle:Category')->findAll();


        return $this->render('product/index.html.twig', array(
            //'products' => $products,
            'categories' =>  $categories,
        ));
    }
    /**
     * Lists all product entities.
     *
     * @Route("/category/{id}", name="product_by_category")
     * @Method("GET")
     */
    public function prodCategAction($id, Request $request)
    {
         $em = $this->getDoctrine()->getManager();
         
         $category = $em->getRepository('AdminBundle:Category')->find($id);
         $products = $category->getProducts();

         $paginator = $this->get('knp_paginator');
         $pagination_products = $paginator->paginate(
                        $products , /* query NOT result */
                        $request->query->getInt('page', 1), /*page number*/
                        15 /*limit per page*/
         );

        return $this->render('product/products.html.twig', array(
            'products' => $pagination_products,
            'category' => $category->getName(),
        ));
    }

    /**
     * Creates a new product entity.
     *
     * @Route("/new", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('AdminBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if($product->getImage() != null){
                $file = $product->getImage();
                $fileName = md5( uniqid() ).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
                $product->setImage( $fileName );
                $product->setCreatedAt( new \DateTime('now') );
            }

        
     
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_show', array('id' => $product->getId()));
        }

        return $this->render('product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/{id}", name="product_show")
     * @Method("GET")
     */
    public function showAction(Product $product)
    {
        
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('product/show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Product $product)
    {
        $old_img = $product->getImage();

        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('AdminBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if ( $product->getImage() == null) {
                 $product->setImage( $old_img );
             }else{
                $file = $product->getImage();
                $fileName = md5( uniqid() ).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
                $product->setImage( $fileName );
             }

            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('product_edit', array('id' => $product->getId()));
        }

        return $this->render('product/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
             'old_img' => $old_img,[]
        ));
    }

    /**
     * Deletes a product entity.
     *
     * @Route("/{id}", name="product_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('product_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
