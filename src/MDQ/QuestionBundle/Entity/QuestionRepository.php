<?php

namespace MDQ\QuestionBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * QuestionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuestionRepository extends EntityRepository
{
	public function getQuestions($error, $valid, $diff, $game, $dom1, $theme, $crit, $sens, $nbdeQ, $nbmin, $page)
  {
 
		$qb = $this->createQueryBuilder('a');
		
	
					
		$qb->where('a.id>0'); //c'est bateau, mais après ça me permet de mettre uniquement des andWhere et d'éviter trop de conditions.
		if($dom1!="none"){
				$qb->andWhere('a.dom1 = :dom1')
				->setParameter('dom1', $dom1);
			}
			elseif($dom1=="none"){
				if($game!="none"){
					if($game=="MasterQuizz"){
					$qb->andWhere($qb->expr()->orX(// Indispensable pour que le || ne soit pas exclusif.
					$qb->expr()->eq('a.dom1', ':dom1a'),
					$qb->expr()->eq('a.dom1', ':dom1b'),
					$qb->expr()->eq('a.dom1', ':dom1c'),
					$qb->expr()->eq('a.dom1', ':dom1d'),
					$qb->expr()->eq('a.dom1', ':dom1e'),
					$qb->expr()->eq('a.dom1', ':dom1f')				
					));
					$qb->setParameter('dom1a', "Histoire")
					   ->setParameter('dom1b', "Divers")
					   ->setParameter('dom1d', "Sports et loisirs")
					   ->setParameter('dom1e', "Sciences et nature")
					   ->setParameter('dom1c', "Géographie")					   
					  ->setParameter('dom1f', "Arts et Littérature");
					}
					elseif($game=="Quizz Média"){
					$qb->andWhere($qb->expr()->orX(// Indispensable pour que le || ne soit pas exclusif.
					$qb->expr()->eq('a.dom1', ':dom1a'),
					$qb->expr()->eq('a.dom1', ':dom1b'),
					$qb->expr()->eq('a.dom1', ':dom1c'),
					$qb->expr()->eq('a.dom1', ':dom1d'),
					$qb->expr()->eq('a.dom1', ':dom1e')
					));
					$qb->setParameter('dom1a', "FfQuizz")
					->setParameter('dom1b', "LxQuizz")
					->setParameter('dom1c', "MuQuizz")
					->setParameter('dom1d', "ArQuizz")
					->setParameter('dom1e', "WzQuizz");
					}
					elseif($game=="Autre"){
					$qb->andWhere('a.dom1 != :dom1a')
					->setParameter('dom1a', "Histoire");
					$qb->andWhere('a.dom1 != :dom1b')
					->setParameter('dom1b', "Géographie");
					$qb->andWhere('a.dom1 != :dom1c')
					->setParameter('dom1c', "Divers");
					$qb->andWhere('a.dom1 != :dom1d')
					->setParameter('dom1d', "Sports et loisirs");
					$qb->andWhere('a.dom1 != :dom1e')
					->setParameter('dom1e', "Sciences et nature");
					$qb->andWhere('a.dom1 != :dom1f')
					->setParameter('dom1f', "Arts et Littérature");
					$qb->andWhere('a.dom1 != :dom1g')
					->setParameter('dom1g', "FfQuizz");
					$qb->andWhere('a.dom1 != :dom1h')
					->setParameter('dom1h', "LxQuizz");
					$qb->andWhere('a.dom1 != :dom1i')
					->setParameter('dom1i', "MuQuizz");
					$qb->andWhere('a.dom1 != :dom1j')
					->setParameter('dom1j', "ArQuizz");					
					}$qb->andWhere('a.dom1 != :dom1k')
					->setParameter('dom1k', "WzQuizz");
					
				}
			}		if($valid!=4){
			$qb->andWhere('a.valid = :valid')
			->setParameter('valid', $valid);	
		}
		if($error!=2) { 
				$qb->andWhere('a.error= :error')
				->setParameter('error', $error);	
			}
		if($diff!=0){
			$qb->andWhere('a.diff = :diff')
			->setParameter('diff', $diff);	
		}

		if($theme!="none"){
				$qb->andWhere('a.theme = :theme')
				->setParameter('theme', $theme);
		}
		$qb1=$qb;
		$nbTot=count($qb1->getQuery()->getResult());
		if($nbTot>$nbdeQ){$nbmin2=($nbmin+($page-1)*$nbdeQ);}
			else{$nbmin2=$nbmin;}
		$qb->orderBy('a.'.$crit, $sens)
			->setFirstResult($nbmin2-1);
			
		if($nbdeQ!=0) {
			$qb->setMaxResults($nbdeQ);
		}
		$questions=$qb->getQuery()->getResult();
		$data=[$nbTot, $questions];
	return $data;

	}

  public function getStatsQ()
    {
	// Stats génrales
	$nbQt=0; $nbQMq=0; $nbQQnF=0; $nbQQm=0;

	
	//Stats MasterQuizz
	$nbQh=0; $nbQd=0; $nbQg=0; $nbQal=0; $nbQsl=0; $nbQsn=0;
	$nbQMqd1=0; $nbQMqd2=0; $nbQMqd3=0; $nbQMqd4=0; $nbQMqd5=0;//diff
	$nbQMqv0=0; $nbQMqv1=0; $nbQMqv2=0; $nbQMqv3=0;//valide
	$nbQhd1=0; $nbQhd2=0; $nbQhd3=0; $nbQhd4=0; $nbQhd5=0;
	$nbQdd1=0; $nbQdd2=0; $nbQdd3=0; $nbQdd4=0; $nbQdd5=0;
	$nbQgd1=0; $nbQgd2=0; $nbQgd3=0; $nbQgd4=0; $nbQgd5=0;
	$nbQald1=0; $nbQald2=0; $nbQald3=0; $nbQald4=0; $nbQald5=0;
	$nbQsld1=0; $nbQsld2=0; $nbQsld3=0; $nbQsld4=0; $nbQsld5=0;
	$nbQsnd1=0; $nbQsnd2=0; $nbQsnd3=0; $nbQsnd4=0; $nbQsnd5=0;
	$nbQMqd1v1=0; $nbQMqd2v1=0; $nbQMqd3v1=0; $nbQMqd4v1=0; $nbQMqd5v1=0;//diff
	$nbQhv1=0; $nbQhd1v1=0; $nbQhd2v1=0; $nbQhd3v1=0; $nbQhd4v1=0; $nbQhd5v1=0;
	$nbQdv1=0; $nbQdd1v1=0; $nbQdd2v1=0; $nbQdd3v1=0; $nbQdd4v1=0; $nbQdd5v1=0;
	$nbQgv1=0; $nbQgd1v1=0; $nbQgd2v1=0; $nbQgd3v1=0; $nbQgd4v1=0; $nbQgd5v1=0;
	$nbQalv1=0; $nbQald1v1=0; $nbQald2v1=0; $nbQald3v1=0; $nbQald4v1=0; $nbQald5v1=0;
	$nbQslv1=0; $nbQsld1v1=0; $nbQsld2v1=0; $nbQsld3v1=0; $nbQsld4v1=0; $nbQsld5v1=0;
	$nbQsnv1=0; $nbQsnd1v1=0; $nbQsnd2v1=0; $nbQsnd3v1=0; $nbQsnd4v1=0; $nbQsnd5v1=0;
	//Stats MediaQuizz
	$nbQar=0;$nbQff=0; $nbQmu=0; $nbQlx=0; $nbQwz=0;
	$nbQQmd1=0; $nbQQmd2=0; $nbQQmd3=0; $nbQQmd4=0; $nbQQmd5=0;//diff
	$nbQQmv0=0; $nbQQmv1=0; $nbQQmv2=0; $nbQQmv3=0;//valide
	$nbQard1=0; $nbQard2=0; $nbQard3=0; $nbQard4=0; $nbQard5=0;
	$nbQffd1=0; $nbQffd2=0; $nbQffd3=0; $nbQffd4=0; $nbQffd5=0;
	$nbQmud1=0; $nbQmud2=0; $nbQmud3=0; $nbQmud4=0; $nbQmud5=0;
	$nbQlxd1=0; $nbQlxd2=0; $nbQlxd3=0; $nbQlxd4=0; $nbQlxd5=0;
	$nbQwzd1=0; $nbQwzd2=0; $nbQwzd3=0; $nbQwzd4=0; $nbQwzd5=0;
	//Stats QuizzenFolie
	$nbQsx=0; $nbQtv=0; 
	$nbQsxd1=0;$nbQsxd2=0;$nbQsxd3=0;$nbQsxd4=0;$nbQsxd5=0;
	$nbQtvd1=0;$nbQtvd2=0;$nbQtvd3=0;$nbQtvd4=0;$nbQtvd5=0;
	//Autre
	$nbQa=0;
	$nbQad1=0;$nbQad2=0;$nbQad3=0;$nbQad4=0;$nbQad5=0;
	
	$qb = $this->createQueryBuilder('a');
	$questions=$qb->getQuery()->getResult();
	foreach ($questions as $question){		
		$dom1=$question->getDom1();
		$diff=$question->getDiff();
		$valid=$question->getValid();
		if($dom1=='Histoire' || $dom1=='Géographie' || $dom1=='Divers' || $dom1=='Arts et Littérature' || $dom1=='Sports et loisirs' || $dom1=='Sciences et nature')
		{
			$game="MasterQuizz";
		}
		elseif($dom1=='SexyQuizz' || $dom1=='TvQuizz')
		{		
			$game="QuizzEnFolie";
		}
		elseif($dom1=='ArQuizz' || $dom1=='MuQuizz' || $dom1=='FfQuizz' || $dom1=='LxQuizz' || $dom1=='WzQuizz')
		{
			$game="MediaQuizz";
		}
		else{$game='Autre';}
		// idée d'un tri : game, dom1, diff, valid.
		$nbQt++;
		if($game=='MasterQuizz')
		{
			$nbQMq=$nbQMq+1;
			if($dom1=='Histoire')
			{
				$nbQh=$nbQh+1;
				if($diff==1)
				{
					$nbQMqd1++; $nbQhd1++;
					if($valid==1)
					{
						$nbQhv1++;
						$nbQMqd1v1++; $nbQhd1v1++;	
					}
				}
				elseif($diff==2)
				{
					$nbQMqd2++; $nbQhd2++;
					if($valid==1){$nbQhv1++;$nbQMqd2v1++; $nbQhd2v1++;}
				}
				elseif($diff==3)
				{
					$nbQMqd3++; $nbQhd3++;
					if($valid==1){$nbQhv1++;$nbQMqd3v1++; $nbQhd3v1++;}
				}
				elseif($diff==4)
				{
					$nbQMqd4++; $nbQhd4++;
					if($valid==1){$nbQhv1++;$nbQMqd4v1++; $nbQhd4v1++;}
				}
				elseif($diff==5)
				{
					$nbQMqd5++; $nbQhd5++;
					if($valid==1){$nbQhv1++;$nbQMqd5v1++; $nbQhd5v1++;}
				}
			}
			elseif($dom1=='Géographie')
			{
				$nbQg++;
				if($diff==1)
				{
					$nbQMqd1++; $nbQgd1++;
					if($valid==1){$nbQgv1++;$nbQMqd1v1++; $nbQgd1v1++;}
				}
				elseif($diff==2)
				{
					$nbQMqd2++; $nbQgd2++;
					if($valid==1){$nbQgv1++;$nbQMqd2v1++; $nbQgd2v1++;}
				}
				elseif($diff==3)
				{
					$nbQMqd3++; $nbQgd3++;
					if($valid==1){$nbQgv1++;$nbQMqd3v1++; $nbQgd3v1++;}
				}
				elseif($diff==4)
				{
					$nbQMqd4++; $nbQgd4++;
					if($valid==1){$nbQgv1++;$nbQMqd4v1++; $nbQgd4v1++;}
				}
				elseif($diff==5)
				{
					$nbQMqd5++; $nbQgd5++;
					if($valid==1){$nbQgv1++;$nbQMqd5v1++; $nbQgd5v1++;}
				}
			}
			elseif($dom1=='Divers')
			{
				$nbQd++;
				if($diff==1)
				{
					$nbQMqd1++; $nbQdd1++;
					if($valid==1){$nbQdv1++;$nbQMqd1v1++; $nbQdd1v1++;}
				}
				elseif($diff==2)
				{
					$nbQMqd2++; $nbQdd2++;
					if($valid==1){$nbQdv1++;$nbQMqd2v1++; $nbQdd2v1++;}
				}
				elseif($diff==3)
				{
					$nbQMqd3++; $nbQdd3++;
					if($valid==1){$nbQdv1++;$nbQMqd3v1++; $nbQdd3v1++;}
				}
				elseif($diff==4)
				{
					$nbQMqd4++; $nbQdd4++;
					if($valid==1){$nbQdv1++;$nbQMqd4v1++; $nbQdd4v1++;}
				}
				elseif($diff==5)
				{
					$nbQMqd5++; $nbQdd5++;
					if($valid==1){$nbQdv1++;$nbQMqd5v1++; $nbQdd5v1++;}
				}
			}
			elseif($dom1=='Arts et Littérature')
			{
				$nbQal++;
				if($diff==1)
				{
					$nbQMqd1++; $nbQald1++;
					if($valid==1){$nbQalv1++;$nbQMqd1v1++; $nbQald1v1++;}
				}
				elseif($diff==2)
				{
					$nbQMqd2++; $nbQald2++;
					if($valid==1){$nbQalv1++;$nbQMqd2v1++; $nbQald2v1++;}
				}
				elseif($diff==3)
				{
					$nbQMqd3++; $nbQald3++;
					if($valid==1){$nbQalv1++;$nbQMqd3v1++; $nbQald3v1++;}
				}
				elseif($diff==4)
				{
					$nbQMqd4++; $nbQald4++;
					if($valid==1){$nbQalv1++;$nbQMqd4v1++; $nbQald4v1++;}
				}
				elseif($diff==5)
				{
					$nbQMqd5++; $nbQald5++;
					if($valid==1){$nbQalv1++;$nbQMqd5v1++; $nbQald5v1++;}
				}
			}
			elseif($dom1=='Sports et loisirs')
			{
				$nbQsl++;
				if($diff==1)
				{
					$nbQMqd1++; $nbQsld1++;
					if($valid==1){$nbQslv1++;$nbQMqd1v1++; $nbQsld1v1++;}
				}
				elseif($diff==2)
				{
					$nbQMqd2++; $nbQsld2++;
					if($valid==1){$nbQslv1++;$nbQMqd2v1++; $nbQsld2v1++;}
				}
				elseif($diff==3)
				{
					$nbQMqd3++; $nbQsld3++;
					if($valid==1){$nbQslv1++;$nbQMqd3v1++; $nbQsld3v1++;}
				}
				elseif($diff==4)
				{
					$nbQMqd4++; $nbQsld4++;
					if($valid==1){$nbQslv1++;$nbQMqd4v1++; $nbQsld4v1++;}
				}
				elseif($diff==5)
				{
					$nbQMqd5++; $nbQsld5++;
					if($valid==1){$nbQslv1++;$nbQMqd5v1++; $nbQsld5v1++;}
				}
			}
			elseif($dom1=='Sciences et nature')
			{
				$nbQsn++;
				if($diff==1)
				{
					$nbQMqd1++; $nbQsnd1++;
					if($valid==1){$nbQsnv1++;$nbQMqd1v1++; $nbQsnd1v1++;}
				}
				elseif($diff==2)
				{
					$nbQMqd2++; $nbQsnd2++;
					if($valid==1){$nbQsnv1++;$nbQMqd2v1++; $nbQsnd2v1++;}
				}
				elseif($diff==3)
				{
					$nbQMqd3++; $nbQsnd3++;
					if($valid==1){$nbQsnv1++;$nbQMqd3v1++; $nbQsnd3v1++;}
				}
				elseif($diff==4)
				{
					$nbQMqd4++; $nbQsnd4++;
					if($valid==1){$nbQsnv1++;$nbQMqd4v1++; $nbQsnd4v1++;}
				}
				elseif($diff==5)
				{
					$nbQMqd5++; $nbQsnd5++;
					if($valid==1){$nbQsnv1++;$nbQMqd5v1++; $nbQsnd5v1++;}
				}
			}		
			if($valid==2){$nbQMqv2=$nbQMqv2+1;}
			elseif($valid==1){$nbQMqv1=$nbQMqv1+1;}
			elseif($valid==3){$nbQMqv3=$nbQMqv3+1;}
			elseif($valid==0){$nbQMqv0=$nbQMqv0+1;}			
		}
		elseif($game=="MediaQuizz")
		{
			$nbQQm++;
			if($dom1=='ArQuizz')
			{
				$nbQar++;
				if($diff==1){$nbQQmd1++; $nbQard1++;}
				elseif($diff==2){$nbQQmd2++; $nbQard2++;}
				elseif($diff==3){$nbQQmd3++; $nbQard3++;}
				elseif($diff==4){$nbQQmd4++; $nbQard4++;}				
				elseif($diff==5){$nbQQmd5++; $nbQard5++;}
			}
			elseif($dom1=='FfQuizz')
			{
				$nbQff++;
				if($diff==1){$nbQQmd1++; $nbQffd1++;}
				elseif($diff==2){$nbQQmd2++; $nbQffd2++;}
				elseif($diff==3){$nbQQmd3++; $nbQffd3++;}
				elseif($diff==4){$nbQQmd4++; $nbQffd4++;}				
				elseif($diff==5){$nbQQmd5++; $nbQffd5++;}
			}
			elseif($dom1=='LxQuizz')
			{
				$nbQlx++;
				if($diff==1){$nbQQmd1++; $nbQlxd1++;}
				elseif($diff==2){$nbQQmd2++; $nbQlxd2++;}
				elseif($diff==3){$nbQQmd3++; $nbQlxd3++;}
				elseif($diff==4){$nbQQmd4++; $nbQlxd4++;}				
				elseif($diff==5){$nbQQmd5++; $nbQlxd5++;}
			}
			elseif($dom1=='WzQuizz')
			{
				$nbQwz++;
				if($diff==1){$nbQQmd1++; $nbQwzd1++;}
				elseif($diff==2){$nbQQmd2++; $nbQwzd2++;}
				elseif($diff==3){$nbQQmd3++; $nbQwzd3++;}
				elseif($diff==4){$nbQQmd4++; $nbQwzd4++;}				
				elseif($diff==5){$nbQQmd5++; $nbQwzd5++;}
			}
			elseif($dom1=='MuQuizz')
			{
				$nbQmu++;
				if($diff==1){$nbQQmd1++; $nbQmud1++;}
				elseif($diff==2){$nbQQmd2++; $nbQmud2++;}
				elseif($diff==3){$nbQQmd3++; $nbQmud3++;}
				elseif($diff==4){$nbQQmd4++; $nbQmud4++;}				
				elseif($diff==5){$nbQQmd5++; $nbQmud5++;}
			}			
			if($valid==2){$nbQQmv2++;}
			elseif($valid==1){$nbQQmv1++;}
			elseif($valid==3){$nbQQmv3++;}
			elseif($valid==0){$nbQQmv0++;}			
		}
		elseif($game=="QuizzEnFolie")
		{
			$nbQQnF++;
			if($dom1=="TvQuizz")
			{
				$nbQtv=$nbQtv+1;
				if($diff==1){$nbQtvd1++;}
				if($diff==2){$nbQtvd2++;}
				if($diff==3){$nbQtvd3++;}
				if($diff==4){$nbQtvd4++;}
				if($diff==5){$nbQtvd5++;}
			}
			elseif($dom1=="SexyQuizz")
			{
				$nbQsx=$nbQsx+1;
				if($diff==1){$nbQsxd1++;}
				if($diff==2){$nbQsxd2++;}
				if($diff==3){$nbQsxd3++;}
				if($diff==4){$nbQsxd4++;}
				if($diff==5){$nbQsxd5++;}
			}			
		}
		else// Autre		
		{
				$nbQa=$nbQa+1;
				if($diff==1){$nbQad1++;}
				if($diff==2){$nbQad2++;}
				if($diff==3){$nbQad3++;}
				if($diff==4){$nbQad4++;}
				if($diff==5){$nbQad5++;}
		}
		
	}
	$pctQh=round((100*$nbQh/$nbQMq),2); $pctQg=round((100*$nbQg/$nbQMq),2); $pctQd=round((100*$nbQd/$nbQMq),2);	$pctQal=round((100*$nbQal/$nbQMq),2);$pctQsl=round((100*$nbQsl/$nbQMq),2);
	$pctQsn=round((100*$nbQsn/$nbQMq),2); 
	$pctQMqd1=round((100*$nbQMqd1/$nbQMq),2); $pctQMqd2=round((100*$nbQMqd2/$nbQMq),2); $pctQMqd3=round((100*$nbQMqd3/$nbQMq),2); $pctQMqd4=round((100*$nbQMqd4/$nbQMq),2);
	$pctQMqd5=round((100*$nbQMqd5/$nbQMq),2);
	$pctQhd1=round((100*$nbQhd1/$nbQh),2);$pctQhd2=round((100*$nbQhd2/$nbQh),2);$pctQhd3=round((100*$nbQhd3/$nbQh),2);$pctQhd4=round((100*$nbQhd4/$nbQh),2);$pctQhd5=round((100*$nbQhd5/$nbQh),2);
    $pctQgd1=round((100*$nbQgd1/$nbQg),2);$pctQgd2=round((100*$nbQgd2/$nbQg),2);$pctQgd3=round((100*$nbQgd3/$nbQg),2);$pctQgd4=round((100*$nbQgd4/$nbQg),2);$pctQgd5=round((100*$nbQgd5/$nbQg),2);
	$pctQdd1=round((100*$nbQdd1/$nbQd),2);$pctQdd2=round((100*$nbQdd2/$nbQd),2);$pctQdd3=round((100*$nbQdd3/$nbQd),2);$pctQdd4=round((100*$nbQdd4/$nbQd),2);$pctQdd5=round((100*$nbQdd5/$nbQd),2);
	$pctQald1=round((100*$nbQald1/$nbQal),2);$pctQald2=round((100*$nbQald2/$nbQal),2);$pctQald3=round((100*$nbQald3/$nbQal),2);$pctQald4=round((100*$nbQald4/$nbQal),2);$pctQald5=round((100*$nbQald5/$nbQal),2);
	$pctQsld1=round((100*$nbQsld1/$nbQsl),2);$pctQsld2=round((100*$nbQsld2/$nbQsl),2);$pctQsld3=round((100*$nbQsld3/$nbQsl),2);$pctQsld4=round((100*$nbQsld4/$nbQsl),2);$pctQsld5=round((100*$nbQsld5/$nbQsl),2);
	$pctQsnd1=round((100*$nbQsnd1/$nbQsn),2);$pctQsnd2=round((100*$nbQsnd2/$nbQsn),2);$pctQsnd3=round((100*$nbQsnd3/$nbQsn),2);$pctQsnd4=round((100*$nbQsnd4/$nbQsn),2);$pctQsnd5=round((100*$nbQsnd5/$nbQsn),2);

	$pctQhv1=round((100*$nbQhv1/$nbQMqv1),2); $pctQgv1=round((100*$nbQgv1/$nbQMqv1),2); $pctQdv1=round((100*$nbQdv1/$nbQMqv1),2);	$pctQalv1=round((100*$nbQalv1/$nbQMqv1),2);$pctQslv1=round((100*$nbQslv1/$nbQMqv1),2);$pctQsnv1=round((100*$nbQsnv1/$nbQMqv1),2); 
	$pctQMqd1v1=round((100*$nbQMqd1v1/$nbQMqv1),2);$pctQMqd2v1=round((100*$nbQMqd2v1/$nbQMqv1),2);$pctQMqd3v1=round((100*$nbQMqd3v1/$nbQMqv1),2);$pctQMqd4v1=round((100*$nbQMqd4v1/$nbQMqv1),2);$pctQMqd5v1=round((100*$nbQMqd5v1/$nbQMqv1),2);

	$pctQhd1v1=round((100*$nbQhd1v1/$nbQhv1),2);$pctQhd2v1=round((100*$nbQhd2v1/$nbQhv1),2);$pctQhd3v1=round((100*$nbQhd3v1/$nbQhv1),2);$pctQhd4v1=round((100*$nbQhd4v1/$nbQhv1),2);$pctQhd5v1=round((100*$nbQhd5v1/$nbQhv1),2);
	$pctQgd1v1=round((100*$nbQgd1v1/$nbQgv1),2);$pctQgd2v1=round((100*$nbQgd2v1/$nbQgv1),2);$pctQgd3v1=round((100*$nbQgd3v1/$nbQgv1),2);$pctQgd4v1=round((100*$nbQgd4v1/$nbQgv1),2);$pctQgd5v1=round((100*$nbQgd5v1/$nbQgv1),2);
	$pctQdd1v1=round((100*$nbQdd1v1/$nbQdv1),2);$pctQdd2v1=round((100*$nbQdd2v1/$nbQdv1),2);$pctQdd3v1=round((100*$nbQdd3v1/$nbQdv1),2);$pctQdd4v1=round((100*$nbQdd4v1/$nbQdv1),2);$pctQdd5v1=round((100*$nbQdd5v1/$nbQdv1),2);
	$pctQald1v1=round((100*$nbQald1v1/$nbQalv1),2);$pctQald2v1=round((100*$nbQald2v1/$nbQalv1),2);$pctQald3v1=round((100*$nbQald3v1/$nbQalv1),2);$pctQald4v1=round((100*$nbQald4v1/$nbQalv1),2);$pctQald5v1=round((100*$nbQald5v1/$nbQalv1),2);
	$pctQsld1v1=round((100*$nbQsld1v1/$nbQslv1),2);$pctQsld2v1=round((100*$nbQsld2v1/$nbQslv1),2);$pctQsld3v1=round((100*$nbQsld3v1/$nbQslv1),2);$pctQsld4v1=round((100*$nbQsld4v1/$nbQslv1),2);$pctQsld5v1=round((100*$nbQsld5v1/$nbQslv1),2);

	$pctQsnd1v1=round((100*$nbQsnd1v1/$nbQsnv1),2);$pctQsnd2v1=round((100*$nbQsnd2v1/$nbQsnv1),2);$pctQsnd3v1=round((100*$nbQsnd3v1/$nbQsnv1),2);$pctQsnd4v1=round((100*$nbQsnd4v1/$nbQsnv1),2);$pctQsnd5v1=round((100*$nbQsnd5v1/$nbQsnv1),2);

	$pctQtvd1=round((100*$nbQtvd1/$nbQtv),2);$pctQtvd2=round((100*$nbQtvd2/$nbQtv),2);$pctQtvd3=round((100*$nbQtvd3/$nbQtv),2);$pctQtvd4=round((100*$nbQtvd4/$nbQtv),2);$pctQtvd5=round((100*$nbQtvd5/$nbQtv),2);
	$pctQsxd1=round((100*$nbQsxd1/$nbQsx),2);$pctQsxd2=round((100*$nbQsxd2/$nbQsx),2);$pctQsxd3=round((100*$nbQsxd3/$nbQsx),2);$pctQsxd4=round((100*$nbQsxd4/$nbQsx),2);$pctQsxd5=round((100*$nbQsxd5/$nbQsx),2);
	$pctQad1=round((100*$nbQad1/$nbQa),2);$pctQad2=round((100*$nbQad2/$nbQa),2);$pctQad3=round((100*$nbQad3/$nbQa),2);$pctQad4=round((100*$nbQad4/$nbQa),2);$pctQad5=round((100*$nbQad5/$nbQa),2);
	$pctQMqv0=round((100*$nbQMqv0/$nbQMq),2);$pctQMqv1=round((100*$nbQMqv1/$nbQMq),2);$pctQMqv2=round((100*$nbQMqv2/$nbQMq),2); $pctQMqv3=round((100*$nbQMqv3/$nbQMq),2);
	$pctQQmd1=round((100*$nbQQmd1/$nbQQm),2); $pctQQmd2=round((100*$nbQQmd2/$nbQQm),2); $pctQQmd3=round((100*$nbQQmd3/$nbQQm),2); $pctQQmd4=round((100*$nbQQmd4/$nbQQm),2);$pctQQmd5=round((100*$nbQQmd5/$nbQQm),2);
	$pctQard1=round((100*$nbQard1/$nbQar),2);$pctQard2=round((100*$nbQard2/$nbQar),2);$pctQard3=round((100*$nbQard3/$nbQar),2);$pctQard4=round((100*$nbQard4/$nbQar),2);$pctQard5=round((100*$nbQard5/$nbQar),2);
	$pctQffd1=round((100*$nbQffd1/$nbQff),2);$pctQffd2=round((100*$nbQffd2/$nbQff),2);$pctQffd3=round((100*$nbQffd3/$nbQff),2);$pctQffd4=round((100*$nbQffd4/$nbQff),2);$pctQffd5=round((100*$nbQffd5/$nbQff),2);
	$pctQlxd1=round((100*$nbQlxd1/$nbQlx),2);$pctQlxd2=round((100*$nbQlxd2/$nbQlx),2);$pctQlxd3=round((100*$nbQlxd3/$nbQlx),2);$pctQlxd4=round((100*$nbQlxd4/$nbQlx),2);$pctQlxd5=round((100*$nbQlxd5/$nbQlx),2);
	$pctQwzd1=round((100*$nbQwzd1/$nbQwz),2);$pctQwzd2=round((100*$nbQwzd2/$nbQwz),2);$pctQwzd3=round((100*$nbQwzd3/$nbQwz),2);$pctQwzd4=round((100*$nbQwzd4/$nbQwz),2);$pctQwzd5=round((100*$nbQwzd5/$nbQwz),2);
	$pctQmud1=round((100*$nbQmud1/$nbQmu),2);$pctQmud2=round((100*$nbQmud2/$nbQmu),2);$pctQmud3=round((100*$nbQmud3/$nbQmu),2);$pctQmud4=round((100*$nbQmud4/$nbQmu),2);$pctQmud5=round((100*$nbQmud5/$nbQmu),2);
		
	return array(	
      'nbQMq' => $nbQMq, 'nbQt'=>$nbQt,'nbQQm' => $nbQQm, 
      'nbQh' => $nbQh, 'nbQg' => $nbQg, 'nbQal' => $nbQal,'nbQsl' => $nbQsl, 'nbQsn' => $nbQsn,'nbQd' => $nbQd,
	  'nbQMqd1' => $nbQMqd1,'nbQMqd2' => $nbQMqd2,'nbQMqd3' => $nbQMqd3,'nbQMqd4' => $nbQMqd4,'nbQMqd5' => $nbQMqd5,
	  'pctQh' => $pctQh, 'pctQg' => $pctQg, 'pctQal' => $pctQal,'pctQsl' => $pctQsl, 'pctQsn' => $pctQsn,'pctQd' => $pctQd,
	  'pctQMqd1' => $pctQMqd1,'pctQMqd2' => $pctQMqd2,'pctQMqd3' => $pctQMqd3,'pctQMqd4' => $pctQMqd4,'pctQMqd5' => $pctQMqd5,
		'nbQQnF'=>$nbQQnF,'nbQsx'=>$nbQsx, 'nbQtv'=>$nbQtv, 
		'nbQhd1' => $nbQhd1, 'nbQhd2' => $nbQhd2, 'nbQhd3' => $nbQhd3, 'nbQhd4' => $nbQhd4, 'nbQhd5' => $nbQhd5,
		'nbQdd1' => $nbQdd1, 'nbQdd2' => $nbQdd2, 'nbQdd3' => $nbQdd3, 'nbQdd4' => $nbQdd4, 'nbQdd5' => $nbQdd5,
		'nbQgd1' => $nbQgd1, 'nbQgd2' => $nbQgd2, 'nbQgd3' => $nbQgd3, 'nbQgd4' => $nbQgd4, 'nbQgd5' => $nbQgd5,
		'nbQald1' => $nbQald1, 'nbQald2' => $nbQald2, 'nbQald3' => $nbQald3, 'nbQald4' => $nbQald4, 'nbQald5' => $nbQald5,
		'nbQsld1' => $nbQsld1, 'nbQsld2' => $nbQsld2, 'nbQsld3' => $nbQsld3, 'nbQsld4' => $nbQsld4, 'nbQsld5' => $nbQsld5,
		'nbQsnd1' => $nbQsnd1, 'nbQsnd2' => $nbQsnd2, 'nbQsnd3' => $nbQsnd3, 'nbQsnd4' => $nbQsnd4, 'nbQsnd5' => $nbQsnd5,
		'pctQhd1' => $pctQhd1, 'pctQhd2' => $pctQhd2, 'pctQhd3' => $pctQhd3, 'pctQhd4' => $pctQhd4, 'pctQhd5' => $pctQhd5,
		'pctQdd1' => $pctQdd1, 'pctQdd2' => $pctQdd2, 'pctQdd3' => $pctQdd3, 'pctQdd4' => $pctQdd4, 'pctQdd5' => $pctQdd5,
		'pctQgd1' => $pctQgd1, 'pctQgd2' => $pctQgd2, 'pctQgd3' => $pctQgd3, 'pctQgd4' => $pctQgd4, 'pctQgd5' => $pctQgd5,
		'pctQald1' => $pctQald1, 'pctQald2' => $pctQald2, 'pctQald3' => $pctQald3, 'pctQald4' => $pctQald4, 'pctQald5' => $pctQald5,
		'pctQsld1' => $pctQsld1, 'pctQsld2' => $pctQsld2, 'pctQsld3' => $pctQsld3, 'pctQsld4' => $pctQsld4, 'pctQsld5' => $pctQsld5,
		'pctQsnd1' => $pctQsnd1, 'pctQsnd2' => $pctQsnd2, 'pctQsnd3' => $pctQsnd3, 'pctQsnd4' => $pctQsnd4, 'pctQsnd5' => $pctQsnd5,
		'nbQMqv0' => $nbQMqv0, 'nbQMqv1' => $nbQMqv1, 'nbQMqv2' => $nbQMqv2, 'nbQMqv3' => $nbQMqv3,
		'pctQMqv0' => $pctQMqv0, 'pctQMqv1' => $pctQMqv1, 'pctQMqv2' => $pctQMqv2, 'pctQMqv3' => $pctQMqv3,
		'nbQtvd1' => $nbQtvd1, 'nbQtvd2' => $nbQtvd2, 'nbQtvd3' => $nbQtvd3, 'nbQtvd4' => $nbQtvd4, 'nbQtvd5' => $nbQtvd5,
		'nbQsxd1' => $nbQsxd1, 'nbQsxd2' => $nbQsxd2, 'nbQsxd3' => $nbQsxd3, 'nbQsxd4' => $nbQsxd4, 'nbQsxd5' => $nbQsxd5,
		'nbQa'=>$nbQa, 'nbQad1' => $nbQad1, 'nbQad2' => $nbQad2, 'nbQad3' => $nbQad3, 'nbQad4' => $nbQad4, 'nbQad5' => $nbQad5,
		'pctQtvd1' => $pctQtvd1, 'pctQtvd2' => $pctQtvd2, 'pctQtvd3' => $pctQtvd3, 'pctQtvd4' => $pctQtvd4, 'pctQtvd5' => $pctQtvd5,
		'pctQsxd1' => $pctQsxd1, 'pctQsxd2' => $pctQsxd2, 'pctQsxd3' => $pctQsxd3, 'pctQsxd4' => $pctQsxd4, 'pctQsxd5' => $pctQsxd5,
		'pctQad1' => $pctQad1, 'pctQad2' => $pctQad2, 'pctQad3' => $pctQad3, 'pctQad4' => $pctQad4, 'pctQad5' => $pctQad5,
		'nbQQmv0' => $nbQQmv0, 'nbQQmv1' => $nbQQmv1, 'nbQQmv2' => $nbQQmv2, 'nbQQmv3' => $nbQQmv3,
		'nbQar' => $nbQar,'nbQard1' => $nbQard1, 'nbQard2' => $nbQard2, 'nbQard3' => $nbQard3, 'nbQard4' => $nbQard4, 'nbQard5' => $nbQard5,
		'pctQard1' => $pctQard1, 'pctQard2' => $pctQard2, 'pctQard3' => $pctQard3, 'pctQard4' => $pctQard4, 'pctQard5' => $pctQard5,
		'nbQff' => $nbQff,'nbQffd1' => $nbQffd1, 'nbQffd2' => $nbQffd2, 'nbQffd3' => $nbQffd3, 'nbQffd4' => $nbQffd4, 'nbQffd5' => $nbQffd5,
		'pctQffd1' => $pctQffd1, 'pctQffd2' => $pctQffd2, 'pctQffd3' => $pctQffd3, 'pctQffd4' => $pctQffd4, 'pctQffd5' => $pctQffd5,
		'nbQlx' => $nbQlx,'nbQlxd1' => $nbQlxd1, 'nbQlxd2' => $nbQlxd2, 'nbQlxd3' => $nbQlxd3, 'nbQlxd4' => $nbQlxd4, 'nbQlxd5' => $nbQlxd5,
		'pctQlxd1' => $pctQlxd1, 'pctQlxd2' => $pctQlxd2, 'pctQlxd3' => $pctQlxd3, 'pctQlxd4' => $pctQlxd4, 'pctQlxd5' => $pctQlxd5,
		'nbQwz' => $nbQwz,'nbQwzd1' => $nbQwzd1, 'nbQwzd2' => $nbQwzd2, 'nbQwzd3' => $nbQwzd3, 'nbQwzd4' => $nbQwzd4, 'nbQwzd5' => $nbQwzd5,
		'pctQwzd1' => $pctQwzd1, 'pctQwzd2' => $pctQwzd2, 'pctQwzd3' => $pctQwzd3, 'pctQwzd4' => $pctQwzd4, 'pctQwzd5' => $pctQwzd5,
		'nbQmu' => $nbQmu,'nbQmud1' => $nbQmud1, 'nbQmud2' => $nbQmud2, 'nbQmud3' => $nbQmud3, 'nbQmud4' => $nbQmud4, 'nbQmud5' => $nbQmud5,
		'pctQmud1' => $pctQmud1, 'pctQmud2' => $pctQmud2, 'pctQmud3' => $pctQmud3, 'pctQmud4' => $pctQmud4, 'pctQmud5' => $pctQmud5,
		'nbQMqd1v1'=> $nbQMqd1v1,'nbQMqd2v1'=> $nbQMqd2v1,'nbQMqd3v1'=> $nbQMqd3v1,'nbQMqd4v1'=> $nbQMqd4v1,'nbQMqd5v1'=> $nbQMqd5v1,
		'pctQMqd1v1'=> $pctQMqd1v1,'pctQMqd2v1'=> $pctQMqd2v1,'pctQMqd3v1'=> $pctQMqd3v1,'pctQMqd4v1'=> $pctQMqd4v1,'pctQMqd5v1'=> $pctQMqd5v1,
		'nbQhv1' => $nbQhv1, 'nbQhd1v1' => $nbQhd1v1, 'nbQhd2v1' => $nbQhd2v1, 'nbQhd3v1' => $nbQhd3v1, 'nbQhd4v1' => $nbQhd4v1, 'nbQhd5v1' => $nbQhd5v1,
		'pctQhv1' => $pctQhv1, 'pctQhd1v1' => $pctQhd1v1, 'pctQhd2v1' => $pctQhd2v1, 'pctQhd3v1' => $pctQhd3v1, 'pctQhd4v1' => $pctQhd4v1, 'pctQhd5v1' => $pctQhd5v1,
		'nbQgv1' => $nbQgv1, 'nbQgd1v1' => $nbQgd1v1, 'nbQgd2v1' => $nbQgd2v1, 'nbQgd3v1' => $nbQgd3v1, 'nbQgd4v1' => $nbQgd4v1, 'nbQgd5v1' => $nbQgd5v1,
		'pctQgv1' => $pctQgv1,'pctQgd1v1' => $pctQgd1v1, 'pctQgd2v1' => $pctQgd2v1, 'pctQgd3v1' => $pctQgd3v1, 'pctQgd4v1' => $pctQgd4v1, 'pctQgd5v1' => $pctQgd5v1,
		'nbQdv1' => $nbQdv1, 'nbQdd1v1' => $nbQdd1v1, 'nbQdd2v1' => $nbQdd2v1, 'nbQdd3v1' => $nbQdd3v1, 'nbQdd4v1' => $nbQdd4v1, 'nbQdd5v1' => $nbQdd5v1,
		'pctQdv1' => $pctQdv1,'pctQdd1v1' => $pctQdd1v1, 'pctQdd2v1' => $pctQdd2v1, 'pctQdd3v1' => $pctQdd3v1, 'pctQdd4v1' => $pctQdd4v1, 'pctQdd5v1' => $pctQdd5v1,
		'nbQalv1' => $nbQalv1, 'nbQald1v1' => $nbQald1v1, 'nbQald2v1' => $nbQald2v1, 'nbQald3v1' => $nbQald3v1, 'nbQald4v1' => $nbQald4v1, 'nbQald5v1' => $nbQald5v1,
		'pctQalv1' => $pctQalv1,'pctQald1v1' => $pctQald1v1, 'pctQald2v1' => $pctQald2v1, 'pctQald3v1' => $pctQald3v1, 'pctQald4v1' => $pctQald4v1, 'pctQald5v1' => $pctQald5v1,
		'nbQslv1' => $nbQslv1, 'nbQsld1v1' => $nbQsld1v1, 'nbQsld2v1' => $nbQsld2v1, 'nbQsld3v1' => $nbQsld3v1, 'nbQsld4v1' => $nbQsld4v1, 'nbQsld5v1' => $nbQsld5v1,
		'pctQslv1' => $pctQslv1,'pctQsld1v1' => $pctQsld1v1, 'pctQsld2v1' => $pctQsld2v1, 'pctQsld3v1' => $pctQsld3v1, 'pctQsld4v1' => $pctQsld4v1, 'pctQsld5v1' => $pctQsld5v1,
		'nbQsnv1' => $nbQsnv1, 'nbQsnd1v1' => $nbQsnd1v1, 'nbQsnd2v1' => $nbQsnd2v1, 'nbQsnd3v1' => $nbQsnd3v1, 'nbQsnd4v1' => $nbQsnd4v1, 'nbQsnd5v1' => $nbQsnd5v1,
		'pctQsnv1' => $pctQsnv1,'pctQsnd1v1' => $pctQsnd1v1, 'pctQsnd2v1' => $pctQsnd2v1, 'pctQsnd3v1' => $pctQsnd3v1, 'pctQsnd4v1' => $pctQsnd4v1, 'pctQsnd5v1' => $pctQsnd5v1,
		'nbQQmd1' => $nbQQmd1,'nbQQmd2' => $nbQQmd2,'nbQQmd3' => $nbQQmd3,'nbQQmd4' => $nbQQmd4,'nbQQmd5' => $nbQQmd5,
		'pctQQmd1' => $pctQQmd1,'pctQQmd2' => $pctQQmd2,'pctQQmd3' => $pctQQmd3,'pctQQmd4' => $pctQQmd4,'pctQQmd5' => $pctQQmd5,

		);
  }


	public function tiragePartieMq($tabDerP)
	{
		$tabdom3=[]; $tabtheme=[]; $tabidQ=[];$tabdom=['x','x','x']; $tabId=[];
		$tabdiff=[1,2,2,3,3,3,4,4,5,5];	
			$questions=$this->_em->createQueryBuilder();
			$questions->select('q.id, q.dom3, q.theme, q.diff, q.dom1')
				->from('MDQQuestionBundle:Question', 'q')
				->where('q.valid = :valid')
				->setParameter('valid', 1)
				->andWhere('q.dom1=:dom1a OR q.dom1=:dom1b OR q.dom1=:dom1c OR q.dom1=:dom1d OR q.dom1=:dom1e OR q.dom1=:dom1f')
				->setParameter('dom1a', "Histoire")
				->setParameter('dom1b', "Geographie")
				->setParameter('dom1c', "Divers")
				->setParameter('dom1d', "Sports et loisirs")
				->setParameter('dom1e', "Sciences et nature")
				->setParameter('dom1f', "Arts et Littérature");		
			$result=$questions->getQuery()->getResult();
			$nbResult=count($result);
			for($numQ=1; $numQ<11; $numQ++) {
				$test=false;
				while($test===false){				
				$test=true;
				$numR=mt_rand(0, ($nbResult-1));
				if(in_array($result[$numR]['id'],$tabDerP)){$test=false;}
				if($result[$numR]['diff']!=$tabdiff[$numQ-1]){$test=false;}
				if(in_array($result[$numR]['id'],$tabidQ)){$test=false;}
				if(in_array($result[$numR]['dom1'],$tabdom)){$test=false;}
				if(in_array($result[$numR]['theme'],$tabtheme)){$test=false;}				
				if(in_array($result[$numR]['dom3'],$tabdom3)){$test=false;}				
				}

				$tabdom[0]=$tabdom[1];
				$tabdom[1]=$tabdom[2];
				$tabdom[2]=$result[$numR]['dom1'];
				$tabidQ[$numQ-1]=$result[$numR]['id'];			
				$tabdom3[$numQ-1]=$result[$numR]['dom3'];
				//$tabtheme[$numQ-1]=$result[$numR]['theme']; //Pas sur que très utile
			}
		return $tabidQ;
			
	}
	public function tiragePartieQM($tabDerP, $game)
	{
		$tabdom3=[]; $tabtheme=['x','x']; $tabidQ=[];$tabId=[];$tabMedia=[]; $falseGame=false;
		$tabdiffTv=[1,1,3,3,3,3,5,5];
		$tabdiffFf=[1,3,3,3,4,4,5,5];
		$tabdiffLx=[3,3,3,4,4,4,5,5];
		if($game=="ArQuizz" || $game=="MuQuizz" || $game=="TvQuizz" || $game=="SexyQuizz" || $game=="WzQuizz"){$falseGame=true;}
			$questions=$this->_em->createQueryBuilder();
			$questions->select('q.id, q.dom3, q.theme, q.diff, q.dom1, q.media')
				->from('MDQQuestionBundle:Question', 'q')
				->where('q.dom1=:dom1')
				->setParameter('dom1', $game);
			if(!$falseGame){
			$questions->andWhere('q.valid = :valid')
				->setParameter('valid', 1);
			}
			$result=$questions->getQuery()->getResult();
			$nbResult=count($result);
			for($numQ=1; $numQ<9; $numQ++) {
				$test=false;
				while($test===false){				
				$test=true;
				$numR=mt_rand(0, ($nbResult-1));
				if(in_array($result[$numR]['id'],$tabDerP)){$test=false;}
				if($game=="FfQuizz" && $result[$numR]['diff']!=$tabdiffFf[$numQ-1]){$test=false;}
				if($game=="LxQuizz" && $result[$numR]['diff']!=$tabdiffLx[$numQ-1]){$test=false;}
				if($game=="TvQuizz" && $result[$numR]['diff']!=$tabdiffTv[$numQ-1]){$test=false;}
				if(in_array($result[$numR]['id'],$tabidQ)){$test=false;}
				if(in_array($result[$numR]['theme'],$tabtheme)){$test=false;}				
				if(in_array($result[$numR]['dom3'],$tabdom3)){$test=false;}
				if(in_array($result[$numR]['media'],$tabMedia)){$test=false;}
				}				
				$tabidQ[$numQ-1]=$result[$numR]['id'];	
				if(!$falseGame){
				$tabtheme[0]=$tabtheme[1];
				if($game=="LxQuizz"){$tabtheme[0]="x";}// Permet de uniquement conserver un thème dans la tab.
				$tabtheme[1]=$result[$numR]['theme'];		
				$tabdom3[$numQ-1]=$result[$numR]['dom3'];
				}
			}
		return $tabidQ;
			
	}

	public function testEcartId($idQtire,$numQ,$tabQ) {
		$ok=true;
		for ($i=1;$i<$numQ;$i++) {
			if ($idQtire<($tabQ[$i]+20) && $idQtire>($tabQ[$i]-20)){
				$ok=false;
			}		
		return $ok;			
		}
	}
	public function recupTheme($dom1){
		$query=$this->_em->createQuery('SELECT DISTINCT(q.theme) FROM MDQQuestionBundle:Question q WHERE q.dom1=:dom1');
			$query->setParameter('dom1', $dom1);
	return $query->getArrayResult();
	}
	public function recupDom3($dom1, $theme){
		$query=$this->_em->createQuery('SELECT DISTINCT(q.dom3) FROM MDQQuestionBundle:Question q WHERE q.dom1=:dom1 AND q.theme=:theme AND q.valid=1');
			$query->setParameter('dom1', $dom1)
			      ->setParameter('theme', $theme);
	return $query->getArrayResult();
	}
	public function recupDom2($dom3, $theme){
		$query=$this->_em->createQuery('SELECT DISTINCT(q.dom2) FROM MDQQuestionBundle:Question q WHERE q.dom3=:dom3 AND q.theme=:theme AND q.valid=1');
			$query->setParameter('dom3', $dom3)
			      ->setParameter('theme', $theme);
	return $query->getArrayResult();
	}
	public function recupDom2ouDom3($choice)
	{
		$question=$this->_em->createQueryBuilder();
			$question->select('q.id, q.dom1, q.'.$choice)
				->from('MDQQuestionBundle:Question', 'q')
				->orderBy('q.dom1', 'ASC')
				->addOrderBy('q.'.$choice, 'ASC');
			$result=$question->getQuery()
			    ->getResult();
		$tabdomX=[];
		$tabdomXdom1=[];
		foreach ($result as $question)
		{
			if($choice=="dom2"){$domX=$question['dom2'];}
			if($choice=="dom3"){$domX=$question['dom3'];}
			
			if(in_array($domX,$tabdomX)!==true)
			{
					array_push($tabdomX,$domX);
					if($choice=="dom2"){$tob['dom2']=$domX;}
					if($choice=="dom3"){$tob['dom3']=$domX;}
					$tob['dom1']=$question['dom1'];
					array_push($tabdomXdom1,$tob);
			}
			
		}
		if($choice=="dom2"){$tob1['dom1']="Autre";$tob1['dom2']="none";
								$tob2['dom1']="Autre";$tob2['dom2']="Autre";}
			if($choice=="dom3"){$tob1['dom1']="Autre";$tob1['dom3']="none";
								$tob2['dom1']="Autre";$tob2['dom3']="Autre";}
			array_push($tabdomXdom1,$tob1);
			array_push($tabdomXdom1,$tob2);
		return $tabdomXdom1;
	}
	public function recupDataQ($idQ){
		$question=$this->_em->createQueryBuilder();
			$question->select('q.id, q.intitule, q.brep, q.mrep1, q.mrep2, q.mrep3, q.dom1, q.theme, q.diff, q.commentaire, q.type, q.media')
				->from('MDQQuestionBundle:Question', 'q')
				->where('q.id = :id')
				->setParameter('id', $idQ);
							
			return $question->getQuery()
			    ->getOneOrNullResult();	
	}
	public function majVerifRep($requete)
	{
		$quest = $this->_em->createQueryBuilder();
			$quest->select('q')
				->from('MDQQuestionBundle:Question', 'q')
				->where('q.id = :id')
				->setParameter('id', $requete['idQ']);
			$question=$quest->getQuery()->getSingleResult();
		// ************ mise à jour de la bdd question ***********
			$newnbBrep=$question->getNbBrep();
			$newnbMrep1=$question->getNbMrep1();
			$newnbMrep2=$question->getNbMrep2();
			$newnbMrep3=$question->getNbMrep3();
			$newnbTout=$question->getNbTout();
			$newnbJoue=$question->getNbJoue()+1;
				$question->setNbJoue($newnbJoue);
			if ($requete['rep']==$question->getBrep()){$newnbBrep=$question->getNbBrep()+1;
											$question->setNbBrep($newnbBrep);}
			else if ($requete['rep']==$question->getMrep1()){$newnbMrep1=$question->getNbMrep1()+1;
											$question->setNbMrep1($newnbMrep1);}
			else if ($requete['rep']==$question->getMrep2()){$newnbMrep2=$question->getNbMrep2()+1;
											$question->setNbMrep2($newnbMrep2);}
			else if ($requete['rep']==$question->getMrep3()){$newnbMrep3=$question->getNbMrep3()+1;
											$question->setNbMrep3($newnbMrep3);}
			else if ($requete['rep']=="none"){$newnbTout=$question->getNbTout()+1;
											$question->setNbTout($newnbTout);}
			$question->setPrctBrep($newnbBrep*100/$newnbJoue);
			$question->setPrctMrep1($newnbMrep1*100/$newnbJoue);
			$question->setPrctMrep2($newnbMrep2*100/$newnbJoue);
			$question->setPrctMrep3($newnbMrep3*100/$newnbJoue);
			$question->setPrctTout($newnbTout*100/$newnbJoue);			
			if ($newnbJoue<101){$question->setPrct100j($newnbBrep*100/$newnbJoue);}
			if ($newnbJoue<501){$question->setPrct500j($newnbBrep*100/$newnbJoue);}
		return $question;
	}
	public function testDoublon($bdd, $crit, $chaine)// elle est demandé pour entrée des questions
	{
		//pour l'instant bdd sera toujours bddqcm
		$question=$this->_em->createQueryBuilder();
			if($bdd=="bddqcm"){
			$question->select('q.id, q.intitule, q.brep, q.mrep1, q.mrep2, q.mrep3, q.dom1, q.theme, q.diff, q.commentaire, q.type, q.media')
				->from('MDQQuestionBundle:Question', 'q');
			}
			elseif ($bdd=="bddqaval"){
			$question->select('q.id, q.intitule, q.brep, q.mrep1, q.mrep2, q.mrep3, q.dom1')
				->from('MDQQuestionBundle:QaValider', 'q');
			}
			$question->where('q.'.$crit.' = :crit')
				->setParameter('crit', $chaine);
		$tabdoublon=$question->getQuery()->getArrayResult();
		return $tabdoublon;
	}

}
