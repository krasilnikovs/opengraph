<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property\Extractor\Exception;
use RuntimeException;

final class PropertyNotExtractedException extends RuntimeException
{
    public static function requiredNotEmptyValueForProperty(string $propertyName): self
    {
        return new self(sprintf('Required not empty value for property "%s"', $propertyName));
    }

    public static function atLeastOneElementRequiredForProperty(string $propertyName): self
    {
        return new self(sprintf('At least one element required for property "%s"', $propertyName));
    }
}
