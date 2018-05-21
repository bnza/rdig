<?php

namespace App\Service\Job;


class JobStatus
{
    const RUNNING = 0b0001;
    const TERMINATED = 0b0010;
    const CANCELLED = 0b0100;
    const ERROR = 0b1000;

    /**
     * @param int $status
     * @return bool
     */
    public static function isRunning(int $status): bool
    {
        return (bool) ($status & JobStatus::RUNNING);
    }

    /**
     * @param int $status
     * @return bool
     */
    public static function isTerminated(int $status): bool
    {
        return (bool) ($status & JobStatus::TERMINATED);
    }

    public static function setStatus(int $status, int $bitMask, bool $flag): int
    {
        if ($flag) {
            return $status | $bitMask;
        } else {
            return $status & ~$bitMask;
        }
    }

    /**
     * @param int $status
     * @return bool
     */
    public static function isSuccess(int $status)
    {
        return (bool) ($status & (~JobStatus::RUNNING & JobStatus::TERMINATED & ~JobStatus::ERROR));
    }

    /**
     * @param int $status
     * @return bool
     */
    public static function isError(int $status)
    {
        return (bool) ($status & JobStatus::ERROR);
    }
}