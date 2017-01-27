<?php

namespace UCI\Boson\TrazasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DataType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('action')
            ->add('performance')
            ->add('exception')
            ->add('data')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UCI\Boson\TrazasBundle\Entity\Data'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'uci_boson_trazasbundle_data';
    }
}
