<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use \Symfony\Bridge\Doctrine\Form\Type\EntityType;
use \Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ArticleType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('titre')
                ->add('contenu')
                ->add('date', DateTimeType::class, array('widget' => 'single_text'))
                ->add('auteur')
                ->add('publication', CheckboxType::class, array('required' => false))
                ->add('image', new ImageType())
                ->add('categories', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, array(
                    'class' => 'AppBundle:Categorie',
                    'property' => 'titre',
                    'multiple' => true,
                    'expanded' => true,
//                    'query_builder' => function($er) use ($produit){
//                    $qb = $er->createQueryBuilder('i');
//                    $qb->leftJoin('i.produits', 'p')
//                            ->where('p = :produit')
//                            ->setParameter('produit',$produit);
//                    return $qb;
//                    }
                ))
                ->add('testNonMapped', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array('required' => false, 'mapped' => false))
                ->add('ok', SubmitType::class)
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'appbundle_article';
    }

}
