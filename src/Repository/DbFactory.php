<?php

namespace Freyr\RPA\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class DbFactory
{

    public static function create(): Connection
    {
        $connectionParams = [
            'dbname' => 'rpa',
            'user' => 'rpa',
            'password' => 'rpa',
            'host' => 'rpa-db',
            'driver' => 'pdo_mysql',
            'charset' => 'utf8mb4'
        ];

        return DriverManager::getConnection($connectionParams);
    }
}
