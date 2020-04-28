<?php

namespace App\Form;

use App\Entity\Biens;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BiensType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Adresses', AdressesType::class)
            ->add('ajouter', SubmitType::class, [
                'translation_domain' => false,
                ])
            ->add('noms', TextType::class)
            ->add('descriptions', TextareaType::class)
            ->add('surfaces', IntegerType::class)
            ->add('nbr_pieces', IntegerType::class)
            ->add('nbr_chambres', IntegerType::class)
            ->add('loyers', NumberType::class)
            ->add('statuts', ChoiceType::class, [
                'translation_domain' => false,
                'choices'  => [
                    'Libre' => false,
                    'Habitée' => true,]
                ])
            // ->add('activate')
            // ->add('date_add')
            // ->add('date_update')
            // ->add('date_delete')
            
            //->add('locataires', EntityType::class, ['class' => LocatairesType::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Biens::class,
        ]);
    }
}
