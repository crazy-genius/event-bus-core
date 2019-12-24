<?php

declare(strict_types=1);

namespace EventSourcing;

/**
 * Class RxIsSchedulerRegistered
 * @package EventSourcing
 */
class RxIsSchedulerRegistered
{
    private static bool $isRegistered = false;

    public static function setRegistered(): void
    {
        self::$isRegistered = true;
    }

    /**
     * @return bool
     */
    public static function isRegistered(): bool
    {
        return self::$isRegistered;
    }
}
