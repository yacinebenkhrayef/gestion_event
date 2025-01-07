<?php


namespace App\Form;

use App\Entity\Participant;
use App\Entity\Collaboration;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollaborationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la collaboration',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le nom de la collaboration',
                ],
            ])
            ->add('details', TextareaType::class, [
                'label' => 'Détails',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez les détails de la collaboration',
                    'rows' => 5,
                ],
            ])
            ->add('participants', EntityType::class, [
                'class' => Participant::class,
                'choice_label' => function (Participant $participant) {
                    return $participant->getFirstName() . ' ' . $participant->getLastName();
                },
                'multiple' => true,
                'expanded' => true, // Checkbox (true) ou liste déroulante (false)
                'label' => 'Participants',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Collaboration::class,
        ]);
    }
}
