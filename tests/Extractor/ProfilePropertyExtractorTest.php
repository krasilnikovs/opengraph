<?php declare(strict_types=1);

namespace Extractor;

use Krasilnikovs\Opengraph\Extractor\ProfilePropertyExtractor;
use Krasilnikovs\Opengraph\OpengraphScraper;
use Krasilnikovs\Opengraph\Property\Gender;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ProfilePropertyExtractor::class)]
final class ProfilePropertyExtractorTest extends TestCase
{
    private ProfilePropertyExtractor $extractor;

    protected function setUp(): void
    {
        $html = <<<HTML
                <meta property="og:type" content="profile">
                <meta property="og:title" content="Mihails Krasilnikovs">
                <meta property="og:url" content="https://krasilnikovs.lv">
                <meta property="og:image" content="https://krasilnikovs.lv/static/me.webp">
                <meta property="og:description" content="Software Engineer From Latvia">
                <meta property="profile:first_name" content="Mihails">
                <meta property="profile:last_name" content="Krasilnikovs">
                <meta property="profile:username" content="krasilnikovs">
                <meta property="profile:gender" content="male">
            HTML;

        $this->extractor = ProfilePropertyExtractor::fromScraper(
            OpengraphScraper::fromString($html)
        );
    }

    public function testShouldExtractFirstName(): void
    {
        $expected = 'Mihails';

        self::assertEquals($expected, $this->extractor->firstName());
    }

    public function testShouldExtractLastName(): void
    {
        $expected = 'Krasilnikovs';

        self::assertEquals($expected, $this->extractor->lastName());
    }

    public function testShouldExtractUsername(): void
    {
        $expected = 'krasilnikovs';

        self::assertEquals($expected, $this->extractor->username());
    }

    public function testShouldExtractGender(): void
    {
        $expected = Gender::Male;

        self::assertEquals($expected, $this->extractor->gender());
    }
}
