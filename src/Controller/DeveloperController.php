<?php

namespace App\Controller;

use App\Entity\Developer;
use App\Entity\Project;
use App\Form\DeveloperType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeveloperController extends AbstractController
{
    #[Route('/developers', name: 'developers_list', methods: ['GET'])]
    public function listDevelopers(EntityManagerInterface $entityManager): Response
    {
        $developers = $entityManager->getRepository(Developer::class)->findAll();

        return $this->render('developer/developers_list.html.twig', [
            'developers' => $developers,
        ]);
    }

    #[Route('/developer/new', name: 'new_developer', methods: ['GET', 'POST'])]
    public function newDeveloper(Request $request, EntityManagerInterface $entityManager): Response
    {
        $developer = new Developer();
        $form = $this->createForm(DeveloperType::class, $developer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $projects = $developer->getProjects();

            foreach ($projects as $project) {
                $existingProject = $entityManager->getRepository(Project::class)->find($project->getId());

                if (!$existingProject) {
                    $this->addFlash('error', 'Selected project does not exist');
                    return $this->redirectToRoute('new_developer');
                }

                if (!$existingProject->IsActive()) {
                    $this->addFlash('error', 'Selected project is closed and cannot be assigned');
                    return $this->redirectToRoute('new_developer');
                }
            }

            $entityManager->persist($developer);
            $entityManager->flush();

            return $this->redirectToRoute('developers_list');
        }

        return $this->render('developer/developer_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/developer/edit/{id}', name: 'edit_developer', methods: ['GET', 'POST'])]
    public function editDeveloper(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $developer = $entityManager->getRepository(Developer::class)->find($id);

        if (!$developer) {
            throw $this->createNotFoundException('Developer not found');
        }

        $form = $this->createForm(DeveloperType::class, $developer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('developers_list');
        }

        return $this->render('developer/developer_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/developer/delete/{id}', name: 'delete_developer', methods: ['POST'])]
    public function deleteDeveloper(int $id, EntityManagerInterface $entityManager): Response
    {
        $developer = $entityManager->getRepository(Developer::class)->find($id);
        if (!$developer) {
            throw $this->createNotFoundException('Developer not found');
        }

        $entityManager->remove($developer);
        $entityManager->flush();

        return $this->redirectToRoute('developers_list');
    }
}
