<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

use DateTimeImmutable;
use Throwable;

final readonly class MusicAlbum
{
    private string $releaseDate;

    /**
     * @var list<string>
     */
    private array $musicians;

    /**
     * @var list<string>
     */
    private array $songs;

    /**
     * @param list<string> $musicians
     * @param list<string> $songs
     */
    public function __construct(string $releaseDate, array $musicians, array $songs)
    {
        $this->releaseDate = $releaseDate;
        $this->musicians = $musicians;
        $this->songs = $songs;
    }

    public function releaseDate(): ?DateTimeImmutable
    {
        try {
            return new DateTimeImmutable($this->releaseDate);
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * @return list<string>
     */
    public function musicians(): array
    {
        return $this->musicians;
    }

    /**
     * @return list<string>
     */
    public function songs(): array
    {
        return $this->songs;
    }
}
