# Opengraph

## Description
The library provides a flexible Open Graph parser for extracting metadata from web pages. It supports standard Open Graph tags and allows users of the library to extend its functionality by adding custom Open Graph types for enhanced parsing capabilities.
## Table of Contents
- [Installation](#installation)
- [Usage](#usage)

## Installation
```sh
$ composer require krasilnikovs/opengraph
```

## Usage
```php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Krasilnikovs\Opengraph\OpengraphParser;

$parser = new \Krasilnikovs\Opengraph\OpengraphParser();

$content = file_get_contents('https://ogp.me');
$object = $parser->parse($content);

printf('Title: %s' . PHP_EOL, $object->title);
printf('Url: %s' . PHP_EOL, $object->url);
printf('Type: %s' . PHP_EOL, $object->type);
printf('Image Url: %s' . PHP_EOL, $object->images[0]?->url);
```

Output
```sh
Title: Open Graph protocol
Url: https://ogp.me/
Type: website
Image Url: https://ogp.me/logo.png
```
