<?php

namespace AppBundle\Contract\Manager;

use AppBundle\Entity\Post;
use Doctrine\Common\Collections\Collection;
use Pagerfanta\Pagerfanta;

/**
 * Interface PostManagerInterface
 * @package AppBundle\Contract\Manager
 */
interface PostManagerInterface
{
    /**
     * @param int $page
     * @return Pagerfanta
     */
    public function findLatest(int $page): Pagerfanta;

    /**
     * @param int $page
     * @return Collection|Post[]
     */
    public function findBySearchQuery(int $page): Collection;

    /**
     * @param array $parameters
     * @param array $option
     * @return Collection|Post[]
     */
    public function findBy(array $parameters, array $option = array()): Collection;

}