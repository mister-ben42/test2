<?php

namespace MDQ\QuizzBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PartieQuizzRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PartieQuizzRepository extends EntityRepository
{
	
	
	public function tiragedudom($tab){//tirage au sort et test du domaine
		$tabtheme=['Histoire','Sports et loisirs','Géographie','Arts et Littérature','Sciences et nature','Divers'];
		while (!isset($nbtire) OR in_array($dom, $tab)==true)
			{
			$nbtire=mt_rand(0,5);
			$dom=$tabtheme[$nbtire];			
			}		
		$tab[2]=$tab[1];$tab[1]=$tab[0];$tab[0]=$dom;		
		return $tab;
	}
		

	public function getDerParties($iduser,$type,$nb) {// Fonctionnelle
	
		$tab=$this->_em->createQueryBuilder();
		$tab->select('a.q1', 'a.q2', 'a.q3', 'a.q4', 'a.q5', 'a.q6', 'a.q7', 'a.q8', 'a.q9', 'a.q10')
			->from('MDQQuizzBundle:PartieQuizz', 'a')
			->where('a.user = :iduser')
			->setParameter('iduser', $iduser)	
			->andWhere('a.type = :type')
			->setParameter('type', $type)	
			->orderBy('a.id', 'DESC')
			->setMaxResults($nb);
		return $tab->getQuery()
			      ->getResult();
		
	}
	
	public function recupQ($numQ, $iduser){
		  $qb = $this->createQueryBuilder('p')
			->select('p.q'.$numQ)
			->where('p.user = :iduser')
			->setParameter('iduser', $iduser)
			->orderBy('p.id', 'DESC')
			->setMaxResults(1);         

		return $qb->getQuery()
				->getSingleScalarResult();	
	}
	public function recupPartie($iduser){
		  $qb = $this->createQueryBuilder('p')				
				->where('p.user = :iduser')	
				->setParameter('iduser', $iduser)
				->orderBy('p.id', 'DESC')
				->setMaxResults(1);        

		return $qb->getQuery()
				->getSingleResult();	
	}
	
	
/*	public function recupDerPartie(){// plus utilisée
		  $qb = $this->createQueryBuilder('p')				
				->where('p.valid = :valid')	
				->setParameter('valid', true)
				->orderBy('p.id', 'DESC')
				->setMaxResults(3);    
		return $qb->getQuery()
				->getResult();	
	}*/
	public function recupPNonValid(){
		  $qb = $this->createQueryBuilder('p')				
				->where('p.valid = :valid')	
				->setParameter('valid', false)
				->orderBy('p.id', 'DESC');			    
		return $qb->getQuery()
				->getResult();	
	}
	public function recupDerPartieUser($iduser){
		  $qb = $this->createQueryBuilder('p')
				->select('p.date','p.score','p.type')
				->where('p.user = :user')	
				->setParameter('user', $iduser)
				->andWhere('p.valid = :valid')	
				->setParameter('valid', true)
				->orderBy('p.id', 'DESC')
				->setMaxResults(12);    
		return $qb->getQuery()
				->getResult();	
	}
	public function nbParties($game, $date, $type_user){
		if($date!==0){
			$date_min=$date->format('Y-m-d').' 00:00:00';
			$date_max=$date->format('Y-m-d').' 23:59:59';			
		}
		else{
			$date_min='2010-01-01 00:00:00';
			$date_max='2100-12-31 23:59:59';			
		}
		$qb = $this->createQueryBuilder('p')
				->select('COUNT(p)')
				->where('p.date >= :date_min')
				  ->setParameter('date_min', $date_min)
				  ->andWhere('p.date <= :date_max')
				  ->setParameter('date_max', $date_max);
		if($game!="tous"){
				  $qb->andWhere('p.type= :type')
				  ->setParameter('type', $game);
		}
		if($type_user!=2)
		{
			      $qb->leftJoin('p.user','u')
			      ->andWhere('u.bot = :type_user')
			       ->setParameter('type_user', $type_user);
		}
				$qb->andWhere('p.valid = :valid')	
				->setParameter('valid', true)
				->orderBy('p.id', 'DESC');
				
		return $qb->getQuery()->getSingleScalarResult();	
	}

	public function RecupScMoy($game, $date, $nbjr, $type_user)
	{
		if($date!==0){
			$xday=$nbjr-1;
			$date_min=$date->format('Y-m-d').' 00:00:00';
			$date_min= date("Y-m-d", strtotime($date_min." -".$xday." day"));
			$date_max=$date->format('Y-m-d').' 23:59:59';			
		}
		else{
			$date_min='2010-01-01 00:00:00';
			$date_max='2100-12-31 23:59:59';			
		}
		$qb = $this->createQueryBuilder('p')
				->select('AVG(p.score)')
				->where('p.date >= :date_min')
				  ->setParameter('date_min', $date_min)
				  ->andWhere('p.date <= :date_max')
				  ->setParameter('date_max', $date_max)
				  ->andWhere('p.score>0');
		if($game!="tous"){
				  $qb->andWhere('p.type= :type')
				  ->setParameter('type', $game);
		}
		if($type_user!=2)
		{
			      $qb->leftJoin('p.user','u')
			      ->andWhere('u.bot = :type_user')
			       ->setParameter('type_user', $type_user);
		}
				$qb->andWhere('p.valid = :valid')	
				->setParameter('valid', true)
				->orderBy('p.id', 'DESC');
				
		return $qb->getQuery()->getSingleScalarResult();	
	}	
	
/*	public function nbParties($game, $date, $type_user){
		if($date!==0){
			$date_min=$date->format('Y-m-d').' 00:00:00';
			$date_max=$date->format('Y-m-d').' 23:59:59';			
		}
		else{
			$date_min='2010-01-01 00:00:00';
			$date_max='2100-12-31 23:59:59';			
		}
		$query=$this->_em->createQuery('SELECT COUNT (q) FROM MDQQuizzBundle:PartieQuizz q WHERE q.type= :type AND q.date>= :date_min AND q.date<= :date_max' );
		$query->setParameter('type', $game);
		$query->setParameter('date_min',$date_min);
		$query->setParameter('date_max',$date_max);
		return $query->getSingleScalarResult();// A vérififer.
	}
*/
}