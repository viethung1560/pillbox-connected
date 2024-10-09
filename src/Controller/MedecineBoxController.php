<?php

namespace App\Controller;

use App\Entity\Drug;
use App\Entity\MedecineBox;
use App\Repository\MedecineBoxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

class MedecineBoxController extends AbstractController
{
    #[Route('/medecine_boxes', name: 'app_medecine_boxes')]
    public function index(MedecineBoxRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $medecineBoxes = $repository->findAll();
        $jsonMedecineBoxes = $serializer->serialize($medecineBoxes, 'json');
        return new JsonResponse($jsonMedecineBoxes, Response::HTTP_OK, [], true);
    }

    #[Route('/medecine_box/{id}', name: 'app_medecine_box')]
    public function details(int $id, MedecineBoxRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $medecineBox = $repository->find($id);
        if (!$medecineBox) {
            return new JsonResponse(['error' => 'MedicineBox not found'], Response::HTTP_NOT_FOUND);
        }
        $jsonMedecineBox = $serializer->serialize($medecineBox, 'json');
        return new JsonResponse($jsonMedecineBox, Response::HTTP_OK, [], true);
    }

    #[Route('/api/medecine_box', name: 'createMedecineBox', methods:['POST'])]
    public function createMedecineBox(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        if (!isset($data['drug_id'])) {
            return new Response('drug_id is required', 400);
        }

        $drug = $em->getRepository(Drug::class)->find($data['drug_id']);
        if (!$drug) {
            return new Response('Drug not found', 404);
        }

        $medecineBox = $serializer->deserialize($request->getContent(), MedecineBox::class, 'json');
        $medecineBox->setDrug($drug);
        
        $em->persist($medecineBox);
        $em->flush();

        $jsonMedecineBox = $serializer->serialize($medecineBox, 'json');
        
        $location = $urlGenerator->generate('createMedecineBox', ['id' => $medecineBox->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonMedecineBox, Response::HTTP_CREATED, ["Location" => $location], true);
    }
}
