<?php
/**
 * Created by Dmytro Gorpynenko.
 * User: digorp@gmail.com
 * Date: 26.11.16
 * Time: 12:47
 */

namespace BarBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class BarCommand
 * @package BarBundle\Command
 */
class BarCommand extends ContainerAwareCommand
{
    /**
     * Command text
     */
    const BAR__TEXT   = 'Hi from Bar!';
    /**
     * Command
     */
    const BAR_COMMAND = 'bar:hi';

    /**
     * Dependency to execute command
     * @var string
     */
    private $dependTo = false;

    /**
     * BarCommand constructor.
     *
     * @param string $dependTo
     */
    public function __construct($dependTo)
    {
        parent::__construct();
        $this->dependTo = $dependTo;
    }

    /**
     * Configuration of command
     */
    protected function configure()
    {
        $this
            ->setName(self::BAR_COMMAND);
    }

    /**
     * Execution of command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws \Exception
     *
     * @return  void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = $this->getContainer()->get('logger');
        if (!$this->dependsDone()) {
            $logger->error('Error: ' . self::BAR_COMMAND . ' command is a member of ' . $this->dependTo . ' command chain and cannot be executed on its own.');
            throw new \Exception('Error: ' . self::BAR_COMMAND . ' command is a member of ' . $this->dependTo . ' command chain and cannot be executed on its own.');
        }

        $output->writeln([
            self::BAR__TEXT,
        ]);
        $logger->info(self::BAR__TEXT);
        $this->getContainer()->get('app.chain')->setDone(self::BAR_COMMAND);
    }

    /**
     * Checking if dependent command was executed
     *
     * @return bool
     */
    private function dependsDone()
    {
        return $this->getContainer()->get('app.chain')->isDone($this->dependTo);
    }
}