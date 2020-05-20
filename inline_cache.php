<?php

/**
 * @see https://twitter.com/calebporzio/status/1258808651718053888
 * Little inline caches for when a method is called multiple times within a request and don't want to "re-compute" that value.
 * It's called "memoization", but I call it "inline static caching"
 */
class Post extends Model
{
    public function countryCount()
    {
        static $cache;

        return $cache ?? $cache = $this->countries()->count();

        return $cache ??= $this->countries()->count(); // php7.4
    }
}
