<?php

declare(strict_types=1);

namespace EventSourcing\Worker;

use EventSourcing\Bus\BusInterface;
use EventSourcing\Event\Producer\ProducerInterface;

/**
 * Class AbstractWorker
 * @package EventSourcing\Worker
 */
abstract class AbstractWorker implements WorkerInterface
{
    protected BusInterface $bus;
    protected ProducerInterface $producer;
    protected bool $mustStop;
    protected bool $useGracefulStop;

    /**
     * AbstractWorker constructor.
     *
     * @param BusInterface $bus
     * @param ProducerInterface $producer
     * @param bool $useGracefulStop
     */
    public function __construct(BusInterface $bus, ProducerInterface $producer, bool $useGracefulStop = true)
    {
        $this->bus = $bus;
        $this->producer = $producer;
        $this->mustStop = false;
        $this->useGracefulStop = $useGracefulStop;
    }

    public function work(): void
    {
        $this->beforeStart();
        $this->payloadWork();
        $this->beforeStop();
    }

    protected function payloadWork(): void
    {
        $fetcher = $this->createAsyncFetcher($this->createAsyncPusher());

        while (true) {
            $fetcher->send($this->producer);

            if ($this->mustStop) {
                $this->stop($fetcher);

                break;
            }
            microtime(200);
        }
    }

    abstract protected function beforeStart(): void;

    abstract protected function beforeStop(): void;

    protected function stop(\Generator $generator): void
    {
        if ($this->useGracefulStop) {
            $this->gracefulStop($generator);
        }
    }

    protected function gracefulStop(\Generator $generator): void
    {
        while ($generator->valid()) {
            $generator->next();
        }
    }

    private function createAsyncPusher(): \Generator
    {
        try {
            $this->bus->push(yield);
        } catch (\Exception $exception) {
            yield false;
        }

        yield true;
    }

    /**
     * @param \Generator $pusher
     *
     * @return \Generator
     */
    private function createAsyncFetcher(\Generator $pusher): \Generator
    {
        /**
         * @var ProducerInterface $producer
         */
        $producer = yield;

        yield $pusher->send($producer->produce());
    }
}
