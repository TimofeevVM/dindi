<?php

declare(strict_types=1);

namespace Blog\Domain;

final class Post
{
    private readonly \DateTime $createdAt;
    private ?\DateTime $updatedAt = null;

    public function __construct(
        private readonly string $id,
        private string $title,
        private string $body,
    ) {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function changeBody(string $body): void
    {
        $this->body = $body;
        $this->updatedAt = new \DateTime();
    }

    public function changeTitle(string $title): void
    {
        $this->title = $title;
        $this->updatedAt = new \DateTime();
    }
}
