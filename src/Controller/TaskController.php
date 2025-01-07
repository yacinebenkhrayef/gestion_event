<?php

// src/Controller/TaskController.php
namespace App\Controller;
use App\Entity\Collaboration;
use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Afficher la liste des tâches
    #[Route('/task', name: 'task_index', methods: ['GET'])]
    public function index(): Response
    {
        $tasks = $this->entityManager->getRepository(Task::class)->findAll();

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    // Créer une nouvelle tâche
    #[Route('/task/new', name: 'task_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        // Récupération des collaborations pour le formulaire
        $collaborations = $this->entityManager->getRepository(Collaboration::class)->findAll();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($task);
            $this->entityManager->flush();

            return $this->redirectToRoute('task_index');
        }

        return $this->render('task/new.html.twig', [
            'form' => $form->createView(),
            'collaborations' => $collaborations, // Ajoutez les collaborations ici
        ]);
    }

    // Modifier une tâche
    #[Route('/task/edit/{id}', name: 'task_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Task $task): Response
    {
        // Récupération des collaborations pour le formulaire
        $collaborations = $this->entityManager->getRepository(Collaboration::class)->findAll();

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('task_index');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
            // Ajoutez les collaborations ici aussi
        ]);
    }

    // Supprimer une tâche
    #[Route('/task/delete/{id}', name: 'task_delete', methods: ['POST'])]
    public function delete(Request $request, Task $task): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($task);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('task_index');
    }

    // Afficher les détails d'une tâche
    #[Route('/task/{id}', name: 'task_show', methods: ['GET'])]
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }
}

