<?php

namespace MDQ\AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;


class NewsRepository extends EntityRepository
{
	public function recupNewsPublic()
	{
	  $qb=$this->createQueryBuilder('n');
			$qb->select('n.titre, n.texte, n.dateCreate')
				->where('n.publication = :publication')
				->setParameter('publication', 1)
				->orderBy('n.priorite', 'DESC')
				->addOrderBy('n.id', 'DESC');							
	    $newsA=$qb->getQuery()->getResult();
	    return $newsA;
	}
	public function recupNewsAdmin()
	{
	  $qb=$this->createQueryBuilder('n');
			$qb->select('n.titre, n.texte, n.dateCreate')
				->where('n.publication = :publication')
				->setParameter('publication', 2)
				->orderBy('n.priorite', 'DESC')
				->addOrderBy('n.id', 'DESC');							
	    $newsA=$qb->getQuery()->getResult();
	    return $newsA;
	}
}
