<?php

namespace MDQ\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ScUserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ScUserRepository extends EntityRepository
{	
	public function recupUserByCrit($crit)
	{
		$tab=$this->_em->createQueryBuilder();
		$tab->select('s')
			->from('MDQUserBundle:ScUser', 's')
			->where('s.'.$crit.' IS NOT NULL')
			->leftJoin('s.usermap', 'u')
			->andwhere('u.supprime!=1')
			->andwhere('u.roles NOT LIKE :roles1')
			->andwhere('u.roles NOT LIKE :roles2')
			->setParameter('roles1', '%"ROLE_ADMIN"%')
			->setParameter('roles2', '%"ROLE_SUPER_ADMIN"%')
			->orderBy('s.'.$crit, 'DESC');
		return $tab->getQuery()
			      ->getResult();	
	}
	
	public function recupUserofDayMq(){
		$tab=$this->_em->createQueryBuilder();
		//$tab->select('s.scofDayMq','s.highClassDayMq', 's.numHighClassDayMq')
		$tab->select('s')
			->from('MDQUserBundle:ScUser', 's')
			->where('s.scofDayMq IS NOT NULL')
			->leftJoin('s.usermap', 'u')
			->where('u.supprime!=1')
			->andwhere('u.roles NOT LIKE :roles1')
			->andwhere('u.roles NOT LIKE :roles2')
			->setParameter('roles1', '%"ROLE_ADMIN"%')
			->setParameter('roles2', '%"ROLE_SUPER_ADMIN"%')
		//$tab = $this->createQueryBuilder('s')
			->orderBy('s.scofDayMq', 'DESC');
		return $tab->getQuery()
			      ->getResult();	
	}
	public function recupUserofDayQM(){
		$tab=$this->_em->createQueryBuilder();
		$tab->select('s')
			->from('MDQUserBundle:ScUser', 's')
		/*	->where('s.scofDayLx IS NOT NULL')
			->orWhere('s.scofDayAr IS NOT NULL')
			->orWhere('s.scofDayMu IS NOT NULL')
			->orWhere('s.scofDayFf IS NOT NULL')*/
			->where('s.scofDayTM IS NOT NULL')
			->leftJoin('s.usermap', 'u')
			->where('u.supprime!=1')
			->andwhere('u.roles NOT LIKE :roles1')
			->andwhere('u.roles NOT LIKE :roles2')
			->setParameter('roles1', '%"ROLE_ADMIN"%')
			->setParameter('roles2', '%"ROLE_SUPER_ADMIN"%')
			->orderBy('s.scofDayTM', 'DESC');
		return $tab->getQuery()
			      ->getResult();	
	}
	
/*	public function recupUserofMonth(){
		$tab=$this->_em->createQueryBuilder();
		//$tab->select('s.scofDayMq','s.highClassDayMq', 's.numHighClassDayMq')
		$tab->select('s')
			->from('MDQUserBundle:ScUser', 's')
			->where('s.sumtop10month IS NOT NULL')
		//$tab = $this->createQueryBuilder('s')
			->orderBy('s.sumtop10month', 'DESC');
		return $tab->getQuery()
			      ->getResult();	
	}*/
	public function recupUserofWeek(){
		$tab=$this->_em->createQueryBuilder();
		//$tab->select('s.scofDayMq','s.highClassDayMq', 's.numHighClassDayMq')
		$tab->select('s')
			->from('MDQUserBundle:ScUser', 's')
			->where('s.sumtop5weekMq IS NOT NULL')
			->leftJoin('s.usermap', 'u')
			->where('u.supprime!=1')
			->andwhere('u.roles NOT LIKE :roles1')
			->andwhere('u.roles NOT LIKE :roles2')
			->setParameter('roles1', '%"ROLE_ADMIN"%')
			->setParameter('roles2', '%"ROLE_SUPER_ADMIN"%')
		//$tab = $this->createQueryBuilder('s')
			->orderBy('s.sumtop5weekMq', 'DESC');
		return $tab->getQuery()
			      ->getResult();
	
	}
	public function recupHighScore($crit,$page,$nbparPage){
		// penser a proteger le $crit
		if ($page < 1) {
			$page=1;
		}
		$tab=$this->_em->createQueryBuilder();
		$tab->from('MDQUserBundle:ScUser', 's');
		$tab->leftJoin('s.usermap', 'u')
			->select('u.username','u.id')
			->where('u.supprime!=1')
			->andwhere('u.roles NOT LIKE :roles1')
			->andwhere('u.roles NOT LIKE :roles2')
			->setParameter('roles1', '%"ROLE_ADMIN"%')
			->setParameter('roles2', '%"ROLE_SUPER_ADMIN"%');
			 // Au tout debut, me permet de choisir ceux que j'inclus ou non (les supprime, l'admin, ...)
			
		
		if($crit=='MedMq' || $crit=='MedKm' || $crit=='MedTm' || $crit=='MedAr' || $crit=='MedFf' || $crit=='MedLx' || $crit=='MedMu')
		{
			if($crit=='MedMq'){$type='mq';$clsmt='highClassDayMq';}
			elseif($crit=='MedKm'){$type='km'; $clsmt='highClassKM';}
			elseif($crit=='MedTm'){$type='tm'; $clsmt='highClassDayTM';}
			elseif($crit=='MedAr'){$type='ar'; $clsmt='highClassDayAr';}
			elseif($crit=='MedFf'){$type='ff'; $clsmt='highClassDayFf';}
			elseif($crit=='MedLx'){$type='lx'; $clsmt='highClassDayLx';}
			elseif($crit=='MedMu'){$type='mu'; $clsmt='highClassDayMu';}
			
			$tab->addSelect('s.'.$clsmt,'s.id')
			     ->leftJoin('s.medailles', 'm')
				->addSelect('m.'.$type.'1','m.'.$type.'2','m.'.$type.'3','m.'.$type.'4','m.'.$type.'5')
				->andWhere('s.'.$clsmt.' IS NOT NULL')
				->andWhere('s.'.$clsmt.'>0');
		
			$tab->orderBy('m.'.$type.'1','DESC')
				->addOrderBy('m.'.$type.'2','DESC')
				->addOrderBy('m.'.$type.'3','DESC')
				->addOrderBy('m.'.$type.'4','DESC')
				->addOrderBy('m.'.$type.'5','DESC')
				->addOrderBy('s.'.$clsmt,'ASC')
				;				
		}
		elseif($crit=="totMed")
		{
			$tab->addSelect('s.id')
			     ->leftJoin('s.medailles', 'm')
				->addSelect('m.'.$crit)
				->andWhere('m.'.$crit.' IS NOT NULL')
				->andWhere('m.'.$crit.'>0')
				->orderBy('m.'.$crit, 'DESC');
		
		}
		else
	{
		$tab->addSelect('s.'.$crit);
			//Plus utile ce qui suit ?
			if($crit=="highClassDayMq") {$tab->addselect('s.numHighClassDayMq');}
			elseif($crit=="highClassDayTM") {$tab->addselect('s.numHighClassDayTM');}
			elseif($crit=="highClassKM"){$tab->addselect('s.numHighClassKM');}
			elseif($crit=="highClassDayAr"){$tab->addselect('s.numHighClassDayAr');}
			elseif($crit=="highClassDayFf"){$tab->addselect('s.numHighClassDayFf');}
			elseif($crit=="highClassDayLx"){$tab->addselect('s.numHighClassDayLx');}
			elseif($crit=="highClassDayMu"){$tab->addselect('s.numHighClassDayMu');}
		$tab->andWhere('s.'.$crit.'!=0')
			->andWhere('s.'.$crit.' IS NOT NULL');
			if($crit=="prctBrtotMq") {$tab->andWhere('s.nbQtotMq>99');}
			elseif($crit=="prctBrhMq") {$tab->andWhere('s.nbQhMq>50');}
			elseif($crit=="prctBrgMq") {$tab->andWhere('s.nbQgMq>50');}
			elseif($crit=="prctBrdMq") {$tab->andWhere('s.nbQdMq>50');}
			elseif($crit=="prctBralMq") {$tab->andWhere('s.nbQalMq>50');}
			elseif($crit=="prctBrslMq") {$tab->andWhere('s.nbQslMq>50');}
			elseif($crit=="prctBrsnMq") {$tab->andWhere('s.nbQsnMq>50');}
			elseif($crit=="scMoyMq") {$tab->andWhere('s.nbPMq>9');}
			elseif($crit=="ScMoyAr") {$tab->andWhere('s.nbPAr>9');}
			elseif($crit=="ScMoyLx") {$tab->andWhere('s.nbPLx>9');}
			elseif($crit=="ScMoyMu") {$tab->andWhere('s.nbPMu>9');}
			elseif($crit=="ScMoyFf") {$tab->andWhere('s.nbPFf>9');}
			elseif($crit=="nbQvalid"){$tab->andWhere('s.id!=1');}
			      
			//Plus utile les condition sur les Classements.
			if($crit=="highClassDayMq") {$tab->orderBy('s.'.$crit, 'ASC');
										$tab->addOrderBy('s.numHighClassDayMq','DESC');
			}
			elseif($crit=="highClassDayTM") {$tab->orderBy('s.'.$crit, 'ASC');
										$tab->addOrderBy('s.numHighClassDayTM','DESC');
			}
			elseif($crit=="highClassKM") {$tab->orderBy('s.'.$crit, 'ASC');
										$tab->addOrderBy('s.numHighClassKM','DESC');
			}
			elseif($crit=="highClassDayAr") {$tab->orderBy('s.'.$crit, 'ASC');
										$tab->addOrderBy('s.numHighClassDayAr','DESC');
			}
			elseif($crit=="highClassDayFf") {$tab->orderBy('s.'.$crit, 'ASC');
										$tab->addOrderBy('s.numHighClassDayFf','DESC');
			}
			elseif($crit=="highClassDayLx") {$tab->orderBy('s.'.$crit, 'ASC');
										$tab->addOrderBy('s.numHighClassDayLx','DESC');
			}
			elseif($crit=="highClassDayMu") {$tab->orderBy('s.'.$crit, 'ASC');
										$tab->addOrderBy('s.numHighClassDayMu','DESC');
			}
			else {$tab->orderBy('s.'.$crit, 'DESC');}
			$tab->addOrderBy('s.id');// Pour eviter des erreurs en cas d'aglite.
			// On definit l'article a partir duquel commencer la liste
	}
		if($nbparPage!=0)// du coup si nb par page=0: prend toutes les valeurs.
		{
			$tab->setFirstResult(($page-1) * $nbparPage)
				// Ainsi que le nombre d'articles a afficher
				->setMaxResults($nbparPage);
				// Enfin, on retourne l'objet Paginator correspondant a la requete construite
				// (n'oubliez pas le use correspondant en debut de fichier)
		}
		return $tab->getQuery()
			      ->getResult();
			
	}
	public function nbHighScore($crit)
	{
		$tab=$this->_em->createQueryBuilder();
		$tab->from('MDQUserBundle:ScUser', 's');
		$tab->leftJoin('s.usermap', 'u')
			->where('u.supprime!=1')
			->andwhere('u.roles NOT LIKE :roles1')
			->andwhere('u.roles NOT LIKE :roles2')
			->setParameter('roles1', '%"ROLE_ADMIN"%')
			->setParameter('roles2', '%"ROLE_SUPER_ADMIN"%');
		if($crit=='MedMq' || $crit=='MedKm' || $crit=='MedTm' || $crit=='MedAr' || $crit=='MedFf' || $crit=='MedLx' || $crit=='MedMu'){
			if($crit=='MedMq'){$clsmt='highClassDayMq';}
			elseif($crit=='MedKm'){$clsmt='highClassKM';}
			elseif($crit=='MedTm'){$clsmt='highClassDayTM';}
			elseif($crit=='MedAr'){$clsmt='highClassDayAr';}
			elseif($crit=='MedFf'){$clsmt='highClassDayFf';}
			elseif($crit=='MedLx'){$clsmt='highClassDayLx';}
			elseif($crit=='MedMu'){$clsmt='highClassDayMu';}
		$tab->select('s')
			->andWhere('s.'.$clsmt.' IS NOT NULL')
			->andWhere('s.'.$clsmt.'>0');
		}
		else
		{
			$tab->select('s.'.$crit)
				->andWhere('s.'.$crit.'!=0')
				->andWhere('s.'.$crit.' IS NOT NULL');
			if($crit=="prctBrtotMq") {$tab->andWhere('s.nbQtotMq>99');}
			if($crit=="ScMoyMq") {$tab->andWhere('s.nbPMq>9');}
			elseif($crit=="ScMoyTv") {$tab->andWhere('s.nbPTv>9');}
			elseif($crit=="ScMoySx") {$tab->andWhere('s.nbPSx>9');}
			elseif($crit=="ScMoyMc") {$tab->andWhere('s.nbPMc>9');}
			elseif($crit=="ScMoyEy") {$tab->andWhere('s.nbPEy>9');}
		}
		
		$tab2=$tab->getQuery()->getResult();
		
		return count($tab2);
	}
	public function getBot($djajoue)
	{
		$tab=$this->_em->createQueryBuilder();
		$tab->select('s.id')
			->from('MDQUserBundle:ScUser', 's')
			->where('s.tabCoefBot!=:N')
			->setParameter('N','N;')
			->andWhere('s.tabCoefBot IS NOT NULL');
		if($djajoue==1){$tab->andWhere('s.scofDayMq IS NULL');}
		$results=$tab->getQuery()
			      ->getResult();
		$tab2=[];$i=0;
		foreach($results as $result)
		{
			$tab2[$i]=$result['id'];
			$i++;
		}// tout ca pour n'envoyer qu'un tableau d'id.
		return $tab2;
	}
			private function majStatGame(ScUser $scUser, $game, $br)
			{
				if($game=='MasterQuizz')
				{
				$NbQtot=$scUser->getNbQtotMq();			
				$NbBrTot=$scUser->getNbBrtotMq();
				$scUser->setNbQtotMq($NbQtot+1);
				$NbBrTot=$NbBrTot+$br;
				$scUser->setNbBrtotMq($NbBrTot);
				$scUser->setPrctBrtotMq($NbBrTot*100/($NbQtot+1));
				}
				return;
			}
			private function majNbQ(ScUser $scUser, $dom1)
			{
				if($dom1=='Histoire'){$nbQ=$scUser->getNbQhMq()+1;
										$scUser->setNbQhMq($nbQ);}
				elseif($dom1=='Géographie'){$nbQ=$scUser->getNbQgMq()+1;
										$scUser->setNbQgMq($nbQ);}
				elseif($dom1=='Divers'){$nbQ=$scUser->getNbQdMq()+1;
										$scUser->setNbQdMq($nbQ);}
				elseif($dom1=='Arts et Littérature'){$nbQ=$scUser->getNbQalMq()+1;
										$scUser->setNbQalMq($nbQ);}
				elseif($dom1=='Sports et loisirs'){$nbQ=$scUser->getNbQslMq()+1;
										$scUser->setNbQslMq($nbQ);}	
				elseif($dom1=='Sciences et nature'){$nbQ=$scUser->getNbQsnMq()+1;
										$scUser->setNbQsnMq($nbQ);}											
				elseif($dom1=='MuQuizz'){$nbQ=$scUser->getNbQMu()+1;
									$scUser->setNbQMu($nbQ);}				
				elseif($dom1=='ArQuizz'){$nbQ=$scUser->getNbQAr()+1;
										$scUser->setNbQAr($nbQ);}
				elseif($dom1=='FfQuizz'){$nbQ=$scUser->getNbQFf()+1;
										$scUser->setNbQFf($nbQ);}
				elseif($dom1=='LxQuizz'){$nbQ=$scUser->getNbQLx()+1;
										$scUser->setNbQLx($nbQ);}
				elseif($dom1=='TvQuizz'){$nbQ=$scUser->getNbQTv()+1;
										$scUser->setNbQTv($nbQ);}
				elseif($dom1=='SexyQuizz'){$nbQ=$scUser->getNbQSx()+1;
										$scUser->setNbQSx($nbQ);}								
				return $nbQ;
			}
			private function majNbBr(ScUser $scUser, $dom1, $br)
			{				
				if($br==1){$scUser->setNbBrtot($scUser->getNbBrtot()+1);}
				if($dom1=='Histoire'){$nbBr=$scUser->getNbBrhMq()+$br;
									$scUser->setNbBrhMq($nbBr);}
				elseif($dom1=='Géographie'){$nbBr=$scUser->getNbBrgMq()+$br;
									$scUser->setNbBrgMq($nbBr);}
				elseif($dom1=='Divers'){$nbBr=$scUser->getNbBrdMq()+$br;
									$scUser->setNbBrdMq($nbBr);}
				elseif($dom1=='Arts et Littérature'){$nbBr=$scUser->getNbBralMq()+$br;
									$scUser->setNbBralMq($nbBr);}
				elseif($dom1=='Sports et loisirs'){$nbBr=$scUser->getNbBrslMq()+$br;
									$scUser->setNbBrslMq($nbBr);}
				elseif($dom1=='Sciences et nature'){$nbBr=$scUser->getNbBrsnMq()+$br;
									$scUser->setNbBrsnMq($nbBr);}
				elseif($dom1=='MuQuizz'){$nbBr=$scUser->getNbBrMu()+$br;
									$scUser->setNbBrMu($nbBr);}
				elseif($dom1=='ArQuizz'){$nbBr=$scUser->getNbBrAr()+$br;
									$scUser->setNbBrAr($nbBr);}
				elseif($dom1=='FfQuizz'){$nbBr=$scUser->getNbBrFf()+$br;
									$scUser->setNbBrFf($nbBr);}
				elseif($dom1=='LxQuizz'){$nbBr=$scUser->getNbBrLx()+$br;
									$scUser->setNbBrLx($nbBr);}				
				elseif($dom1=='TvQuizz'){$nbBr=$scUser->getNbBrTv()+$br;
									$scUser->setNbBrTv($nbBr);}				
				elseif($dom1=='SexyQuizz'){$nbBr=$scUser->getNbBrSx()+$br;
									$scUser->setNbBrSx($nbBr);}
				return $nbBr;
			}
			private function majPrctBr(ScUser $scUser, $dom1, $nbQ, $nbBr)
			{
				if($dom1=='Histoire'){$scUser->setPrctBrhMq($nbBr*100/$nbQ);}
				elseif($dom1=='Géographie'){$scUser->setPrctBrgMq($nbBr*100/$nbQ);}
				elseif($dom1=='Divers'){$scUser->setPrctBrdMq($nbBr*100/$nbQ);}
				elseif($dom1=='Arts et Littérature'){$scUser->setPrctBralMq($nbBr*100/$nbQ);}
				elseif($dom1=='Sports et loisirs'){$scUser->setPrctBrslMq($nbBr*100/$nbQ);}
				elseif($dom1=='Sciences et nature'){$scUser->setPrctBrsnMq($nbBr*100/$nbQ);}
				elseif($dom1=='MuQuizz'){$scUser->setPrctBrMu($nbBr*100/$nbQ);}
				elseif($dom1=='ArQuizz'){$scUser->setPrctBrAr($nbBr*100/$nbQ);}
				elseif($dom1=='FfQuizz'){$scUser->setPrctBrFf($nbBr*100/$nbQ);}
				elseif($dom1=='LxQuizz'){$scUser->setPrctBrLx($nbBr*100/$nbQ);}				
				elseif($dom1=='TvQuizz'){$scUser->setPrctBrTv($nbBr*100/$nbQ);}				
				elseif($dom1=='SexyQuizz'){$scUser->setPrctBrSx($nbBr*100/$nbQ);}
				return;
			}
	public function majBddScQ($scUser, $game, $dom1, $br)
	{

		if($game=='MasterQuizz'){ScUserRepository::majStatGame($scUser, $game, $br);}
		$newnbQ=$this->majNbQ($scUser,$dom1);			
		$newnbBr=$this->majNbBr($scUser,$dom1,$br);
		$this->majPrctBr($scUser, $dom1, $newnbQ, $newnbBr);
		
		return 1;
	}
	public function majBddVerifRep($scUser, $game, $dom1, $rep, $bRep, $partie, $finP)
	{
	      if($rep==$bRep){$br=1;}
	      else{$br=0;}

		if($game=='MasterQuizz'){ScUserRepository::majStatGame($scUser, $game, $br);}
		$newnbQ=$this->majNbQ($scUser,$dom1);			
		$newnbBr=ScUserRepository::majNbBr($scUser,$dom1,$br);
		ScUserRepository::majPrctBr($scUser, $dom1, $newnbQ, $newnbBr);
		if($finP==1){$this->majBddScfinP($scUser, $dom1, $game, $partie);}
		
		return 1;
	}

	public function majBddScfinP($scUser, $dom1, $game, $partie)// sert aussi pour les bots.
	{		
		$scP=$partie->getScore();
		$partie->setValid(true);				
		$testDay=$scUser->testScDayAndWeek($dom1, $game, $scP);
		$scTot=$scUser->majScTot($dom1, $game, $scP);
		$scUser->majScMoy($dom1, $game, $scTot);
		if($testDay==1)// Si meilleur score du jour
		{
			$scUser->testScMax($dom1, $game, $scP, $partie->getDate());
			if($game=='MasterQuizz'){$scUser->majsumTop5($scP);}
			elseif($game=='MediaQuizz'){$scUser->majTM($dom1, $scP);}
			$scUser->majKingMaster();
		}
		return 1;
	}
	
		
	public function majClassement($tabUsers, $clsmt, $tabMaitres)
	{

		$i=0;$j=0;$sc=0;$tab1[0]=null;$nbExae=0;$m=0;$n=0;
			//$i : variable boucle, $j: variable rang =$i sauf si egalite.
			//$sc pour gerer les situations d'egalites de score
			//$nbExae : nb de joueur exaeco - pas indispensable.
			//$m devient positif des que un user peut s'incrire dans tab1.
			//$n devient positif qd tests d'aglites termines, pour ne pas tester pour tous les joueurs suivants.
			foreach($tabUsers as $scUser){
				$i++;
				$j=$scUser->testEqual($clsmt, $i, $j, $sc);
				$scUser->majHighScore($clsmt, $j);
				if($j<11){$scUser->majMedailles($clsmt, $j);}
				if($m==0 && in_array($scUser, $tabMaitres)!==true){$tab1[0]=$scUser;$m=1;}
				elseif($m==1 && $n==0 && $j!=$i && in_array($scUser, $tabMaitres)!==true){array_push($tab1,$scUser);$nbExae++;}
				elseif($m==1 && $n==0 && $j==$i){$n=1;}// Bien garder le $j==$i, comme ca si l'user est deja ans la tab maitre et que egalite de score, $n ne passe pas a 1.
				//pour les suivant, tester aussi que $scUser n'appartient pas a tabMaitres.		
		
				$scUser->calcOldScore($clsmt);
				$scUser->remiseAzero($clsmt);
			}
			if($nbExae>0){shuffle($tab1);}
			if($clsmt=='KingMaster'){$tabMaitres[0]=$tab1[0];}
			elseif($clsmt=='scofDayMq'){$tabMaitres[1]=$tab1[0];}
			elseif($clsmt=='TotalMedia'){$tabMaitres[2]=$tab1[0];}
			elseif($clsmt=='MuQuizz'){$tabMaitres[3]=$tab1[0];}
			elseif($clsmt=='ArQuizz'){$tabMaitres[4]=$tab1[0];}
			elseif($clsmt=='FfQuizz'){$tabMaitres[5]=$tab1[0];}
			elseif($clsmt=='LxQuizz'){$tabMaitres[6]=$tab1[0];}
			
			return $tabMaitres;
		
	}
}
