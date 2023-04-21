<?php

use Blog\Domain\PostRepository;
use Blog\Infrastructure\Repository\DbalPostRepository;
use Shared\Infrastructure\Dbal\ConnectionFactory;

return [
    PostRepository::class => DI\autowire(DbalPostRepository::class),
    \Doctrine\DBAL\Connection::class => DI\factory([ConnectionFactory::class, 'fromEnv'])
];
