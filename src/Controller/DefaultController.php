<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Todo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public function index(): JsonResponse
    {
        return new JsonResponse([
            [
                'id' => 1,
                'title' => 'test 1',
                'completed' => false,
            ],
        ], 200, ['Access-Control-Allow-Origin' => '*']);
    }

    public function getTodo(Request $request)
    {
        if ($request->isMethod('POST')) {
            $todo = json_decode($request->request->get('todo'));



            return new JsonResponse(
                'OK', 200
            );
        } else {
            $todos = $this->getDoctrine()->getRepository(Todo::class)->findAll();

            return new JsonResponse(
                $todos, 200
            );
        }
    }

    public function getTodoId(Todo $todo)
    {
        return new JsonResponse(
            $todo, 200
        );
    }
}

