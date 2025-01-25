<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

use ArrayAccess;
use Countable;
use Iterator;

/**
 * @template-implements Iterator<array-key, Url>
 * @template-implements ArrayAccess<array-key, Url>
 */
final class UrlCollection implements Iterator, ArrayAccess, Countable
{
    /**
     * @var array<array-key, Url>
     */
    private array $urls;
    private int $index;

    /**
     * @param array<array-key, Url> $urls
     */
    public function __construct(array $urls = [])
    {
        $this->urls = $urls;
        $this->index = count($this->urls) - 1;
    }

    /**
     * @param array<int, Url> $urls
     * @return self
     */
    public static function fromArray(array $urls): self
    {
        return new self($urls);
    }

    public function current(): Url
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

    public function offsetGet(mixed $offset): ?Url
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
