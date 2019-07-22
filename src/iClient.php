<?php

namespace nashimoari\memCachedClient;

use nashimoari\memCachedClient\connector\responseData;

/**
 *
 * @author nashimoari
 */
interface iClient
{
    public function connect($host, $port): bool;

    public function get($key): responseData;

    public function set(setData $data): responseData;

    public function delete($key):responseData;

}