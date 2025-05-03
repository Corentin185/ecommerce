<?php

namespace App\Form;

use App\Entity\AntenneCouleur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AntenneCouleurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('couleur', EntityType::class, [
                'class' => AntenneCouleur::class,
                'choice_label' => 'couleur', // ce champ sera affiché dans le menu
                'placeholder' => 'Choisissez une couleur',
                'label' => 'Couleur d\'antenne',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AntenneCouleur::class,
        ]);
    }
}
