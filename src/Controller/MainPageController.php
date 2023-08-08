<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainPage Controller
 */
#[Route('/main_page')]
class MainPageController extends AbstractController
{
    /**
     * @return Response
     */
    #[Route(
        name: 'main_page'
    )]
    public function main_page(): Response
    {
        return $this->render('main/index.html.twig');
    }

    /**
     * @return Response
     */
    #[Route(
        '/salsa_dance',
        name: 'salsa_dance'
    )]
    public function salsa(): Response
    {
        return $this->render('main/salsa.html.twig');
    }

    /**
     * @return Response
     */
    #[Route(
        '/hip-hop_dance',
        name: 'hip-hop_dance'
    )]
    public function hiphop(): Response
    {
        return $this->render('main/hip-hop.html.twig');
    }

    /**
     * @return Response
     */
    #[Route(
        '/tap_dance',
        name: 'tap_dance'
    )]
    public function tapdance(): Response
    {
        return $this->render('main/tap-dance.html.twig');
    }

    /**
     * @return Response
     */
    #[Route(
        '/modern_dance',
        name: 'modern_dance'
    )]
    public function modern(): Response
    {
        return $this->render('main/modern.html.twig');
    }

    /**
     * @return Response
     */
    #[Route(
        '/popping_dance',
        name: 'popping_dance'
    )]
    public function popping(): Response
    {
        return $this->render('main/popping.html.twig');
    }

    /**
     * @return Response
     */
    #[Route(
        '/vogue_dance',
        name: 'vogue_dance'
    )]
    public function vogue(): Response
    {
        return $this->render('main/vogue.html.twig');
    }
}
