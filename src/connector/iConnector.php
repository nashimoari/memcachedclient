<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace nashimoari\memCachedClient\connector;

/**
 *
 * @author nashimoari
 */
interface iConnector
{
    public function open($host, $port): bool;
    
    public function close(): bool;
    
    public function send($data): bool;
    
    public function get(getData $data):responseData;
    
}
