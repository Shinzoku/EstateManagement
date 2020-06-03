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
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

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
            ->add('images', FileType::class, [
                'translation_domain' => false,
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the file
                // every time you edit the Product details
                'required' => false,
                'multiple' => true,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                    // 'constraints' => [
                    //     new File([
                    //         'maxSize' => '1000M',
                    //         'mimeTypes' => [
                    //             'image/*',
                    //         ],
                    //         'mimeTypesMessage' => 'Please upload a valid Picture',
                    //     ])
                    // ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Biens::class,
        ]);
    }
}
