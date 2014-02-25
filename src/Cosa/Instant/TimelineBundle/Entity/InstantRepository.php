<?php

namespace Cosa\Instant\TimelineBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * InstantRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InstantRepository extends EntityRepository
{

    public function getList($id, $off=0, $nb=100)
    {
        $q = $this->_em->createQueryBuilder()
            ->select('t,i')
            ->from('CosaInstantTimelineBundle:Instant', 'i')
            ->join('i.tweets', 't')
            ->where('i.id = '.$id)
            ->setFirstResult($off)
            ->setMaxResults($nb);
 
        return $q->getQuery()->getResult();
    }

    public function getLastId()
    {
        try{
          return $this->getEntityManager()
            ->createQuery(
                'SELECT i.id
                 FROM CosaInstantTimelineBundle:Instant i
                 ORDER BY i.id DESC'
            )
            ->setMaxResults(1)
            ->getSingleResult();
        }catch(\Exception $e){
          return false;
        }
    }

    public function findByUserNTitle($user_id,$title)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT i
                 FROM CosaInstantTimelineBundle:Instant i
                 WHERE i.title=:title
                 AND i.user=:user_id
                 LIMIT 1'
            )
            ->setParameter('user_id',$user_id)
            ->setParameter('title',$title)
            ->setMaxResults(1)
            ->getResult();
    }

}
