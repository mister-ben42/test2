<?php

// src/AppBundle/Command/CreateUserCommand.php
namespace MDQ\GeneBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class MajHeureCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        // the name of the command (the part after "app/console")
        ->setName('app:majHeure')

        // the short description shown while running "php app/console list"
        ->setDescription('Mise à jour horaire')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp("Mise à jour à chaque heure : test des parties non terminées et mise en place de parties de bot.")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('mdq_gene.cronServ')->testNonValidPartie();
        
        // partie bot : on tire au sort, pas encore joué (1) ou indifférent (0)
        $nbBots=mt_rand(1, 4);
        $djajoue=mt_rand(0, 1);
        
                $botsSelects2=$this->getContainer()->get('mdq_user.repository.scuser')->getBot($djajoue);//renvoit les id des bots de tous ou de ceux qui n'ont pas encore joué au Mq
		$nbBotsSelect=count($botsSelects2);
		if($nbBotsSelect!=0){
		if($nbBots>$nbBotsSelect){$nbBots=$nbBotsSelect;}
		$botsSelects=$this->getContainer()->get('mdq_user.repository.user')
						 ->getBots($nbBots,$nbBotsSelect,$botsSelects2);
		// tirage au sort du type
		$tabType=['Tous','Mq','Cq'];
		$num=mt_rand(0, 2);
		$type=$tabType[$num];
		$this->getContainer()->get('mdq_admin.botGame')->execBotGame($botsSelects, $type);
		}
        
        $this->getContainer()->get('doctrine.orm.entity_manager')->flush();
    }
}

