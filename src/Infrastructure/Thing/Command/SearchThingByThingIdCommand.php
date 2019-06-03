<?php

namespace App\Infrastructure\Thing\Command;

use App\Application\Dto\UserCredentialsDTO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;
use App\Infrastructure\Thing\Serializer\ThingWithCredentials;


class SearchThingByThingIdCommand extends Command
{
    protected static $defaultName = 'app:Thing:SearchThingByThingId';
    /**
     * @var SearchThingByIdHandler
     */
    private $searchThingByIdHandler;

    public function __construct(SearchThingByIdHandler $searchThingByIdHandler)
    {
        parent::__construct();
        $this->searchThingByIdHandler = $searchThingByIdHandler;
    }

    protected function configure()
    {
        $this
            ->setDescription('Given a (int) id, (int) user and (int) password  searches Thing')
            ->addArgument('thingId', InputArgument::REQUIRED, '(int) thing id')
            ->addArgument('user', InputArgument::REQUIRED, '(int) user')
            ->addArgument('password', InputArgument::REQUIRED, '(int) Password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $searchThingByThingIdCommand = new SearchThingByIdCommand($input->getArgument('thingId'), new UserCredentialsDTO($input->getArgument('user'), $input->getArgument('password')));
        $thing = $this->searchThingByIdHandler->handle($searchThingByThingIdCommand);
        // dont know why cant use dd. Getting this error: "Attempted to call function "dd" from namespace "App\Infrastructure\Thing\Command""
        // dd($thing);
        $output->writeln(ThingWithCredentials::asJson($thing));
    }
}