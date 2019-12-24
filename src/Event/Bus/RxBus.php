<?php

declare(strict_types=1);

namespace EventSourcing\Bus;

use EventSourcing\Event\EventInterface;
use EventSourcing\Event\Subscriber\SubscriberInterface;
use Rx\Disposable\CompositeDisposable;
use Rx\Exception\Exception;
use Rx\Subject\Subject;

/**
 * Class Bus
 * @package EventSourcing\Bus
 */
class RxBus implements BusInterface
{
    private Subject $source;
    private CompositeDisposable $disposable;

    /**
     * Bus constructor.
     *
     * @param Subject $subject
     * @param CompositeDisposable $disposable
     */
    public function __construct(Subject $subject, CompositeDisposable $disposable)
    {
        $this->source = $subject;
        $this->disposable = $disposable;
    }

    public function subscribe(SubscriberInterface $subscriber): void
    {
        $disposable = $this->source->asObservable()->subscribe(
            static function ($message) use ($subscriber) {
                $subscriber->handle($message);
            },
            static function (Exception $exception) use ($subscriber) {
                $subscriber->handleError();
            }
        );

        $this->disposable->add($disposable);
    }

    public function push(EventInterface $event): void
    {
        $this->source->onNext($event);
    }

    public function close(): void
    {
        $this->disposable->dispose();
    }
}
