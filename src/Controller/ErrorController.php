<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController
{
    #[Route('/403', name: 'access_denied')]
    public function accessDenied(): Response
    {
        return new Response('Accès interdit', Response::HTTP_FORBIDDEN);
    }
}
