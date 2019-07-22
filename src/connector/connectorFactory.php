<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace nashimoari\memCachedClient\connector;

use Exception;

/**
 * Factory for create connection
 *
 * @author nashimoari
 */
class connectorFactory
{

    Public static function create_connection($type)
    {
        if ($type == 'TCP') {
            return new TCPConnector();
        }

        if ($type == 'TCP_STUB') {
            return new TCPStubConnector();
        }

        throw new Exception('No data provider for this type');
    }
}
