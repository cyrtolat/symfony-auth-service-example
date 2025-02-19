<?php

namespace App\Infrastructure\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ConstantNormalizer implements NormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof \UnitEnum;
    }

    public function normalize($data, string $format = null, array $context = []): float|int|bool|\ArrayObject|array|string|null
    {
        if ($data instanceof \UnitEnum) return $data->name;

        throw new \InvalidArgumentException('The object must be an instance of UnitEnum.');
    }

    public function getSupportedTypes(?string $format): array
    {
        return [\UnitEnum::class => true];
    }
}