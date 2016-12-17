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
	public function majFinPartie($iduser, $scoreQ)
	{
		 $qb = $this->createQueryBuilder('p')				
				->where('p.user = :iduser')	
				->setParameter('iduser', $iduser)
				->orderBy('p.id', 'DESC')
				->setMaxResults(1); 
		$partie=$qb->getQuery()->getSingleResult();
		$oldnbQjoue=$partie->getNbQjoue();
			$oldscore=$partie->getScore();
			$newscore=$oldscore+$scoreQ;
		$partie->setScore($newscore);
		$partie->setNbQjoue($oldnbQjoue+1);	
		return $partie;
	}
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
	public function createNewP($game, $user)
	{
		if($game=="MasterQuizz"){$nbP=5;$nbQ=10;}
		elseif($game=="MuQuizz" || $game=="FfQuizz" || $game=="ArQuizz" || $game=="LxQuizz"){$nbP=1;$nbQ=8;}
		elseif($game=="SexyQuizz" || $game=="TvQuizz"){$nbP=1;$nbQ=8;}
		if($game=="FfQuizz" || $game=="LxQuizz"){$nbP=4;}// Temporaire à modifier ensuite
		$derPjoues=$this->getDerParties($user->getId(),$game,$nbP);
		$tabDerQ=[];
		foreach($derPjoues as $partie)
		{
			for($numQ=1; $numQ<($nbQ+1); $numQ++)
			{
			$idQ=$partie['q'.$numQ];
			array_push($tabDerQ, $idQ);
			}
		}
/*		if($game=="MasterQuizz")
		{
			$tabdom3=[]; $tabtheme=[]; $tabidQ=[];$tabdom=['x','x','x'];
			for($numQ=1; $numQ<11; $numQ++) {
				$dom=$this->tiragedudom($tabdom);
				$questionRepository=$this->getEntityManager()->getRepository('MDQQuestionBundle:Question');
				$qtire=$questionRepository->tirageduneQMq($numQ, $dom[0], $tabdom3, $tabtheme, $tabDerQ, $tabidQ);
				$tabdom=$dom;			 
				$tabidQ[$numQ-1]=$qtire['id'];			
				$tabdom3[$numQ-1]=$qtire['dom3'];
				$tabtheme[$numQ-1]=$qtire['theme'];
			}
			$scUser=$user->getScUser();
			$scUser->setNbPMq($scUser->getNbPMq()+1);
		}
*/		
		if($game=="MasterQuizz")
		{
		
			$tabidQ=$this->getEntityManager()->getRepository('MDQQuestionBundle:Question')->tiragePartieMq($tabDerQ);
				
			$scUser=$user->getScUser();
			$scUser->setNbPMq($scUser->getNbPMq()+1);
		}
		else
		{
			$scUser=$user->getScUser();
			if($game=="TvQuizz"){$scUser->setNbPTv($scUser->getNbPTv()+1);}
			elseif($game=="SexyQuizz"){$scUser->setNbPSx($scUser->getNbPSx()+1);}
			elseif($game=="MuQuizz"){$scUser->setNbPMu($scUser->getNbPMu()+1);}
			elseif($game=="FfQuizz"){$scUser->setNbPFf($scUser->getNbPFf()+1);}
			elseif($game=="ArQuizz"){$scUser->setNbPAr($scUser->getNbPAr()+1);}
			elseif($game=="LxQuizz"){$scUser->setNbPLx($scUser->getNbPLx()+1);}
			$tabidQ=$this->getEntityManager()->getRepository('MDQQuestionBundle:Question')->tiragePartieQM($tabDerQ, $game);
		}
		$scUser->setNbPtot($scUser->getNbPtot()+1);
		$pseudo=$user->getUsername();
		$partie=new PartieQuizz();
		$partie->setUsername($pseudo);
	

		$partie->setQ1($tabidQ[0]);			
		$partie->setQ2($tabidQ[1]);
		$partie->setQ3($tabidQ[2]);
		$partie->setQ4($tabidQ[3]);
		$partie->setQ5($tabidQ[4]);
		$partie->setQ6($tabidQ[5]);
		$partie->setQ7($tabidQ[6]);
		$partie->setQ8($tabidQ[7]);
		if($nbQ>8){$partie->setQ9($tabidQ[8]);}
		if($nbQ>9){$partie->setQ10($tabidQ[9]);}
		//$partie->setQ1(1);//pour faire des essais sur l'affichage
		//$partie->setQ2(2);//pour faire des essais sur l'affichage
		//$partie->setQ3(3);//pour faire des essais sur l'affichage
		$partie->setType($game);
		$partie->setUser($user);
		
		return $partie;
	
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
