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
}
