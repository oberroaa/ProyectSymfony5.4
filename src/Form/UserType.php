<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, array( 'attr' => ['class' => 'form-control'] ))
            ->add('roles', ChoiceType::class, array(
                'multiple' => true,
                'choices'  => [
                    'ROLE_USER'=>'ROLE_USER',
                    'ROLE_ADMIN'=>'ROLE_ADMIN'
                ],
                'label' => "Rol",
                'attr' => ['class' => 'form-control select2 required margin-bottom-10']))
           // ->add('password', PasswordType::class, array( 'attr' => ['class' => 'form-control'],'required' => false ))
            ->add('email', EmailType::class, array( 'attr' => ['class' => 'form-control required'] ))
          //  ->add('apiToken', TextType::class, array( 'attr' => ['class' => 'form-control'] ))
            //->add('dateRegistered', DateTimeType::class, array( 'attr' => ['class' => 'form-control datepicker'] ))
            // <input type="date" name="lastmine" value="" class="form-control">
            ->add('isVerified', CheckboxType::class, array( 'attr' => ['class' => 'form-control'],'required' => false ))
            ->add('picture', FileType::class, [
                'attr' => ['class' => 'form-control', 'onchange' => 'jQuery(this).next(\'input\').val(this.value)'],
                'label' => false,
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
               /* 'constraints' => [
                    new File([
                        'maxSize' => '202400k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Por favor veifique el formato de la foto',
                    ])
                ],*/
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
