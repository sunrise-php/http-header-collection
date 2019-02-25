<?php

namespace Sunrise\Http\Header\Tests;

/**
 * Import classes
 */
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderCollection;
use Sunrise\Http\Header\HeaderCollectionInterface;
use Sunrise\Http\Message\ResponseFactory;

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
			new FakeHeaderTest('x-foo', 'foo'),
			new FakeHeaderTest('x-bar', 'bar'),
			new FakeHeaderTest('x-baz', 'baz'),
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
			new FakeHeaderTest('x-foo', 'foo'),
			new FakeHeaderTest('x-bar', 'bar'),
			new FakeHeaderTest('x-baz', 'baz'),
			new FakeHeaderTest('x-qux', 'qux'),
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
			new FakeHeaderTest('x-foo', 'foo'),
			new FakeHeaderTest('x-foo', 'bar'),
		];

		$collection = new HeaderCollection($headers);

		$message = (new ResponseFactory)->createResponse();
		$message = $collection->setToMessage($message);

		$this->assertEquals(
			[
				$headers[1]->getFieldValue(),
			],
			$message->getHeader($headers[0]->getFieldName())
		);
	}

	/**
	 * @return void
	 */
	public function testAddToMessage() : void
	{
		$headers = [
			new FakeHeaderTest('x-foo', 'foo'),
			new FakeHeaderTest('x-foo', 'bar'),
		];

		$collection = new HeaderCollection($headers);

		$message = (new ResponseFactory)->createResponse();
		$message = $collection->addToMessage($message);

		$this->assertEquals(
			[
				$headers[0]->getFieldValue(),
				$headers[1]->getFieldValue(),
			],
			$message->getHeader($headers[0]->getFieldName())
		);
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
			new FakeHeaderTest('x-foo', 'foo'),
			new FakeHeaderTest('x-bar', 'bar.1'),
			new FakeHeaderTest('x-bar', 'bar.2'),
			new FakeHeaderTest('x-baz', 'baz'),
			new FakeHeaderTest('x-bar', 'bar.3'),
			new FakeHeaderTest('x-qux', 'qux'),
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
			new FakeHeaderTest('x-foo', 'foo'),
			new FakeHeaderTest('x-bar', 'bar'),
			new FakeHeaderTest('x-baz', 'baz'),
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
