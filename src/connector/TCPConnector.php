<?php


namespace nashimoari\memCachedClient\connector;

use Exception;

class TCPConnector implements iConnector
{
    private $fp;

    public function open($host, $port): bool
    {
        $this->fp = stream_socket_client($host . ":" . $port, $errno, $errstr, 30);
        if (!$this->fp) {
            throw new Exception('Can\'t connect to ' . $host . ':' . $port);
        }
        stream_set_blocking($this->fp, false);

        return true;
    }

    public function close(): bool
    {
        return fclose($this->fp);
    }


    public function send($data): bool
    {
        return fwrite($this->fp, $data);
    }

    public function get(getData $data): responseData
    {
        $dtStart = microtime(true);

        $responseData = new responseData();


        $buff = '';
        while (!feof($this->fp)) {
            $buff .= fread($this->fp, 1024);

            // check answer

            foreach ($data->waitFor as $item) {
                if (strpos($buff, $item['val']) !== false) {
                    $responseData->code = $item['code'];
                    $responseData->detail = $item['detail'];
                    break 2;
                }
            }


            // check timeout
            if ((microtime(true) - $dtStart) > ($data->timeOut)) {
                $responseData->code = 'FAILURE';
                $responseData->detail = 'timeout';
                break;
            }

        }

        $responseData->answer = $buff;
        $responseData->responseTimeInterval = microtime(true) - $dtStart;

        return $responseData;
    }

}