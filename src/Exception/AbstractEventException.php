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
use Vainyl\Event\EventInterface;

/**
 * Class AbstractEventException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
abstract class AbstractEventException extends AbstractCoreException implements EventExceptionInterface
{
    private $event;

    /**
     * AbstractEventException constructor.
     *
     * @param EventInterface  $event
     * @param string          $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct(EventInterface $event, string $message, int $code = 500, \Exception $previous = null)
    {
        $this->event = $event;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @inheritDoc
     */
    public function getEvent(): EventInterface
    {
        return $this->event;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(['event' => $this->event->getName()], parent::toArray());
    }
}