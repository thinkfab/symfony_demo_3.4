<?php


namespace AppBundle\Manager;

use AppBundle\Entity\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Pagerfanta\Pagerfanta;


class PostManager implements PostInterface
{

    private $postRepository;

    public function __construct(EntityManager $em)
    {

        $this->postRepository = $em->getRepository(Post::class);
    }

    /**
     * @param int $page
     *
     * @return Pagerfanta
     */
    public function findLatest($page):Pagerfanta
    {
        return  $this->postRepository->findLatest($page);
    }

    /**
     * @param $rawQuery
     * @param int $limit
     * @return ArrayCollection
     */
    public function findBySearchQuery($rawQuery, $limit = Post::NUM_ITEMS):ArrayCollection
    {
        return $this->postRepository->findBySearchQuery($rawQuery, $limit);
    }

    //Admin methods
    /**
     * @param $user
     * @return array|Post[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->postRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

}