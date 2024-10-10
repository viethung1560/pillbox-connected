<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

class CorsListener
{
    public function onKernelResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();
        $request = $event->getRequest();

        // Autoriser les requêtes provenant de toutes les origines
        $response->headers->set('Access-Control-Allow-Origin', '*');

        // Autoriser les méthodes HTTP spécifiques
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

        // Autoriser les en-têtes spécifiques
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        // Si c'est une requête OPTIONS, définir un statut 200
        if ($request->getMethod() === "OPTIONS") {
            $response->setStatusCode(200);
        }
    }
}