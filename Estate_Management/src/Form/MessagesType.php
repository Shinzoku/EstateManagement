<?php

namespace App\Form;

use App\Entity\Messages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('emails', EmailType::class, [
                'attr' => [
                    'id' => 'email',
                    'class' => 'text ui-widget-content ui-corner-all w-100',
                ]
            ])
            ->add('objets', TextType::class, [
                'attr' => [
                    'id' => 'objet',
                    'class' => 'text ui-widget-content ui-corner-all w-100'
                ]
            ])
            ->add('demandes', TextareaType::class, [
                'attr' => [
                    'rows' => '6',
                    'id' => 'message',
                    'class' => 'text ui-widget-content ui-corner-all w-100'
                    ]])
            // ->add('activate')
            // ->add('date_add')
            // ->add('date_update')
            // ->add('date_delete')
            // ->add('biens')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
        ]);
    }
}
