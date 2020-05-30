<?php


namespace App\Controller\Testing;


use App\Entity\News;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;

class SecondTestController extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    /**
     * @Route("/anotherTest", name="another_test")
     */
    public function anotherTesting()
    {

        $em = $this->getEntityManager();
        $id = 1;
        $author = $em->getRepository(User::class)->find($id);
        $query = $em->createQueryBuilder()
            ->select("COUNT(n)")
            ->from(News::class, 'n')
            ->getQuery();

        $result = $query->getSingleScalarResult();
        dump($result);
        exit;
    }

}