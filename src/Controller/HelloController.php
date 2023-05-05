<?php
//
//namespace Controller;
//
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Annotation\Route;
//
////use Symfony\Component\Routing\Annotation\Route;
//
//#[Route('/hello')]
//class HelloController
//{
//    /**
//     * @param string $name
//     *
//     * @return Response
//     */
//    //#[Route('/hello', name: 'hello_index', methods: 'GET')]
//    //#[Route('/hello', name: 'hello_index', methods: 'POST/GET')]
//    #[Route(
//        '/{name}',
//        name: 'hello_index',
//        requirements: ['name' => '[a-zA-Z]+'],
//        defaults: ['name' => 'World'],
//        methods: 'GET',
//        )]
//    public function index(string $name): Response
//    {
//
////        $name = $request->query->getAlnum('name', 'World');
//        return new Response('Hello' . $name  . '!');
//    }
//}
