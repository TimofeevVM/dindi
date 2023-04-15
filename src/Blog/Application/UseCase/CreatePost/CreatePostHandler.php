<?php

declare(strict_types=1);

namespace Blog\Application\UseCase\CreatePost;

use Blog\Domain\Post;
use Blog\Domain\PostRepository;

final class CreatePostHandler
{
    public function __construct(
        private readonly PostRepository $postRepository
    )
    {
    }

    public function __invoke(CreatePostCommand $command): CreatePostResponse
    {
        $post = new Post(
            uniqid('post'),
            $command->title,
            $command->body
        );

        $this->postRepository->save($post);

        return new CreatePostResponse($post->getId());
    }
}
