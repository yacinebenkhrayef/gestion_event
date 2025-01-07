<?php
// src/Controller/ParticipationController.php
namespace App\Controller;

use App\Entity\Participation;
use App\Entity\Participant; // Assurez-vous que cette ligne est présente
use App\Entity\Collaboration; // Assurez-vous que cette ligne est présente
use App\Form\ParticipationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipationController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Afficher la liste des participations
    #[Route('/participation', name: 'participation_index', methods: ['GET'])]
    public function index(): Response
    {
        $participations = $this->entityManager->getRepository(Participation::class)->findAll();

        return $this->render('participation/index.html.twig', [
            'participations' => $participations,
        ]);
    }

    // Créer une nouvelle participation
    #[Route('/participation/new', name: 'participation_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $participation = new Participation();
        $form = $this->createForm(ParticipationType::class, $participation);

        // Récupération des options participants et collaborations pour le formulaire
        $participants = $this->entityManager->getRepository(Participant::class)->findAll();
        $collaborations = $this->entityManager->getRepository(Collaboration::class)->findAll();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($participation);
            $this->entityManager->flush();

            return $this->redirectToRoute('participation_index');
        }

        return $this->render('participation/new.html.twig', [
            'form' => $form->createView(),
            'participants' => $participants,
            'collaborations' => $collaborations,
        ]);
    }

    // Modifier une participation
    #[Route('/participation/edit/{id}', name: 'participation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Participation $participation): Response
    {
        $form = $this->createForm(ParticipationType::class, $participation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('participation_index');
        }

        return $this->render('participation/edit.html.twig', [
            'form' => $form->createView(),
            'participation' => $participation,
        ]);
    }

    // Afficher les détails d'une participation
    #[Route('/participation/{id}', name: 'participation_show', methods: ['GET'])]
    public function show(Participation $participation): Response
    {
        return $this->render('participation/show.html.twig', [
            'participation' => $participation,
        ]);
    }
}

