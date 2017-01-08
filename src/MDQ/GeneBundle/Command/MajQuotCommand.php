<?php

// src/AppBundle/Command/CreateUserCommand.php
namespace MDQ\GeneBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class MajQuotCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        // the name of the command (the part after "app/console")
        ->setName('app:majQuot')

        // the short description shown while running "php app/console list"
        ->setDescription('Mise à jour quotidienne')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp("Commande la mise à jour quotidienne de la base de données.")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('mdq_gene.cronServ')->majQuot();
        $newStatsQuot=$this->getContainer()->get('mdq_gene.statsQuot')->majStatsQuot();
        $this->getContainer()->get('doctrine.orm.entity_manager')->persist($newStatsQuot);
        $this->getContainer()->get('doctrine.orm.entity_manager')->flush();
    }
}

