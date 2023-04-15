<?php

namespace Shared\Infrastructure\Dbal;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;

final class ConnectionFactory
{
    /**
     * @throws Exception
     */
    public static function fromEnv(): Connection
    {
        return DriverManager::getConnection(
            [
                'dbname' => $_ENV['APP_DATABASE_NAME'],
                'user' => $_ENV['APP_DATABASE_USER'],
                'port' => $_ENV['APP_DATABASE_PORT'],
                'password' => $_ENV['APP_DATABASE_SECRET'],
                'host' => $_ENV['APP_DATABASE_HOST'],
                'driver' => $_ENV['APP_DATABASE_DRIVER'],
            ]
        );
    }
}
