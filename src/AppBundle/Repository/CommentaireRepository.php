<?php

namespace AppBundle\Repository;

/**
 * CommentaireRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentaireRepository extends \Doctrine\ORM\EntityRepository {

    public function getCommByArticle($article) {
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.article = :article')
                ->setParameter('article', $article);
        return $qb->getQuery()->getResult();
    }

}
