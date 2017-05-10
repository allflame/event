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

namespace Vainyl\Event\Decorator;

use Vainyl\Event\EventInterface;

/**
 * Class AbstractEventDecorator
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
abstract class AbstractEventDecorator implements EventInterface
{
    private $event;

    /**
     * AbstractEventDecorator constructor.
     *
     * @param EventInterface $event
     */
    public function __construct(EventInterface $event)
    {
        $this->event = $event;
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->event->getId();
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->event->getName();
    }
}
