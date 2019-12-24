<?php

declare(strict_types=1);

namespace EventSourcing\Event\Subscriber;

/**
 * Interface EventSubscriberInterface
 * @package EventSourcing\Event\Subscriber
 */
interface SubscriberInterface
{
    public function handle(object $event): void;
}
