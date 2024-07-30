<?php

namespace App\Controller;

use App\Repository\WorksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\httpFoundation\Response;


class HomeController extends AbstractController {

    #[Route('/', name:"landingpage", methods: ['GET'])]
    public function dashboard(WorksRepository $repo, Request $request)
    {
        $works = $repo->findAll();

        $categories = [];
        foreach ($works as $work) {
            $category = $work->getCategory();
            if (!in_array($category, $categories)) {
                $categories[] = $category;
            }
        }

        return $this->render("pages/landingpage.html.twig", [
            "works" => $works,
            "categories" => $categories
        ]);
    }
    #[Route('/filter', name: "filter_works", methods: ['GET'])]
    public function filterWorks(WorksRepository $repo, Request $request): JsonResponse
    {
        $category = $request->query->get('category');
        if ($category == 'Tous') {
            $works = $repo->findAll();
        } else {
            $works = $repo->findBy(['category' => $category]);
        }

        // Convert works to array
        $worksArray = [];
        foreach ($works as $work) {
            $worksArray[] = [
                'category' => $work->getCategory(),
                'image' => $work->getImage(),
                'date' => $work->getDate()->format('d/m/Y'),
                'title' => $work->getTitle(),
                'status' => $work->getStatus()
            ];
        }

        return new JsonResponse(['works' => $worksArray]);
    }

    #[Route('/admin', name:"adminpage", methods: ['GET'])]
    public function adminpage(WorksRepository $repo, Request $request)
    {
        $works = $repo->findAll();

        $categories = [];
        foreach ($works as $work) {
            $category = $work->getCategory();
            if (!in_array($category, $categories)) {
                $categories[] = $category;
            }
        }


        return $this->render("pages/adminpage.html.twig", ["works" => $works,  "categories" => $categories]);
    }

    #[Route('/success', name:"success", methods: ['GET'])]
    public function success()
    {
        return $this->render("pages/success.html.twig");
    }
}