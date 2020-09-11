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

            $todo = json_decode($request->getContent(), true);

            $newTodo = new Todo();
            $newTodo->setIdFront($todo['id']);
            $newTodo->setTitle($todo['title']);
            $newTodo->setCompleted($todo['completed']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($newTodo);
            $em->flush();

            return new JsonResponse(
                'OK',
                200,
                ['Access-Control-Allow-Origin' => '*']
            );
        } else {
            $todos = $this->getDoctrine()->getRepository(Todo::class)->findAll();

            $arrayTodos = [];

            foreach ($todos as $todo) {
                /** @var Todo $todo */
                $temp = [
                    'id' => $todo->getId(),
                    'title' => $todo->getTitle(),
                    'completed' => $todo->getCompleted(),
                ];

                array_push($arrayTodos, $temp);
            }

            return $this->json([
                $arrayTodos
            ], 200,
            ['Access-Control-Allow-Origin' => '*']);
        }
    }

    public function getTodoId($id)
    {
        $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);

        return new JsonResponse(
            $todo, 200, ['Access-Control-Allow-Origin' => '*']
        );
    }
}

