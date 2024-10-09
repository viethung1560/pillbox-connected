<?php

namespace App\Controller;

use App\Entity\TreatmentTime;
use App\Repository\TreatmentRepository;
use App\Repository\TreatmentTimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

class TreatmentTimeController extends AbstractController
{
    #[Route('/treatments/time', name: 'createTreatmentTime', methods: ['POST'])]
    public function createTreatmentTime(Request $request, TreatmentRepository $treatmentRepository, SerializerInterface $serializer, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator): JsonResponse
    {

        $treatmentTime = $serializer->deserialize($request->getContent(), TreatmentTime::class, 'json');

        $content = $request->toArray();

        $treatment_id = $content['treatment_id'] ?? -1;

        $treatmentTime->setTreatment($treatmentRepository->find($treatment_id));

        $em->persist($treatmentTime);
        $em->flush();

        $jsonTreatmentTime = $serializer->serialize($treatmentTime, 'json', ['groups' => 'getTreatment']);

        $location = $urlGenerator->generate('treatmentId', ['id' => $treatmentTime->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonTreatmentTime, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route('/treatments/time', name: 'getTreatmentTime', methods: ['GET'])]
    public function getTreatmentTime(TreatmentTimeRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $treatmentTimes = $repository->findAll();
        $jsonTreatments = $serializer->serialize($treatmentTimes, 'json', ['groups' => 'getTreatment']);
        return new JsonResponse($jsonTreatments, Response::HTTP_OK, [], true);
    }

}
