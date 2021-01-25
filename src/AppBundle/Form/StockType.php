<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class StockType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('quantity')->add('price')->add('title')->add('value')->add('ref')->add('sold')->add('promo')
        ->add('img1', FileType::class, array('label'=>'image png ou jpeg', 'data_class' => null, 'required'=>false))
        ->add('img2', FileType::class, array('label'=>'image png ou jpeg', 'data_class' => null, 'required'=>false))
        ->add('img3', FileType::class, array('label'=>'image png ou jpeg', 'data_class' => null, 'required'=>false))
        ->add('img4', FileType::class, array('label'=>'image png ou jpeg', 'data_class' => null, 'required'=>false))
         ->add('product', EntityType::class, array(
                        'class' => 'AdminBundle:Product',
                        'choice_label' => 'libelle',
                        'expanded' => false));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Stock'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_stock';
    }


}
