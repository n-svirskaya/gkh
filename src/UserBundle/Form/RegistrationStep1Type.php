<?php

namespace UserBundle\Form;

use GkhBundle\Validator\Constraints\CheckIfGkhNumberExist;
use GkhBundle\Validator\Constraints\CheckIfGkhNumberExistValidator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationStep1Type extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('privateNumber', 'text', array(
                'mapped' => false,
                'constraints' => array(
                    new NotBlank()
                )
            ))
            ->add('gkhNumber', 'text', array(
                'mapped' => false,
                'constraints' => array(
                    new NotBlank(),
                    new CheckIfGkhNumberExist()
                )
            ))
            ->add('email', 'text', array('mapped' => false));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' =>  null,
            'constraints' => array()
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'registration_step1';
    }
}
