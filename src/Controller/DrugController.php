<?php

namespace App\Controller;

use App\Repository\DrugRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class DrugController extends AbstractController
{
    #[Route('/drug', name: 'app_drug')]
    public function index(DrugRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $drugs = $repository->findAll();
        $jsonDrugs = $serializer->serialize($drugs, 'json');
        return new JsonResponse($jsonDrugs, Response::HTTP_OK, [], true);
    }
}
