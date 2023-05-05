<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserData;
use App\Repository\UserRepository;
use App\Form\Type\ChangePasswordType;
use App\Service\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('user')]
class UserController extends AbstractController
{

    private UserServiceInterface $userService;

    private TranslatorInterface $translator;


    public function __construct(UserServiceInterface $userService, TranslatorInterface $translator) {
        $this->userService = $userService;
        $this->translator = $translator;
    }

    /**
     * @param UserRepository $userRepository
     *
     * @return Response
     */
    #[Route(name: 'user_index', methods: 'GET')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render(
            'user/index.html.twig',
            ['users' => $users]
        );
    }

    /**
     * @param User $user
     *
     * @return Response
     */
    #[Route(
        '/{id}',
        name: 'user_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(User $user): Response
    {
        return $this->render(
            'user/show.html.twig',
            [
                'user' => $user,
            ]
        );
    }

    /**
     * @param Request $request
     * @param User $user
     * @param UserPasswordHasherInterface $passwordHasher
     *
     * @return Response
     */
    #[Route(
        '/{id}/edit',
        name: 'change_password',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|PUT'
    )]
    public function changePassword(Request $request, User $user, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(ChangePasswordType::class, $user, ['method' => 'PUT',
                'action' => $this->generateUrl(
                    'change_password',
                    ['id' => $user->getId()]
                ),
            ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $this->userService->save($user);

            $this->addFlash(
                'success',
                $this->translator->trans('message.updated_successfully')
            );

            return $this->redirectToRoute('dance_index');
        }

        return $this->render(
            'user/change_password.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ]
        );
    }
}