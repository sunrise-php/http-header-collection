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
use Countable;
use IteratorAggregate;
use Psr\Http\Message\MessageInterface;
use Sunrise\Http\Header\HeaderInterface;

/**
 * HeaderCollectionInterface
 */
interface HeaderCollectionInterface extends Countable, IteratorAggregate
{

	/**
	 * Adds the given header to the collection
	 *
	 * @param HeaderInterface $header
	 *
	 * @return void
	 */
	public function add(HeaderInterface $header) : void;

	/**
	 * Sets the collection headers to the given message
	 *
	 * @param MessageInterface $message
	 *
	 * @return MessageInterface
	 *
	 * @link https://www.php-fig.org/psr/psr-7/
	 */
	public function setToMessage(MessageInterface $message) : MessageInterface;

	/**
	 * Adds the collection headers to the given message
	 *
	 * @param MessageInterface $message
	 *
	 * @return MessageInterface
	 *
	 * @link https://www.php-fig.org/psr/psr-7/
	 */
	public function addToMessage(MessageInterface $message) : MessageInterface;

	/**
	 * Converts the collection to array
	 *
	 * @return array
	 */
	public function toArray() : array;
}
