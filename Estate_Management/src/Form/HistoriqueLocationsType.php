<?php

namespace App\Form;

use App\Entity\HistoriqueLocations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoriqueLocationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('biens', EntityType::class, [
                'class' => 'App:Biens',
                'choice_label' => 'noms',
                'multiple' => false, // a user can select only one option per submission
                'expanded' => false // options will be presented in a <select> element; set this to true, to present the data as checkboxes
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HistoriqueLocations::class,
        ]);
    }
}
