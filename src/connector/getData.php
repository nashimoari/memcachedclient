<?php


namespace nashimoari\memCachedClient\connector;


class getData
{

    /**
     * Перечень ответов которые мы ожидаем
     * @var array
     */
    public $waitFor = [];

    /**
     * Таймаут ожидания данных в которых будет содержаться текст указанный в waitFor. Если так и не дождались то возвращаем код ответа ERR_TIMEOUT
     * @var integer
     */
    public $timeOut;

}