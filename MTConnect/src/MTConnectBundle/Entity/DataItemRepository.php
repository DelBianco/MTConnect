<?php

namespace MTConnectBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

/**
 * DataItemRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DataItemRepository extends EntityRepository
{

    public function findTypesByMachine(){
        $em = $this->getEntityManager();
        $result = $em->createQueryBuilder()
            ->select('di.type as dataItemType','m.name as machineName')
            ->from('MTConnectBundle:DataItem', 'di')
            ->leftJoin('MTConnectBundle:Machine','m',Join::WITH, 'di.machine = m.id')
            ->orderBy('m.id, di.type')
            ->groupBy('m.name,di.type')
            ->getQuery()
            ->getResult();
        return $result;
    }
}
