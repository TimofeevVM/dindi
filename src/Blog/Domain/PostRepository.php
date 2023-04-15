<?php

declare(strict_types=1);

namespace Blog\Domain;

interface PostRepository
{
    public function save(Post $post): void;

    /**
     * @throws \Exception
     */
    public function ofId(string $id): Post;
}
