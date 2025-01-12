<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Transformer;

use Krasilnikovs\Opengraph\AbstractObject;
use Krasilnikovs\Opengraph\Builder\ObjectTransformerInterface;
use PHPUnit\Framework\TestCase;

abstract class ObjectTransformerTestCase extends TestCase
{
    private ObjectTransformerInterface $transformer;

    protected function setUp(): void
    {
        $this->transformer = $this->getTransformer();
    }

    public function testSupports(): void
    {

        $this->assertTrue($this->transformer->supports($this->getObject()));


    }

    abstract protected function getTransformer(): ObjectTransformerInterface;


    // @TODO THink about create a good contract
    abstract protected function getExtractor(): AbstractObject;
}
