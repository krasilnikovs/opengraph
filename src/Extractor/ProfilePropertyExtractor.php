<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Extractor;

use Krasilnikovs\Opengraph\OpengraphScraper;
use Krasilnikovs\Opengraph\Property\Gender;

final readonly class ProfilePropertyExtractor
{
    use PropertyExtractor;

    public function firstName(): string
    {
        return $this->scraper->getContentByName(OpengraphScraper::PROFILE_FIRST_NAME_PROPERTY);
    }

    public function lastName(): string
    {
        return $this->scraper->getContentByName(OpengraphScraper::PROFILE_LAST_NAME_PROPERTY);
    }

    public function username(): string
    {
        return $this->scraper->getContentByName(OpengraphScraper::PROFILE_USERNAME_PROPERTY);
    }

    public function gender(): Gender
    {
        $gender = $this->scraper->getContentByName(OpengraphScraper::PROFILE_GENDER_PROPERTY);

        return Gender::tryFrom($gender) ?? Gender::Undefined;
    }
}
