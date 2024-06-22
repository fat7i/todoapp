<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Service\Attribute\Required;

class AbstractApiController extends AbstractController
{
    #[Required]
    public SerializerInterface $serializer;

    public function response(mixed $data = [], int $statusCode = Response::HTTP_OK, ?string $message = null): JsonResponse
    {
        try {
            $json = $this->serializer->serialize(
                $data,
                JsonEncoder::FORMAT,
                ['json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS]
            );

            return new JsonResponse($json, $statusCode, [], true);
        } catch (\Exception $e) {
            $response = [
                'error' => $e->getMessage(),
            ];

            return new JsonResponse($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}