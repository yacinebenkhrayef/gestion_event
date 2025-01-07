<?php
// src/Controller/ParticipantController.php
namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    // Injection du service Doctrine dans le constructeur
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Afficher la liste des participants
    #[Route('/participant', name: 'participant_index', methods: ['GET'])]
    public function index(): Response
    {
        // Récupérer tous les participants depuis la base de données
        $participants = $this->entityManager->getRepository(Participant::class)->findAll();

        // Passer les participants à la vue
        return $this->render('participant/index.html.twig', [
            'participants' => $participants,  // Assurez-vous de passer 'participants' ici
        ]);
    }

    // Créer un nouveau participant
    #[Route('/participant/new', name: 'participant_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);

        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, enregistrer le participant
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($participant);
            $this->entityManager->flush();

            // Rediriger vers la liste des participants
            return $this->redirectToRoute('participant_index');
        }

        // Afficher le formulaire pour ajouter un nouveau participant
        return $this->render('participant/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Modifier un participant
    #[Route('/participant/edit/{id}', name: 'participant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Participant $participant): Response
    {
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, enregistrer les modifications
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            // Rediriger vers la liste des participants
            return $this->redirectToRoute('participant_index');
        }

        // Afficher le formulaire pour modifier un participant
        return $this->render('participant/edit.html.twig', [
            'form' => $form->createView(),
            'participant' => $participant,
        ]);
    }

    // Afficher les détails d'un participant
    #[Route('/participant/{id}', name: 'participant_show', methods: ['GET'])]
    public function show(Participant $participant): Response
    {
        return $this->render('participant/show.html.twig', [
            'participant' => $participant,
        ]);
    }
}
