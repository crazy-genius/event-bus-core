<?php

declare(strict_types=1);

namespace EventSourcing\Worker;

use EventSourcing\Event\Producer\ProducerInterface;

/**
 * Class SyncWorker
 * @package EventSourcing\Worker
 */
class SyncWorker implements WorkerInterface
{
    protected const DELAY = 100;

    /**
     * @var ProducerInterface[]
     */
    protected array $producers;

    protected object $bus;

    public function work(): void
    {
        $this->beforeStart();

        while (true) {
            foreach ($this->producers as $producer) {
                $this->workWithProducer($producer);
            }

            $this->delay();
        }

        $this->afterStop();
    }

    protected function workWithProducer(ProducerInterface $producer): void
    {
        $event = $producer->produce();
        $this->bus->send($event);
    }

    protected function beforeStart(): void
    {
    }

    protected function afterStop(): void
    {
    }

    protected function delay(): void
    {
        microtime(self::DELAY);
    }
}
