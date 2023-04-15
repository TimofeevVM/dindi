<?php

declare(strict_types=1);

namespace Blog\Infrastructure\Repository;

use Blog\Domain\Post;
use Blog\Domain\PostRepository;
use Laminas\Hydrator\NamingStrategy\MapNamingStrategy;
use Shared\Infrastructure\Dbal\ConnectionFactory;
use Shared\Infrastructure\Hydrator\TypedReflectionHydrator;

final class DbalPostRepository implements PostRepository
{
    public function save(Post $post): void
    {
        ConnectionFactory::fromEnv()->insert(
            'post',
            [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'body' => $post->getBody(),
                'created_at' => $post->getCreatedAt()->format(\DATE_ATOM),
                'updated_at' => $post->getUpdatedAt()?->format(\DATE_ATOM),
            ]
        );
    }

    public function ofId(string $id): Post
    {
        $data = ConnectionFactory::fromEnv()
            ->createQueryBuilder()
            ->from('post')
            ->select('*')
            ->where('id = ?')
            ->setParameter(0, $id)
            ->executeQuery()
            ->fetchAllAssociative();

        if (empty($data)) {
            throw new \Exception('Not found');
        }

        if (is_array($data)) {
            $data = current($data);
        } else {
            throw new \Exception('Not found');
        }

        $namingStrategy = MapNamingStrategy::createFromHydrationMap([
            'created_at' => 'createdAt',
        ]);

        $hydrator = new TypedReflectionHydrator();
        $hydrator->setNamingStrategy($namingStrategy);
        $refClass = (new \ReflectionClass(Post::class))
            ->newInstanceWithoutConstructor();
        $object = $hydrator->hydrate($data, $refClass);

        if ($object instanceof Post) {
            return $object;
        }

        throw new \Exception('Not found');
    }
}
