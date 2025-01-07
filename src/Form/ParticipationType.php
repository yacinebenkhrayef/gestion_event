<?php

namespace App\Form;

use App\Entity\Collaboration;
use App\Entity\Participant;
use App\Entity\Participation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('participant', EntityType::class, [
                'class' => Participant::class,
                'choice_label' => function (Participant $participant) {
                    return $participant->getFirstName() . ' ' . $participant->getLastName();
                },
                'label' => 'Participant',
                'attr' => ['class' => 'form-control'], // Bootstrap
            ])
            ->add('collaboration', EntityType::class, [
                'class' => Collaboration::class,
                'choice_label' => 'name',
                'label' => 'Collaboration',
                'attr' => ['class' => 'form-control'], // Bootstrap
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participation::class,
        ]);
    }
}
