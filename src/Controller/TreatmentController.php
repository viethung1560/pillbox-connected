<?php

namespace App\Controller;

use App\Entity\Treatment;
use App\Entity\TreatmentTime;
use App\Repository\TreatmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class TreatmentController extends AbstractController
{
    #[Route('/treatment', name: 'treatments', methods: ['GET'])]
    public function index(TreatmentRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $treatments = $repository->findAll();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (Treatment $object, ?string $format, array $context): int {
                return $object->getId();
            },
            'datetime_format' => 'Y-m-d H:i:s',
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([new DateTimeNormalizer(), $normalizer], [$encoder]);

        $jsonTreatments = $serializer->serialize($treatments, 'json');
        return new JsonResponse($jsonTreatments, Response::HTTP_OK, [], true);
    }

    #[Route('/treatment/{id}', name: 'treatmentId', methods: ['GET'])]
    public function treatmentById(TreatmentRepository $repository, $id): JsonResponse
    {
        $treatment = $repository->find($id);

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (Treatment $object, ?string $format, array $context): int {
                return $object->getId();
            },
            'datetime_format' => 'Y-m-d H:i:s',
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([new DateTimeNormalizer(), $normalizer], [$encoder]);

        $jsonTreatments = $serializer->serialize($treatment, 'json');
        return new JsonResponse($jsonTreatments, Response::HTTP_OK, [], true);
    }


}