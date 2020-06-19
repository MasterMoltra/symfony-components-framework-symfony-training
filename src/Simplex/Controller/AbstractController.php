<?php

namespace App\Simplex\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    public function render(Request $request): Response
    {
        // print_r($request->attributes->all());
        extract($request->attributes->all(), EXTR_SKIP);
        ob_start();
        include sprintf(__DIR__ . '/../../templates/%s.php', $request->attributes->get('_route'));

        return new Response(ob_get_clean());
    }
}
