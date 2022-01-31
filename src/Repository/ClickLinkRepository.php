<?php

namespace App\Repository;

use App\Entity\ClickLink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClickLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClickLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClickLink[]    findAll()
 * @method ClickLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClickLinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClickLink::class);
    }
    public function add(ClickLink $link)
    {
        $this->getEntityManager()->persist($link);
        $this->getEntityManager()->flush();
    }

    public function remove(ClickLink $link)
    {
        $this->getEntityManager()->remove($link);
        $this->getEntityManager()->flush();
    }
}
