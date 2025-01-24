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

    public static function notFoundSupportedTransformerForType(string $type): self
    {
        return new self(sprintf('Not found transformer for type "%s"', $type));
    }

    public static function transformationError(Throwable $throwable): self
    {
        return new self(
            message: sprintf('Transformation error: %s', $throwable->getMessage()),
            previous: $throwable
        );
    }
}
