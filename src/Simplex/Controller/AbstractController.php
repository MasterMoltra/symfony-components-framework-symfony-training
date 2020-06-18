<?php

namespace App\Simplex\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    public function render_template(Request $request): Response
    {
        // var_dump($request->attributes->all());

        extract($request->attributes->all(), EXTR_SKIP);
        ob_start();
        include sprintf(__DIR__ . '/../../templates/%s.php', $_route);

        return new Response(ob_get_clean());
    }
}
