<?php

declare(strict_types=1);

namespace EventSourcing\Event\Subscriber;

use EventSourcing\Event\EventInterface;

/**
 * Interface EventSubscriberInterface
 * @package EventSourcing\Event\Subscriber
 */
interface SubscriberInterface
{
    public function handle(EventInterface $event): void;
}
