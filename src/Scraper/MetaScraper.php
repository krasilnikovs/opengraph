<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Scraper;

use Dom\HTMLDocument;
use function current;
use function iterator_to_array;
use function sprintf;

final readonly class MetaScraper implements MetaScraperInterface
{
    private HTMLDocument $document;

    private function __construct(string $content)
    {
        $this->document = @HTMLDocument::createFromString($content);
    }

    public static function fromString(string $content): self
    {
        return new self($content);
    }

    public function getContentByName(string $name): string
    {
        $properties = $this->getContentsByName($name);

        return (string) current(iterator_to_array($properties));
    }

    public function getContentsByName(string $name): iterable
    {
        $query = sprintf('meta[property="%s"]', $name);
        $elements = $this->document->querySelectorAll($query);

        foreach ($elements as $element) {
            yield (string) $element->getAttribute('content');
        }
    }

    /**
     * @return iterable<array{string, string}>
     */
    public function getContentsByPrefix(string $prefix): iterable
    {
        $query = sprintf('meta[property^="%s"]', $prefix);
        $elements = $this->document->querySelectorAll($query);

        foreach ($elements as $element) {
            yield [(string) $element->getAttribute('property'), (string) $element->getAttribute('content')];
        }
    }
}
