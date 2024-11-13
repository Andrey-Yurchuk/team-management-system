<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProjectController extends AbstractController
{
    #[Route('/projects', name: 'projects_list', methods: ['GET'])]
    public function listProjects(EntityManagerInterface $entityManager): Response
    {
        $projects = $entityManager->getRepository(Project::class)->findAll();

        return $this->render('project/projects_list.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/project/new', name: 'new_project', methods: ['GET', 'POST'])]
    public function newProject(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('projects_list');
        }

        return $this->render('project/project_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/project/edit/{id}', name: 'edit_project', methods: ['GET', 'POST'])]
    public function editProject(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = $entityManager->getRepository(Project::class)->find($id);

        if (!$project) {
            throw $this->createNotFoundException('Project not found');
        }

        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('projects_list');
        }

        return $this->render('project/project_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/project/delete/{id}', name: 'delete_project', methods: ['POST'])]
    public function deleteProject(int $id, EntityManagerInterface $entityManager): Response
    {
        $project = $entityManager->getRepository(Project::class)->find($id);
        if (!$project) {
            throw $this->createNotFoundException('Project not found');
        }

        $entityManager->remove($project);
        $entityManager->flush();

        return $this->redirectToRoute('projects_list');
    }
}
