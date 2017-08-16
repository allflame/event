<?php
/**
 * Vainyl
 *
 * PHP Version 7
 *
 * @package   Event
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://vainyl.com
 */
declare(strict_types=1);

namespace Vainyl\Event\Exception;

use Vainyl\Core\Exception\AbstractCoreException;
use Vainyl\Event\EventDispatcherInterface;

/**
 * Class AbstractDispatcherException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
abstract class AbstractDispatcherException extends AbstractCoreException implements DispatcherExceptionInterface
{
    private $eventDispatcher;

    /**
     * AbstractDispatcherException constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param string                   $message
     * @param int                      $code
     * @param \Throwable|null          $previous
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        string $message,
        int $code = 500,
        \Throwable $previous = null
    ) {
        $this->eventDispatcher = $eventDispatcher;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @inheritDoc
     */
    public function getEventDispatcher(): EventDispatcherInterface
    {
        return $this->eventDispatcher;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(['event_dispatcher' => $this->eventDispatcher->getId()], parent::toArray());
    }
}