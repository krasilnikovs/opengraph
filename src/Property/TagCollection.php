<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

use ArrayAccess;
use Countable;
use Iterator;

/**
 * @template-implements Iterator<array-key, string>
 * @template-implements ArrayAccess<array-key, string>
 */
final class TagCollection implements Iterator, ArrayAccess, Countable
{
    /**
     * @var array<array-key, string>
     */
    private array $urls;
    private int $index;

    /**
     * @param array<array-key, string> $urls
     */
    public function __construct(array $urls = [])
    {
        $this->urls = $urls;
        $this->index = count($this->urls) - 1;
    }

    /**
     * @param array<array-key, string> $urls
     * @return self
     */
    public static function fromArray(array $urls): self
    {
        return new self($urls);
    }

    public function current(): string
    {
        return $this->urls[$this->index];
    }

    public function next(): void
    {
        $this->index++;
    }

    public function key(): int
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return isset($this->urls[$this->index]);
    }

    public function rewind(): void
    {
        $this->index = 0;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->urls[$offset]);
    }

    public function offsetGet(mixed $offset): ?string
    {
        return $this->urls[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->urls[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->urls[$offset]);
    }

    public function count(): int
    {
        return \count($this->urls);
    }
}
