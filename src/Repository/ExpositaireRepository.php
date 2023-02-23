<?php

namespace App\Repository;

use App\Entity\Expositaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Expositaire>
 *
 * @method Expositaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expositaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expositaire[]    findAll()
 * @method Expositaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpositaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Expositaire::class);
    }

    public function save(Expositaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Expositaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getEtat()
    {
        $connexion = $this->_em->getConnection();

        $requete = "SELECT COUNT(expositaire.id) total FROM expositaire";
        $resultat = $connexion->executeQuery($requete);
        $data = $resultat->fetchAllAssociative();

        $requete1 = "SELECT COUNT(user.id) total FROM user";
        $resultat1 = $connexion->executeQuery($requete1);
        $data1 = $resultat1->fetchAllAssociative();

        return [
            "etat" => $data,
            "etat1" => $data1,
        ];
    }

//    /**
//     * @return Expositaire[] Returns an array of Expositaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Expositaire
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
