<?php

namespace mtBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\Request;

class LignefraisforfaitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      
        
        $builder
                ->add('annee')
                ->add('mois')
                ->add('quantite')
                ->add('idfraisforfait', \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class,
                        array('choices'=>array('Forfait Etape'=>'ETP','Frais Kilométrique'=>'KM','Nuit hôtel'=>'NUI','Repas restaurant'=>'REP'),'expanded'=>true,'multiple'=>FALSE))->add('valider', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class)->add('annuler', \Symfony\Component\Form\Extension\Core\Type\ResetType::class);
                
                
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'mtBundle\Entity\Lignefraisforfait'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mtbundle_lignefraisforfait';
    }


}
