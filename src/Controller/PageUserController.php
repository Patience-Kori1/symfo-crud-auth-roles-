<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PageUserController extends AbstractController
{
    #[Route('/pageUser', name: 'app_page_user')]
    public function index(): Response
    {
        return $this->render('page_user/pageUser.html.twig', [
            'controller_name' => 'PageUserController',
        ]);
    }
}
