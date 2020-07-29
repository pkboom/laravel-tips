<? php

if (! function_exists('fail_validation')) {
    function fail_validation(string $key, string $message)
    {
        throw ValidationException::withMessages([$key => $message]);
    }
}