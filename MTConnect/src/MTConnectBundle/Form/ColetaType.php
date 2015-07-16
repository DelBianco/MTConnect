<?php

namespace MTConnectBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ColetaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome')
            ->add('dataItems')
            ->add('probe')
            ->add('numDeColetas')
            ->add('dataDeCriacao')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MTConnectBundle\Entity\Coleta'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mtconnectbundle_coleta';
    }
}
