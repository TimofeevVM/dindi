<?php

declare(strict_types=1);

namespace Blog\Infrastructure\Http;

use Blog\Application\UseCase\CreatePost\CreatePostCommand;
use Blog\Application\UseCase\CreatePost\CreatePostHandler;
use Blog\Infrastructure\Repository\DbalPostRepository;

final class PostController
{
    public function createPost(): never
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        $command = new CreatePostCommand($data['title'], $data['body']);
        $handler = new CreatePostHandler(new DbalPostRepository());
        $response = $handler($command);

        echo json_encode([
            'id' => $response->id
        ]);

        exit(0);
    }
}
