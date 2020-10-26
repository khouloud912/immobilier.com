<?php

namespace App\Form;

use App\Entity\ImmobilierSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ImmobilierSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

      $builder
          ->add('maxPrice',IntegerType::class,[
              'required' => false ,
              'label'=>false,
              'attr'=>[
                  'placeholder'=>'budget max'
              ]
          ])


          ->add('minSurface',IntegerType::class,[
              'required' => false ,
              'label'=>false,
              'attr'=>[
                  'placeholder'=>'surface min']
          ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImmobilierSearch::class,
            'method'=>'get',
            'csrf_protection' =>false,
            "allow_extra_fields" => true
        ]);
    }

    public function getBlockPrefix() //fonction tnathem el url
    {
        return '';
    }
}
