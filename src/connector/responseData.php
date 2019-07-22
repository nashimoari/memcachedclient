<?php


namespace nashimoari\memCachedClient\connector;


class responseData
{

    /**
     * Ответ который был получен от сервера
     * @var string
     */
    public $answer;

    /**
     * код ответа. Описаны в MemCachedClientSettings.json
     * @var string
     */
    public $code;

    /**
     * расширенная информация по коду
     * @var string
     */
    public $detail;

    /**
     * Интервал времени после которого был получен ответ (секунды)
     * @var integer
     */
    public $responseTimeInterval;

}