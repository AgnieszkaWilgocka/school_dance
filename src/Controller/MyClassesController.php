<?php

namespace App\Controller;

use App\Entity\MyClasses;
use App\Service\DanceService;
use App\Service\MyClassesService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/my_classes')]
class MyClassesController extends AbstractController
{
    private MyClassesService $myClassesService;

    private TranslatorInterface $translator;

    private DanceService $danceService;

    public function __construct(MyClassesService $myClassesService, TranslatorInterface $translator, DanceService $danceService)
    {
        $this->myClassesService = $myClassesService;
        $this->translator = $translator;
        $this->danceService = $danceService;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    #[Route(name: 'my_classes_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->myClassesService->getPaginatedList(
            $request->query->getInt('page', 1),
            $this->getUser()
        );

        return $this->render(
            'myClasses/index.html.twig',
            [
                'pagination' => $pagination
            ]
        );
    }

    /**
     * @param Request $request
     * @param MyClasses $myClasses
     *
     * @return Response
     *
     * @IsGranted("ROLE_USER")
     */
    #[Route('/{id}/delete',
        name: 'my_classes_delete',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|DELETE'
    )]
    #[IsGranted("DELETE", subject: 'myClasses')]
    public function delete(Request $request, MyClasses $myClasses): Response
    {
        $form = $this->createForm(
            FormType::class, $myClasses,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('my_classes_delete', ['id' => $myClasses->getId()])
            ]
        );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $dance = $myClasses->getDance();
            $spot = $dance->getField();
            $spot++;
            $dance->setField($spot);
            $this->danceService->save($dance);
            $this->myClassesService->delete($myClasses);

            $this->addFlash(
                'success',
                $this->translator->trans('message.signed_off_successfully')
            );

            return $this->redirectToRoute('my_classes_index');
        }

        return $this->render(
            'myClasses/delete.html.twig',
            [
                'form' => $form->createView(),
                'my_classes' => $myClasses
            ]
        );
    }
}
