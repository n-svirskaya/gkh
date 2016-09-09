<?php

namespace UserBundle\Form;

use GkhBundle\Validator\Constraints\CheckIfGkhEmailExist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationStep2Type extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'text', array(
                'mapped' => false,
                'constraints' => array(
                    new NotBlank(),
                    new CheckIfGkhEmailExist(),
                    new Email(array('message' => 'Неверный формат e-mail')),
                )
            ))
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Пароли не совпали. Попробуйте еще раз.',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options'  => array('label' => 'Пароль'),
                'second_options' => array('label' => 'Повторите пароль'),
                'constraints' => new Length(array('min' => 6, 'minMessage' => 'Пароль должен быть не менее 6 символов')),
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' =>  null
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'registration_step2';
    }
}
