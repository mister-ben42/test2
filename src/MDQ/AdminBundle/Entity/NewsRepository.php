<?php

namespace MDQ\AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;


class NewsRepository extends EntityRepository
{
	public function recupNews()
	{
	  $qb=$this->createQueryBuilder('n');
			$qb->select('n.titre, n.texte, n.dateCreate')
				->where('n.publication = :publication')
				->setParameter('publication', true)
				->orderBy('n.priorite', 'DESC')
				->addOrderBy('n.id', 'DESC');							
	    $newsA=$qb->getQuery()->getResult();
	    return $newsA;
	}
}
