<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('marque', EntityType::class, array(
                    'class' => 'AdminBundle:Marque',
                    'choice_label' => 'name',
                    'expanded' => false))
                ->add('category', EntityType::class, array(
                        'class' => 'AdminBundle:Category',
                        'choice_label' => 'name',
                        'expanded' => false))
                ->add('modele')
                ->add('libelle')
                ->add('image', FileType::class , array('label'=>'image png ou jpeg', 'data_class' => null, 'required'=>false));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AdminBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'adminbundle_product';
    }


}
