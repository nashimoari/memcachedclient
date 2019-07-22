<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use nashimoari\memCachedClient\memCachedClient;
use nashimoari\memCachedClient\connector\connectorFactory;
use nashimoari\memCachedClient\setData;

final class memCachedClientUnitTest extends TestCase
{

    public function testConnection(): void
    {
        $connection = connectorFactory::create_connection('TCP_STUB');
        $client = new memCachedClient($connection);

        $res = $client->connect('localhost', '11211');
        $this->assertEquals(true, $res);

        $this->assertEquals(true, true);
    }

    public function testGet(): void
    {
        $connection = connectorFactory::create_connection('TCP_STUB');
        $client = new memCachedClient($connection);

        $client->connect('localhost', '11211');

        $client->get('test');

        $this->assertEquals("get test\r\n", $connection->bufferSendGet());
    }

    public function testSet(): void
    {
        $connection = connectorFactory::create_connection('TCP_STUB');
        $client = new memCachedClient($connection);

        $client->connect('localhost', '11211');

        $setdata = new setData();
        $setdata->data = 'test value';
        $setdata->key = 'test';

        $client->set($setdata);

        $this->assertEquals("set test 0 0 10\r\ntest value\r\n", $connection->bufferSendGet());

        $this->assertEquals(true, true);
    }

    public function testDelete(): void
    {
        $connection = connectorFactory::create_connection('TCP_STUB');
        $client = new memCachedClient($connection);

        $client->connect('localhost', '11211');

        $client->delete('test');

        $this->assertEquals("delete test\r\n", $connection->bufferSendGet());
    }


}
