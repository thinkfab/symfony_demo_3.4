<?php


namespace AppBundle\Manager;


use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class PostManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function findLatest($page) {

        return $this->entityManager->getRepository(Post::class)->findLatest($page);
    }

    public function findBySearchQuery($query) {

        return $this->entityManager->getRepository(Post::class)->findBySearchQuery($query);
    }

    public function findByAuthor(User $user) {

        return $this->entityManager->getRepository(Post::class)->findBy(['author' => $user], ['publishedAt' => 'DESC']);
    }
}