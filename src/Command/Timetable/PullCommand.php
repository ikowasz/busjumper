<?php

namespace App\Command\Timetable;

use App\Service\Timetable\Loader\CzestochowaLoader;
use App\Service\Timetable\Puller;
use App\Service\Retriever\Timetable\StopRetriever;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:timetable:pull',
    description: 'Pulls the timetable data from the source (currently Częstochowa only)',
)]
class PullCommand extends Command
{
    public function __construct(
        private readonly CzestochowaLoader $loader,
        private readonly Puller $puller,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            // ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        // $arg1 = $input->getArgument('arg1');

        // if ($arg1) {
        //     $io->note(sprintf('You passed an argument: %s', $arg1));
        // }

        // if ($input->getOption('option1')) {
        //     // ...
        // }

        $this->puller->setLoader($this->loader);
        $arrivals = $this->puller->pull();

        $io->success('Pulled ' . count($arrivals) . ' arrivals');

        return Command::SUCCESS;
    }
}
