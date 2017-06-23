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

use Vainyl\Event\EventDispatcherInterface;

/**
 * Class LevelIntegrityDispatcherException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class LevelIntegrityDispatcherException extends AbstractDispatcherException
{
    private $level;

    /**
     * LevelIntegrityDispatcherException constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param int                      $level
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, int $level)
    {
        $this->level = $level;
        parent::__construct($eventDispatcher, sprintf('Level integrity check failed for level %d', $level));
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(['level' => $this->level], parent::toArray());
    }
}