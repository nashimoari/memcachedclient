<?php


namespace nashimoari\memCachedClient\connector;


class TCPStubConnector implements iConnector
{

    private $bufferSend;

    public function open($host, $port): bool
    {
        // TODO: Implement open() method.
        return true;
    }

    public function close(): bool
    {
        // TODO: Implement close() method.
    }


    public function send($data): bool
    {
        $this->bufferSend .= $data;
        return true;
    }

    public function get(getData $data): responseData
    {
        // TODO: Implement get() method.
        $responseData = new responseData();
        return $responseData;
    }


    public function bufferSendGet(): string
    {
        return $this->bufferSend;
    }
}