<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\Type\TagType;
use App\Repository\TagRepository;
use App\Service\TagService;
use App\Service\TagServiceInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/tag')]
class TagController extends AbstractController
{
    private TagServiceInterface $tagService;

    private TranslatorInterface $translator;

    public function __construct(TagServiceInterface $tagService, TranslatorInterface $translator)
    {
        $this->tagService = $tagService;
        $this->translator = $translator;
    }

    /**
     * @param TagRepository $tagRepository
     *
     * @return Response
     *
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route(name: 'tag_index', methods: 'GET')]
    public function index(Request $request, TagRepository $tagRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $tagRepository->queryAll(),
            $request->query->getInt('page', 1),
            TagRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'tag/index.html.twig',
            [
                'pagination' => $pagination
            ]
        );
    }

//    /**
//     * @param Tag $tag
//     *
//     * @return Response
//     */
//    #[Route(
//        '/{id}',
//        name: 'tag_show',
//        requirements: ['id' => '[1-9]\d*'],
//        methods: 'GET'
//    )]
//    public function show(Tag $tag): Response
//    {
//        return $this->render(
//            'tag/show.html.twig',
//            [
//                'tag' => $tag
//            ]
//        );
//    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route(
        '/create',
        name: 'tag_create',
        methods: 'GET|POST'
    )]
    public function create(Request $request): Response
    {
        $tag = new Tag();
        $form = $this->createForm(
            TagType::class, $tag
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tag->setCreatedAt(new \DateTimeImmutable());
            $tag->setUpdatedAt(new \DateTimeImmutable());
            $this->tagService->save($tag);

            $this->addFlash('success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('tag_index');
        }

        return $this->render(
            'tag/create.html.twig',
            [
                'form' => $form->createView(),
                'tag' => $tag
            ]
        );
    }

    /**
     * @param Tag $tag
     * @param Request $request
     *
     * @return Response
     *
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route(
        '/{id}/edit',
        name: 'tag_edit',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|PUT'
    )]
    public function edit(Tag $tag, Request $request): Response
    {
        $form = $this->createForm(TagType::class, $tag,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('tag_edit', ['id' => $tag->getId()]),
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tag->setCreatedAt(new \DateTimeImmutable());
            $tag->setUpdatedAt(new \DateTimeImmutable());

            $this->tagService->save($tag);

            $this->addFlash(
                'success',
                $this->translator->trans('message.updated_successfully')
            );

            return $this->redirectToRoute('tag_index');
        }

        return $this->render(
            'tag/edit.html.twig',
            [
                'form' => $form->createView(),
                'tag' => $tag
            ]
        );
    }

    /**
     * @param Tag $tag
     * @param Request $request
     *
     * @return Response
     *
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route(
        '/{id}/delete',
        name: 'tag_delete',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|DELETE'
    )]
    public function delete(Tag $tag, Request $request): Response
    {
        $form = $this->createForm(FormType::class, $tag,
        [
            'method' => 'DELETE',
            'action' => $this->generateUrl('tag_delete', ['id' => $tag->getId()])
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->tagService->delete($tag);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('tag_index');
        }

        return $this->render(
            'tag/delete.html.twig',
            [
                'form' => $form->createView(),
                'tag' => $tag
            ]
        );
    }
}