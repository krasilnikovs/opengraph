<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Scraper;

use Dom\Element;
use Dom\HTMLDocument;
use function array_map;
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

        return (string) current($properties);
    }

    /**
     * @return string[]
     */
    public function getContentsByName(string $name): array
    {
        $query = sprintf('meta[property="%s"]', $name);
        $elements = $this->document->querySelectorAll($query);

        return array_map(
            static fn (Element $element) => (string) $element->getAttribute('content'),
            iterator_to_array($elements),
        );
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
