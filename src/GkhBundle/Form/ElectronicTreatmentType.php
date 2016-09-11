<?php

namespace GkhBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ElectronicTreatmentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('place', 'text', array(
                'constraints' => array(
                    new NotBlank(array('message' => 'Поле "Место обращения" обязательно для заполнения.')),
                )
            ))
            ->add('fio', 'text', array(
                'constraints' => array(
                    new NotBlank(array('message' => 'Поле "ФИО" обязательно для заполнения.')),
                )
            ))
            ->add('address', 'text', array(
                'constraints' => array(
                    new NotBlank(array('message' => 'Поле "Адрес проживания" обязательно для заполнения.')),
                )
            ))
            ->add('phone', 'text', array(
                'constraints' => array(
                    new NotBlank(array('message' => 'Поле "Контактный телефон" обязательно для заполнения.')),
                )
            ))
            ->add('answer', 'choice', array(
                'choices' => array(
                    '1' => 'по эл. почте:',
                    '2' => 'на почту по адресу проживания'
                ),
                'expanded' => true,
                'data' => '1'
            ))
            ->add('email', 'text', array(
                'constraints' => array(
                    new Email(array('message' => 'Неверный формат e-mail')),
                ),
                'required' => false
            ))
            ->add('message', 'textarea', array(
                'constraints' => array(
                    new NotBlank(array('message' => 'Поле "Текст сообщения" обязательно для заполнения.')),
                )
            ))
            ->add('doc', 'file');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GkhBundle\Entity\ElectronicTreatment'
        ));
    }
}
