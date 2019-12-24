<?php

declare(strict_types=1);

namespace EventSourcing\Bus;

use Rx\Disposable\CompositeDisposable;
use Rx\Subject\AsyncSubject;

/**
 * Class DefaultBusFactory
 * @package EventSourcing\Bus
 */
class DefaultBusFactory
{
    public function createRxBus(): BusInterface
    {
        $subject = new AsyncSubject();
        $disposable = new CompositeDisposable();

        return new RxBus($subject, $disposable);
    }
}
