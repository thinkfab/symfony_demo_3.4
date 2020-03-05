<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Pagerfanta\Pagerfanta;

interface PostInterface
{
    public function findLatest($page):Pagerfanta;

    public function findBySearchQuery($rawQuery, $limit = Post::NUM_ITEMS):ArrayCollection;

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
}
