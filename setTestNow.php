<?php

/**
 * @see https://github.com/spatie/test-time
 */
class Test
{
    protected function setNow(string $time, $format = 'Y-m-d H:i:s')
    {
        $now = Carbon::createFromFormat($format, $time);

        Carbon::setTestNow($now);
    }

    protected function progressSeconds(int $seconds)
    {
        $newNow = now()->addSeconds($seconds);

        Carbon::setTestNow($newNow);
    }

    protected function progressMinutes(int $minutes)
    {
        $newNow = now()->addMinutes($minutes);

        Carbon::setTestNow($newNow);
    }

    protected function progressHours(int $hours)
    {
        $newNow = now()->addHours($hours);

        Carbon::setTestNow($newNow);
    }
}
