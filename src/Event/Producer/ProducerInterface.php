<?php

declare(strict_types=1);

namespace EventSourcing\Event\Producer;

use EventSourcing\Event\EventInterface;

/**
 * interface ProducerInterface
 * @package EventSourcing\Event\Producer
 */
interface ProducerInterface
{
    public function produce(): EventInterface;
}
