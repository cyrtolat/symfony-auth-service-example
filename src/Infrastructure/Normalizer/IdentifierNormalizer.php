<?php

namespace App\Infrastructure\Normalizer;

use App\Domain\Abstract\AbstractId;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class IdentifierNormalizer implements NormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof AbstractId;
    }

    public function normalize($data, string $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null
    {
        if ($data instanceof AbstractId) return $data->getValue();

        throw new \InvalidArgumentException('The object must be an instance of AbstractId.');
    }

    public function getSupportedTypes(?string $format): array
    {
        return [AbstractId::class => true];
    }
}