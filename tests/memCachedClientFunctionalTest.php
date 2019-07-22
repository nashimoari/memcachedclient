<?php


use nashimoari\memCachedClient\memCachedClient;
use PHPUnit\Framework\TestCase;
use nashimoari\memCachedClient\connector\connectorFactory;
use nashimoari\memCachedClient\setData;

class memCachedClientFunctionalTest extends TestCase
{
    public function testConnection(): void
    {
        $connection = connectorFactory::create_connection('TCP');
        $client = new memCachedClient($connection);

        $res = $client->connect('localhost', '11211');
        $this->assertEquals(true, $res);

        $this->assertEquals(true, true);
    }

    /**
     * Test get command
     *
     * @throws Exception
     */
    public function testGet(): void
    {
        $connection = connectorFactory::create_connection('TCP');
        $client = new memCachedClient($connection);

        $client->connect('localhost', '11211');

        $clientResponse = $client->get('test');

        $this->assertEquals('SUCCESS', $clientResponse->code);
    }

    public function testSet(): void
    {
        $connection = connectorFactory::create_connection('TCP');
        $client = new memCachedClient($connection);

        $client->connect('localhost', '11211');

        $setdata = new setData();
        $setdata->data = 'test value';
        $setdata->key = 'test';


        $clientResponse = $client->set($setdata);

        $this->assertEquals('SUCCESS', $clientResponse->code);

    }

    public function testDelete(): void
    {
        $connection = connectorFactory::create_connection('TCP');
        $client = new memCachedClient($connection);

        $client->connect('localhost', '11211');

        $clientResponse = $client->delete('test');

        print_r($clientResponse);

        $this->assertEquals('SUCCESS', $clientResponse->code);
    }


}
