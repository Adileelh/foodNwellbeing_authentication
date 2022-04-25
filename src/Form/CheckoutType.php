<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
       
            ->add('address', EntityType::class,
            [
                'class' => Address::class,
                'required' => true,
                'choice' => $user->getAddresses(),
                'multiple' => false,
                'expanded' => true
            ])
            ->add('carrier', EntityType::class,
            [
                'class' => Carrier::class,
                'required' => true,
                'multiple' => false,
                'expanded' => true
            ])
            ->add('information')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
