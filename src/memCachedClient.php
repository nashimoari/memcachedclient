<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace nashimoari\memCachedClient;

use nashimoari\memCachedClient\connector\iConnector;
use nashimoari\memCachedClient\connector\getData;
use nashimoari\memCachedClient\connector\responseData;
use ReflectionClass;

/**
 * Клиент для взаимодействия с memcached
 *
 * https://github.com/memcached/memcached/blob/master/doc/protocol.txt
 *
 * @author nashimoari
 */
class memCachedClient implements iClient
{

    /*
     * Экземпляр iConnector
     * @var iConnector
     */
    private $connection;

    /**
     * Настройки клиента
     * @var array
     */
    private $settings;

    /**
     * Объект в котором задаются параметры для получения данных от сервера
     * @var getData
     */
    private $getData;

    public function __construct(iConnector $connection)
    {
        $this->connection = $connection;

        /**
         *  подключаем настройки
         */

        $reflector = new ReflectionClass($this);
        $app_path =  dirname($reflector->getFileName());

        $this->settings = json_decode(file_get_contents($app_path.'/MemCachedClientSettings.json'), true);
        $this->getData = new getData();


        $this->getData->timeOut = (int)$this->settings['timeOut'];
        $this->getData->waitFor = $this->settings['waitFor'];

        return true;
    }

    /**
     *
     * Подключение к хосту
     * @param string $host connection host
     * @param string port connection port
     * @return bool
     */
    public function connect($host, $port): bool
    {
        return $this->connection->open($host, $port);
    }


    public function get($key): responseData
    {
        $this->connection->send('get ' . $key . "\r\n");
        return $this->connection->get($this->getData);
    }


    public function set(setData $data): responseData
    {

        $bytes = strlen($data->data);
        $this->connection->send('set ' . $data->key . " ".$data->flags." ".$data->exptime." ".$bytes."\r\n".$data->data."\r\n");
        return $this->connection->get($this->getData);
    }

    /**
     *
     * Deletion
     * --------
     *
     * The command "delete" allows for explicit deletion of items:
     *
     * delete <key> [noreply]\r\n
     *
     * - <key> is the key of the item the client wishes the server to delete
     *
     * - "noreply" optional parameter instructs the server to not send the
     * reply.  See the note in Storage commands regarding malformed
     * requests.
     *
     * The response line to this command can be one of:
     *
     * - "DELETED\r\n" to indicate success
     *
     * - "NOT_FOUND\r\n" to indicate that the item with this key was not
     * found.
     *
     * See the "flush_all" command below for immediate invalidation
     * of all existing items.
     *
     * @return responseData
     */
    public function delete($key): responseData
    {
        $this->connection->send('delete ' . $key . "\r\n");
        return $this->connection->get($this->getData);
    }

}
