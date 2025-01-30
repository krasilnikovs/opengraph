<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Object;

use Krasilnikovs\Opengraph\Property\AudioCollection;
use Krasilnikovs\Opengraph\Property\Determiner;
use Krasilnikovs\Opengraph\Property\Gender;
use Krasilnikovs\Opengraph\Property\ImageCollection;
use Krasilnikovs\Opengraph\Property\Url;
use Krasilnikovs\Opengraph\Property\VideoCollection;

final readonly class ProfileObject extends AbstractObject
{
    public string $firstName;
    public string $lastName;
    public string $username;
    public Gender $gender;

    public function __construct(
        Url $url,
        string $title,
        string $description,
        string $siteName,
        Determiner $determiner,
        ImageCollection $images,
        AudioCollection $audios,
        VideoCollection $videos,
        string $firstName,
        string $lastName,
        string $username,
        Gender $gender,
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->gender = $gender;

        parent::__construct($url, $title, $description, $siteName, $determiner, $images, $audios, $videos);
    }


    public static function getType(): string
    {
        return 'profile';
    }
}
