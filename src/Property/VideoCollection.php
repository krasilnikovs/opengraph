<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

use ArrayAccess;
use Iterator;

/**
 * @template-implements Iterator<array-key, Video>
 * @template-implements ArrayAccess<array-key, Video>
 */
final class VideoCollection implements Iterator, ArrayAccess
{
    /**
     * @var array<array-key, Video>
     */
    private array $videos;
    private int $index;

    /**
     * @param array<array-key, Video> $Videos
     */
    public function __construct(array $Videos = [])
    {
        $this->videos = $Videos;
        $this->index = count($this->videos) - 1;
    }

    /**
     * @param array<int, Video> $Videos
     * @return self
     */
    public static function fromArray(array $Videos): self
    {
        return new self($Videos);
    }

    public function current(): Video
    {
        return $this->videos[$this->index];
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
        return isset($this->videos[$this->index]);
    }

    public function rewind(): void
    {
        $this->index = 0;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->videos[$offset]);
    }

    public function offsetGet(mixed $offset): ?Video
    {
        return $this->videos[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->videos[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->videos[$offset]);
    }
}
