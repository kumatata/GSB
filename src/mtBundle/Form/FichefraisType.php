<?php

namespace mtBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FichefraisType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('datemodif')->add('idetat')->add('idvisiteur')->add('mois')->add('montantvalide')->add('nbjustificatifs')->add('annee',  CollectionType::class, array(

    'choices' => array('annee' => $options['fichefrais_annee'])

));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'mtBundle\Entity\Fichefrais',
        'annee'  => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mtbundle_fichefrais';
    }


}
