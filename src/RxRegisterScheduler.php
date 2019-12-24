<?php

declare(strict_types=1);

namespace EventSourcing;

use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use Rx\Scheduler;

/**
 * Class RegisterScheduler
 * @package EventSourcing
 */
class RxRegisterScheduler
{

    /**
     * @return LoopInterface
     * @throws \Exception
     */
    public function register(): LoopInterface
    {
        $loop = Factory::create();

        Scheduler::setDefaultFactory(static function () use ($loop) {
            return new Scheduler\EventLoopScheduler($loop);
        });

        RxIsSchedulerRegistered::setRegistered();

        return $loop;
    }
}
