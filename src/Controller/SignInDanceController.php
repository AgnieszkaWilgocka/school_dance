<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\SignInDanceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/signInDance')]
class SignInDanceController extends AbstractController
{
//    /**
//     * @param Request $request
//     * @param User $user
//     *
//     * @return void
//     */
//    #[Route(
//        name: 'sign_in_dance',
//        methods: 'GET|POST'
//    )]
//    public function create(Request $request, User $user) {
//        //$user = $this->getUser();
//
//        $form = $this->createForm(SignInDanceType::class, $user);
//
////        if ($form->isSubmitted() && $form->isValid()) {
////            $user->setDances($form->get('dances')->getData());
////        }
//    }
}