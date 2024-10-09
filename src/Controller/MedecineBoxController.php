<?php

namespace App\Controller;

use App\Repository\MedecineBoxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MedecineBoxController extends AbstractController
{
    #[Route('/medecine/box', name: 'app_medecine_box')]
    public function index(MedecineBoxRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $medecineBoxs = $repository->findAll();
        $jsonMedecineBoxs = $serializer->serialize($medecineBoxs, 'json');
        return new JsonResponse($jsonMedecineBoxs, Response::HTTP_OK, [], true);
    }
}
