<?php

namespace App\Infrastructure\Support;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class JsonResponder
{
    public function __construct(private SerializerInterface $serializer) {}

    public function toResponse(mixed $data, int $code = Response::HTTP_OK): JsonResponse
    {
        $json = $this->serializer->serialize($data, 'json', [
            'json_encode_options' => JSON_PRETTY_PRINT]);

        return new JsonResponse($json, $code, [], true);
    }
}