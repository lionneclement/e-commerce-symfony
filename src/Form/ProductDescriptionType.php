<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductDescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('conditionnement',ChoiceType::class,[
                'choices' => [
                    '1kg' => 1,
                    '500g' => 0.5,
                    '250g' => 0.25
                ]
            ])
            ->add('moutures',ChoiceType::class,[
                'choices' => [
                    'Grain' => 'Grain',
                    'Café Turc' => 'Café Turc',
                    'Expresso' => 'Expresso',
                    'Filtre' => 'Filtre',
                    'Italienne' => 'Italienne',
                    'Piston'=> 'Piston'
                ]
            ])
            ->add('quantity',IntegerType::class, [
                'data' => 1,//default value
                'attr' => ['min' => 1] //min value
            ])
            ->add('send',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
