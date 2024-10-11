<?php

namespace App\Controller;

use App\Entity\Treatment;
use App\Repository\MedecineBoxRepository;
use App\Repository\TreatmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use HttpResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class TreatmentController extends AbstractController
{
    #[Route('/treatment', name: 'createTreatment', methods: ['POST'])]
    public function createTreatment(Request $request, SerializerInterface $serializer,MedecineBoxRepository $medecineBoxRepository , EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator): JsonResponse
    {
        $treatment = $serializer->deserialize($request->getContent(), Treatment::class, 'json');

        $data = json_decode($request->getContent(), true);

        if (!isset($data['medecine_box_id'])) {
            return new JsonResponse('medecine_box is required', 400);
        }

        if (!$medecineBoxRepository->find($data['medecine_box_id'])) {
            return new JsonResponse('medecine_box not found', 400);
        }

        $treatment->setMedecineBox($medecineBoxRepository->find($data['medecine_box_id']));


        $em->persist($treatment);
        $em->flush();

        $jsonTreatments = $serializer->serialize($treatment, 'json');

        $location = $urlGenerator->generate('treatmentId', ['id' => $treatment->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonTreatments, Response::HTTP_CREATED, ["Location" => $location], true);
    }
    #[Route('/treatment', name: 'treatments', methods: ['GET'])]
    public function getTreatments(TreatmentRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $treatments = $repository->findAll();
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (Treatment $object, ?string $format, array $context): int {
                return $object->getId();
            },
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
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([new DateTimeNormalizer(), $normalizer], [$encoder]);

        $jsonTreatments = $serializer->serialize($treatment, 'json');
        return new JsonResponse($jsonTreatments, Response::HTTP_OK, [], true);
    }

    #[Route('/treatment/{id}', name: 'deleteTreatment', methods: ['DELETE'])]
    public function deleteTreatment(EntityManagerInterface $em, Treatment $treatment): JsonResponse
    {
        $treatmentTimes = $treatment->getTreatmentTimes();
        if (!$treatmentTimes->isEmpty()) {
            foreach ($treatmentTimes as $treatmentTime) {
                $em->remove($treatmentTime);
            }
        }

        $em->remove($treatment);
        $em->flush();

        return new JsonResponse(['message' => "Object deleted"], Response::HTTP_NO_CONTENT);
    }

}