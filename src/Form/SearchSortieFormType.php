<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use App\Form\FormObject\SearchSortieObject;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchSortieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionnez un campus',
                'required' => true,
            ])
            // TODO add les 7 autres elements de recherche de la page d'accueil
            ->add('nomSortie', SearchType::class, [
                'label' => 'Le nom de la sortie contient : ',
            ])
            ->add('dateDebutSortie', DateType::class, [
                'label' => 'Entre'
            ])
            ->add('dateFinSortie', DateType::class, [
                'label' => 'et'
            ])
            ->add('sortiesOrganisateur', CheckboxType::class, [
                'label' => 'Sorties dont je suis l\'organisateur/trice'
            ])
            ->add('sortiesInscrit', CheckboxType::class, [
                'label' => 'Sorties auxquelles je suis l\'inscrit/e'
            ])
            ->add('sortiesPasInscrit', CheckboxType::class, [
                'label' => 'Sorties auxquelles je ne suis pas inscrit/e'
            ])
            ->add('sortiesPassees', CheckboxType::class, [
                'label' => 'Sorties passées'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchSortieObject::class,
        ]);
    }
}