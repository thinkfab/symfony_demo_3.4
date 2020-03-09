<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Post;
use Pagerfanta\Pagerfanta;

interface PostInterface
{
    public function findLatest($page);

    public function findBySearchQuery($rawQuery, $limit = Post::NUM_ITEMS);

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
}
