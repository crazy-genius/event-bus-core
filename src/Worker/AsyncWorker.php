<?php

declare(strict_types=1);

namespace EventSourcing\Worker;

use EventSourcing\Event\Producer\ProducerInterface;

/**
 * Class AsyncWorker
 * @package EventSourcing\Worker
 */
class AsyncWorker extends SyncWorker
{
    private \Generator $handler;

    protected function workWithProducer(ProducerInterface $producer): void
    {
        $this->handler->send($producer);
    }

    protected function beforeStart(): void
    {
        $this->handler = $this->createAsyncHandler();
    }

    private function createAsyncHandler(): \Generator
    {
        /**
         * @var ProducerInterface $producer
         */
        $producer = yield;
        $this->bus->send($producer->produce());

        yield true;
    }
}
