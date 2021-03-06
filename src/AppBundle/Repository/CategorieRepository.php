<?php

namespace AppBundle\Repository;

use \Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * CategorieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategorieRepository extends \Doctrine\ORM\EntityRepository {

    public function getCategorie($nbParPage, $page) {




        $qb = $this->createQueryBuilder('c')
                ->leftJoin('c.articles', 'a')
                ->addSelect('a')
                ->Where('a.publication = :publication')
                ->setParameter('publication', 1)
                ->orderBy('a.date', 'DESC')
                ->setFirstResult(($page - 1) * $nbParPage)
                ->setMaxResults($nbParPage);

        //$query = $qb->getQuery();
        //return $query->getResult();
        return new Paginator($qb);
    }

}
