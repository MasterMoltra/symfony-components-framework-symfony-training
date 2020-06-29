<?php

namespace App\Api\Controller;

use App\Simplex\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;


class BooksController extends AbstractController
{

    public function list()
    {
        return new JsonResponse([
            'details' => 'Details of books list...'
        ]);
    }

    public function get(int $id)
    {
        return new JsonResponse([
            'details' => 'Details of books with id:' . $id
        ]);
    }
    public function getAuthors(int $id)
    {
        return new JsonResponse([
            'authors' => 'Authors of book with id: ' . $id
        ]);
    }
}
