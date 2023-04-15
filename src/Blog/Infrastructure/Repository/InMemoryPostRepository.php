<?php

declare(strict_types=1);

namespace Blog\Infrastructure\Repository;

use Blog\Domain\Post;

final class InMemoryPostRepository
{
    private array $storage = [];
    public function save(Post $post): void
    {
        $this->storage[$post->getId()] = $post;
    }

    public function ofId(string $id): Post
    {
        if (isset($this->storage[$id]) === false) {
            throw new \OutOfBoundsException('Post not found');
        }

        return $this->storage[$id];
    }
}
