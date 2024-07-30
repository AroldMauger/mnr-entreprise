<?php

namespace App\Controller;

use App\Entity\Works;
use App\Form\WorksType;
use App\Repository\WorksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class WorksController extends AbstractController
{
    #[Route('/add-work', name: 'add-work')]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $work = new Works();
        $form = $this->createForm(WorksType::class, $work);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception if something happens during file upload
                }

                $work->setImage($newFilename);
            }

            $entityManager->persist($work);
            $entityManager->flush();

            return $this->redirectToRoute('success');
        }

        return $this->render('pages/add-work.html.twig', [
            'work' => $work,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/api/works', name: 'api_works', methods: ['GET'])]
    public function getWorks(EntityManagerInterface $em): JsonResponse
    {
        $works = $em->getRepository(Works::class)->findAll();
        $worksArray = [];

        foreach ($works as $work) {
            $worksArray[] = [
                'id' => $work->getId(),
                'title' => $work->getTitle(),
                'image' => $work->getImage(),
                'date' => $work->getDate()->format('Y-m-d'),
                'category' => $work->getCategory(),
                'status' => $work->getStatus()

            ];
        }

        return new JsonResponse($worksArray);
    }

    #[Route('/api/works/{id}', name: 'api_delete_work', methods: ['DELETE'])]
    public function deleteWork(int $id, EntityManagerInterface $em): Response
    {
        $work = $em->getRepository(Works::class)->find($id);

        if (!$work) {
            return new JsonResponse(['error' => 'Work not found'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($work);
        $em->flush();

        return new JsonResponse(['status' => 'Work deleted'], Response::HTTP_NO_CONTENT);
    }
    #[Route('/api/works', name: 'delete_all_works', methods: ['DELETE'])]
    public function deleteAllWorks(WorksRepository $worksRepository, EntityManagerInterface $entityManager): Response
    {
        $works = $worksRepository->findAll();

        foreach ($works as $work) {
            $entityManager->remove($work);
        }

        $entityManager->flush();

        return new Response('Galerie supprimée avec succès', Response::HTTP_OK);
    }



}


