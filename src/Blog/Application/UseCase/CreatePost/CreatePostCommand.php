<?php

declare(strict_types=1);

namespace Blog\Application\UseCase\CreatePost;

readonly class CreatePostCommand
{
    public function __construct(
        public string $title,
        public string $body
    ) {
    }
}
