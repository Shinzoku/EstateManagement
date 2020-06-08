<?php

namespace App\Form;

use App\Entity\Locataires;
use Shinzoku\RecaptchaBundle\Type\RecaptchaSubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class LocatairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('noms', TextType::class, ['attr' => ['placeholder' => 'ex: Pelut'], 'translation_domain' => false,])
            ->add('prenoms', TextType::class, ['attr' => ['placeholder' => 'ex: Jean'], 'translation_domain' => false,])
            ->add('date_de_naissances', BirthdayType::class, [
                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,
                // adds a class that can be selected in JavaScript
                'format' => 'dd-MM-yyyy',
                'translation_domain' => false,
            ])
            ->add('lieu_de_naissances', TextType::class, ['attr' => ['placeholder' => 'ex: LIEVIN'], 'translation_domain' => false,])
            ->add('email', EmailType::class, ['attr' => ['placeholder' => 'ex: exemple@email.com'], 'translation_domain' => false,])
            ->add('telephones', TextType::class, ['attr' => ['placeholder' => 'ex: 06-56-45-31-20'], 'translation_domain' => false,])
            ->add('situation_de_familles', TextType::class, ['attr' => ['placeholder' => 'ex: Célibataire, 1 enfant.'], 'translation_domain' => false,])
            ->add('password', PasswordType::class, ['required' => false,])
            ->add('newsletter', CheckboxType::class, ['required' => false,])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Locataires::class,
        ]);
    }
}
