<?php

declare(strict_types=1);

namespace EventSourcing\Bus;

use EventSourcing\Event\EventInterface;
use EventSourcing\Event\Subscriber\SubscriberInterface;

/**
 * Class BusInterface
 * @package EventSourcing\Bus
 */
interface BusInterface
{
    public function push(EventInterface $event): void;

    public function addSubscriber(SubscriberInterface $subscriber): void;
}
