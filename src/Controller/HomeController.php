<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\httpFoundation\Response;


class HomeController extends AbstractController {

    #[Route('/', name:"landingpage", methods: ['GET'])]
    public function dashboard()
    {
        return $this->render("pages/landingpage.html.twig");
    }

}