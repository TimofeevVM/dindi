<?php

declare(strict_types=1);

namespace Blog\Application\UseCase\CreatePost;

use Blog\Domain\Post;
use Blog\Infrastructure\Repository\DbalPostRepository;

final class CreatePostHandler
{
    public function __invoke(CreatePostCommand $command): CreatePostResponse
    {
        $post = new Post(
            uniqid('post'),
            $command->title,
            $command->body
        );

        $repository = new DbalPostRepository();
        $repository->save($post);

        return new CreatePostResponse($post->getId());
    }
}
