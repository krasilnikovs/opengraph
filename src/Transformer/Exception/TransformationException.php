<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer\Exception;

use RuntimeException;
use Throwable;

final class TransformationException extends RuntimeException
{
    private function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function requiredNotEmptyValueForProperty(string $propertyName): self
    {
        return new self(sprintf('Required not empty value for property "%s"', $propertyName));
    }

    public static function atLeastOneElementRequiredForProperty(string $propertyName): self
    {
        return new self(sprintf('At least one element required for property "%s"', $propertyName));
    }

    public static function notFoundSupportedTransformerForType(string $type): self
    {
        return new self(sprintf('Not found transformer for type "%s"', $type));
    }
}
