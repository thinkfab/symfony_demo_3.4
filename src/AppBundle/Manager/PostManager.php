<?php

namespace AppBundle\Manager;

use AppBundle\Contract\Manager\PostManagerInterface;
use AppBundle\Entity\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Exception;
use Pagerfanta\Pagerfanta;

/**
 * Class PostManager
 * @package AppBundle\Manager
 */
class PostManager implements PostManagerInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getRepository()
    {
        return $this->em->getRepository(Post::class);
    }

    /**
     * @param int $page
     * @return Pagerfanta
     * @throws Exception
     */
    public function findLatest(int $page): Pagerfanta
    {
        return $this->getRepository()->findLatest($page);
    }

    /**
     * @param int $query
     * @return Collection|Post[]
     */
    public function findBySearchQuery($query): Collection
    {
        return $this->getRepository()->findBySearchQuery($query);
    }

    /**
     * @param array $parameters
     * @param array $option
     * @return Collection|Post[]
     */
    public function findBy(array $parameters, array $option = array()): Collection
    {
        return new ArrayCollection($this->getRepository()->findBy($parameters, $option));
    }
}