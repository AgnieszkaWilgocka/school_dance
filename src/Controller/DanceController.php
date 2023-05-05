<?php


namespace App\Controller;

use App\Form\Type\DanceType;
use App\Service\DanceServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\DanceRepository;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Dance;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/dance')]
class DanceController extends AbstractController
{
    private DanceServiceInterface $danceService;

    private TranslatorInterface $translator;
    public function __construct(DanceServiceInterface $danceService, TranslatorInterface $translator)
    {
        $this->danceService = $danceService;
        $this->translator = $translator;
    }

    /**
     * @param DanceRepository $danceRepository
     *
     * @return Response
     *
     */
    #[Route(name: 'dance_index', methods: 'GET')]
    public function index(DanceRepository $danceRepository): Response
    {
        $dances = $danceRepository->findAll();

        return $this->render(
            'dance/index.html.twig',
            ['dances' => $dances]
        );
    }
    #[Route('/{id}',
    name: 'dance_show',
    requirements: ['id' => '[1-9]\d*'],
    methods: 'GET',
    )]
    public function show(Dance $dance): Response
    {
        return $this->render(
            'dance/show.html.twig',
            ['dance' => $dance]
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    #[Route('/create',
    name: 'dance_create',
    methods: 'GET|POST',
    )]
    public function create(Request $request): Response
    {
        $dance = new Dance();
        $form = $this->createForm(DanceType::class, $dance);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->danceService->save($dance);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('dance_index');
        }

        return $this->render(
            'dance/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    #[Route(
        '/{id}/edit',
        name: 'dance_edit',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|PUT'
    )]
    public function edit(Request $request, Dance $dance): Response
    {
        $form = $this->createForm(
            DanceType::class,
            $dance,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('dance_edit', ['id' => $dance->getId()]),
            ]
        );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->danceService->save($dance);

            $this->addFlash(
                'success',
                $this->translator->trans('message.updated_successfully')
            );

            return $this->redirectToRoute('dance_index');
        }

        return $this->render(
            'dance/edit.html.twig',
            [
                'form' => $form->createView(),
                'dance' => $dance,
            ]
        );
    }

    /**
     * @param Request $request
     * @param Dance $dance
     *
     * @return Response
     */
    #[Route(
        '/{id}/delete',
        name: 'dance_delete',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|DELETE'
    )]
    public function delete(Request $request, Dance $dance): Response
    {
        $form = $this->createForm(
            FormType::class,
            $dance,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('dance_delete', ['id' => $dance->getId()])
            ],
        );

        $form->handleRequest($request);
        if ($form -> isSubmitted() && $form->isValid()) {
           $this->danceService->delete($dance);

           $this->addFlash(
               'success',
               $this->translator->trans('message.deleted_successfully')
           );

           return $this->redirectToRoute('dance_index');
        }

        return $this->render(
            'dance/delete.html.twig',
            [
                'form' => $form->createView(),
                'dance' => $dance
            ]
        );
    }
}