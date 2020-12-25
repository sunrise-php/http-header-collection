<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

/**
 * Import classes
 */
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\MessageInterface;
use Sunrise\Http\Header\HeaderCollection;
use Sunrise\Http\Header\HeaderCollectionInterface;

/**
 * Import functions
 */
use function count;
use function iterator_to_array;

/**
 * HeaderCollectionTest
 */
class HeaderCollectionTest extends TestCase
{

    /**
     * @return void
     */
    public function testConstructor() : void
    {
        $collection = new HeaderCollection();

        $this->assertInstanceOf(HeaderCollectionInterface::class, $collection);
    }

    /**
     * @return void
     */
    public function testConstructorWithHeaders() : void
    {
        $headers = [
            new Header('x-foo', 'foo'),
            new Header('x-bar', 'bar'),
            new Header('x-baz', 'baz'),
        ];

        $collection = new HeaderCollection($headers);

        $this->assertEquals($headers, iterator_to_array($collection));
    }

    /**
     * @return void
     */
    public function testAdd() : void
    {
        $headers = [
            new Header('x-foo', 'foo'),
            new Header('x-bar', 'bar'),
            new Header('x-baz', 'baz'),
            new Header('x-qux', 'qux'),
        ];

        $collection = new HeaderCollection([
            $headers[0],
            $headers[1],
        ]);

        $collection->add($headers[2]);
        $collection->add($headers[3]);

        $this->assertEquals($headers, iterator_to_array($collection));
    }

    /**
     * @return void
     */
    public function testSetToMessage() : void
    {
        $headers = [
            new Header('x-foo', 'foo'),
            new Header('x-foo', 'bar'),
        ];

        $messageStub = $this->createMock(MessageInterface::class);
        $messageStub->__headers = [];

        $messageStub->method('withHeader')->will(
            $this->returnCallback(function ($name, $value) use ($messageStub) {
                $messageStub->__headers[$name] = [$value];

                return $messageStub;
            })
        );

        $messageStub->method('getHeader')->will(
            $this->returnCallback(function ($name) use ($messageStub) {
                return $messageStub->__headers[$name] ?? [];
            })
        );

        $messageStub = (new HeaderCollection($headers))->setToMessage($messageStub);

        $expected = [$headers[1]->getFieldValue()];
        $this->assertEquals($expected, $messageStub->getHeader($headers[0]->getFieldName()));
    }

    /**
     * @return void
     */
    public function testAddToMessage() : void
    {
        $headers = [
            new Header('x-foo', 'foo'),
            new Header('x-foo', 'bar'),
        ];

        $messageStub = $this->createMock(MessageInterface::class);
        $messageStub->__headers = [];

        $messageStub->method('withAddedHeader')->will(
            $this->returnCallback(function ($name, $value) use ($messageStub) {
                $messageStub->__headers[$name][] = $value;

                return $messageStub;
            })
        );

        $messageStub->method('getHeader')->will(
            $this->returnCallback(function ($name) use ($messageStub) {
                return $messageStub->__headers[$name] ?? [];
            })
        );

        $messageStub = (new HeaderCollection($headers))->addToMessage($messageStub);

        $expected = [$headers[0]->getFieldValue(), $headers[1]->getFieldValue()];
        $this->assertEquals($expected, $messageStub->getHeader($headers[0]->getFieldName()));
    }

    /**
     * @return void
     */
    public function testToEmptyArray() : void
    {
        $collection = new HeaderCollection();

        $this->assertEquals([], $collection->toArray());
    }

    /**
     * @return void
     */
    public function testToArray() : void
    {
        $expected = [
            'x-foo' => ['foo'],
            'x-bar' => ['bar.1', 'bar.2', 'bar.3'],
            'x-baz' => ['baz'],
            'x-qux' => ['qux'],
        ];

        $collection = new HeaderCollection([
            new Header('x-foo', 'foo'),
            new Header('x-bar', 'bar.1'),
            new Header('x-bar', 'bar.2'),
            new Header('x-baz', 'baz'),
            new Header('x-bar', 'bar.3'),
            new Header('x-qux', 'qux'),
        ]);

        $this->assertEquals($expected, $collection->toArray());
    }

    /**
     * @return void
     */
    public function testIsCountable() : void
    {
        $collection = new HeaderCollection();

        $this->assertInstanceOf(Countable::class, $collection);
    }

    /**
     * @return void
     */
    public function testIsIterable() : void
    {
        $collection = new HeaderCollection();

        $this->assertInstanceOf(Traversable::class, $collection);

        $this->assertIsIterable($collection);
    }

    /**
     * @return void
     */
    public function testGetCount() : void
    {
        $headers = [
            new Header('x-foo', 'foo'),
            new Header('x-bar', 'bar'),
            new Header('x-baz', 'baz'),
        ];

        $collection = new HeaderCollection($headers);

        $this->assertCount(3, $collection);
    }

    /**
     * @return void
     */
    public function testGetIterator() : void
    {
        $collection = new HeaderCollection();

        $this->assertInstanceOf(ArrayIterator::class, $collection->getIterator());
    }
}
