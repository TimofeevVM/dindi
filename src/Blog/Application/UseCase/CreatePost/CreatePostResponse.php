<?php

declare(strict_types=1);

namespace Blog\Application\UseCase\CreatePost;

readonly class CreatePostResponse
{
    public function __construct(
        public string $id
    )
    {
    }
}
