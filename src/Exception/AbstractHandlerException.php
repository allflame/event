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
use Vainyl\Event\EventHandlerInterface;

/**
 * Class AbstractHandlerException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class AbstractHandlerException extends AbstractCoreException implements HandlerExceptionInterface
{
    private $eventHandler;

    /**
     * AbstractHandlerException constructor.
     *
     * @param EventHandlerInterface $eventHandler
     * @param string                $message
     * @param int                   $code
     * @param \Throwable|null       $previous
     */
    public function __construct(
        EventHandlerInterface $eventHandler,
        string $message,
        int $code = 500,
        \Throwable $previous = null
    ) {
        $this->eventHandler = $eventHandler;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @inheritDoc
     */
    public function getEventHandler(): EventHandlerInterface
    {
        return $this->eventHandler;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(['event_handler' => $this->eventHandler->getId()], parent::toArray());
    }
}