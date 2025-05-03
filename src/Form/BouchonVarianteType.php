<?php

namespace App\Form;

use App\Entity\AntenneCouleur;
use App\Entity\AntenneLongueur;
use App\Entity\Bouchon;
use App\Entity\BouchonVariante;
use App\Entity\Couleur;
use App\Entity\GrammageCorps;
use App\Entity\QuilleLongueur;
use App\Entity\TypeCorps;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BouchonVarianteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix')
            ->add('stock')
            ->add('codeSku')
            ->add('actif')
            ->add('poidsTotal')
            ->add('imageUrl')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('bouchon', EntityType::class, [
                'class' => Bouchon::class,
                'choice_label' => 'id',
            ])
            ->add('typeCorps', EntityType::class, [
                'class' => TypeCorps::class,
                'choice_label' => 'id',
            ])
            ->add('grammageCorps', EntityType::class, [
                'class' => GrammageCorps::class,
                'choice_label' => 'id',
            ])
            ->add('antenneCouleur', EntityType::class, [
                'class' => AntenneCouleur::class,
                'choice_label' => 'id',
            ])
            ->add('antenneLongueur', EntityType::class, [
                'class' => AntenneLongueur::class,
                'choice_label' => 'id',
            ])
            ->add('quilleLongueur', EntityType::class, [
                'class' => QuilleLongueur::class,
                'choice_label' => 'id',
            ])
            ->add('couleur', EntityType::class, [
                'class' => Couleur::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BouchonVariante::class,
        ]);
    }
}
