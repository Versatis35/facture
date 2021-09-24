<?php

namespace App\Form;

use App\Entity\Ligne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LigneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produit', null, [
                'attr'=> ['class'=>'form-control'],
                'label'=> 'Article'
            ])
            ->add('quantite', null, [
                'attr'=> ['class'=>'form-control'],
                'label'=> 'Nombre'
            ])
            ->add('montant', null, [
                'attr'=> ['class'=>'form-control'],
                'label'=> 'Prix'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ligne::class,
        ]);
    }
}
