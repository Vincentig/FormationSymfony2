<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use \Symfony\Component\Form\Extension\Core\Type\FileType;

class ImageType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                //->add('url')
                ->add('file', \Symfony\Component\Form\Extension\Core\Type\FileType::class, array('required' => false))
                ->add('alt', null, array('required' => false))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Image'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'appbundle_image';
    }

}
