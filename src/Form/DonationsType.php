<?php

namespace App\Form;

use App\Entity\Donations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('sum', null, [
            'label' => 'Montant du don',
            'attr' => ['placeholder' => 'Montant en €']
        ])
        ->add('message', null, [
            'label' => 'Message',
            'attr' => ['placeholder' => 'Votre message']
        ]);
         
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Donations::class,
        ]);
    }
}
