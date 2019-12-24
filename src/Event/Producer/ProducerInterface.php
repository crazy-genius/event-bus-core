<?php

declare(strict_types=1);

namespace EventSourcing\Event\Producer;

/**
 * interface ProducerInterface
 * @package EventSourcing\Event\Producer
 */
interface ProducerInterface
{
    public function produce(): object;
}
