<?php


namespace App\Controller;

use App\Entity\MyClasses;
use App\Form\Type\DanceType;
use App\Repository\MyClassesRepository;
use App\Service\DanceServiceInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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

    private MyClassesRepository $myClassesRepository;
    public function __construct(DanceServiceInterface $danceService, TranslatorInterface $translator, MyClassesRepository $myClassesRepository)
    {
        $this->danceService = $danceService;
        $this->translator = $translator;
        $this->myClassesRepository = $myClassesRepository;
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @IsGranted("ROLE_USER")
     */
    #[Route(name: 'dance_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $filters = $this->getFilters($request);
       $pagination = $this->danceService->getPaginatedList(
           $request->query->getInt('page', 1), $filters
       );

        return $this->render(
            'dance/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    public function getFilters(Request $request): array
    {
        $filters = [];
        $filters['tag_id'] = $request->query->getInt('filters_tag_id');

        return $filters;
    }

//    #[Route('/{id}',
//    name: 'dance_show',
//    requirements: ['id' => '[1-9]\d*'],
//    methods: 'GET',
//    )]
//    public function show(Dance $dance): Response
//    {
//        return $this->render(
//            'dance/show.html.twig',
//            ['dance' => $dance]
//        );
//    }

    /**
     * @param Request $request
     * @param Dance $dance
     *
     * @return Response
     *
     * @IsGranted("ROLE_USER")
     */
    #[Route(
        '/{id}/class',
        name: 'dance_signing',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|PUT'
    )]
    public function singing(Request $request, Dance $dance): Response
    {
        $myClassees = new MyClasses();
        $user = $this->getUser();
        $myClassees->setAuthor($user);
//        $tance = $myClasses->getId();


        $form = $this->createForm(DanceType::class, $dance,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('dance_signing', ['id' => $dance->getId()]),
            ]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dance_name = $form->get("name")->getData();
            var_dump($dance_name);

            $spot = $form->get("field")->getData();
            $spot--;
            $myClassees->setDance($dance);
            $dance->setField($spot);

            $this->myClassesRepository->save($myClassees);
            $this->danceService->save($dance);

            $this->addFlash(
                'success',
                $this->translator->trans('message.signed_up_successfully')
            );

            return $this->redirectToRoute('my_classes_index');
        }

        return $this->render(
            'dance/signing.html.twig',
            [
                'form' => $form->createView(),
                'dance' =>$dance,

            ]
        );
    }
    /**
     * @param Request $request
     *
     * @return Response
     *
     * @IsGranted("ROLE_ADMIN")
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

    /**
     * @param Request $request
     * @param Dance $dance
     *
     * @return Response
     *
     * @IsGranted("ROLE_ADMIN")
     */
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
     *
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route(
        '/{id}/delete',
        name: 'dance_delete',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|DELETE'
    )]
    public function delete(Request $request, Dance $dance): Response
    {
//        if($myClasses->getDance()->count()) {
//        if($dance->getField() < 20) {
        if(!$this->danceService->canBeDeleted($dance)) {
            $this->addFlash('warning', $this->translator->trans('message.dance_contains_my_classes'));

            return $this->redirectToRoute('dance_index');
        }

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