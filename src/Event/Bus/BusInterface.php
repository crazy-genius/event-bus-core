<?php

declare(strict_types=1);

namespace EventSourcing\Bus;

use EventSourcing\Event\Subscriber\SubscriberInterface;

/**
 * Class BusInterface
 * @package EventSourcing\Bus
 */
interface BusInterface
{
    public function push(object $event): void;

    public function addSubscriber(SubscriberInterface $subscriber): void;
}
