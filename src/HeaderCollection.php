<?php declare(strict_types=1);

/**
 * It's free open-source software released under the MIT License.
 *
 * @author Anatoly Fenric <anatoly@fenric.ru>
 * @copyright Copyright (c) 2019, Anatoly Fenric
 * @license https://github.com/sunrise-php/http-header-collection/blob/master/LICENSE
 * @link https://github.com/sunrise-php/http-header-collection
 */

namespace Sunrise\Http\Header;

/**
 * Import classes
 */
use ArrayIterator;
use Psr\Http\Message\MessageInterface;
use Sunrise\Http\Header\HeaderInterface;

/**
 * Import functions
 */
use function count;

/**
 * HeaderCollection
 */
class HeaderCollection implements HeaderCollectionInterface
{

	/**
	 * The collection headers
	 *
	 * @var HeaderInterface[]
	 */
	protected $headers = [];

	/**
	 * Constructor of the class
	 *
	 * @param HeaderInterface[] $headers
	 */
	public function __construct(iterable $headers = [])
	{
		foreach ($headers as $header)
		{
			$this->add($header);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function add(HeaderInterface $header) : void
	{
		$this->headers[] = $header;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setToMessage(MessageInterface $message) : MessageInterface
	{
		foreach ($this->headers as $header)
		{
			$message = $header->setToMessage($message);
		}

		return $message;
	}

	/**
	 * {@inheritDoc}
	 */
	public function addToMessage(MessageInterface $message) : MessageInterface
	{
		foreach ($this->headers as $header)
		{
			$message = $header->addToMessage($message);
		}

		return $message;
	}

	/**
	 * {@inheritDoc}
	 */
	public function toArray() : array
	{
		$headers = [];

		foreach ($this->headers as $header)
		{
			$name = $header->getFieldName();
			$value = $header->getFieldValue();

			$headers[$name][] = $value;
		}

		return $headers;
	}

	/**
	 * Gets the number of headers in the collection
	 *
	 * @return int
	 */
	public function count()
	{
		return count($this->headers);
	}

	/**
	 * Gets an external iterator
	 *
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->headers);
	}
}
