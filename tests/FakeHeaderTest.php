<?php

namespace Sunrise\Http\Header\Tests;

/**
 * Import classes
 */
use Psr\Http\Message\MessageInterface;
use Sunrise\Http\Header\HeaderInterface;

/**
 * Import functions
 */
use function sprintf;

/**
 * FakeHeaderTest
 */
final class FakeHeaderTest implements HeaderInterface
{

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $value;

	/**
	 * @param string $name
	 * @param string $value
	 */
	public function __construct(string $name, string $value)
	{
		$this->name = $name;
		$this->value = $value;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFieldName() : string
	{
		return $this->name;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFieldValue() : string
	{
		return $this->value;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setToMessage(MessageInterface $message) : MessageInterface
	{
		return $message->withHeader($this->name, $this->value);
	}

	/**
	 * {@inheritDoc}
	 */
	public function addToMessage(MessageInterface $message) : MessageInterface
	{
		return $message->withAddedHeader($this->name, $this->value);
	}

	/**
	 * {@inheritDoc}
	 */
	public function __toString()
	{
		return sprintf('%s: %s', $this->name, $this->value);
	}
}
