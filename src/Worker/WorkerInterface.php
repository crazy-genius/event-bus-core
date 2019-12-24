<?php

declare(strict_types=1);

namespace EventSourcing\Worker;

/**
 * Class WorkerInterface
 * @package EventSourcing\Worker
 */
interface WorkerInterface
{
    public function work(): void;
}
