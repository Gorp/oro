<?php
/**
 * Created by Dmytro Gorpynenko.
 * User: digorp@gmail.com
 * Date: 26.11.16
 * Time: 12:47
 */

namespace FooBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class FooCommand
 * @package FooBundle\Command
 */
class FooCommand extends ContainerAwareCommand
{
    /**
     * Command text
     */
    const FOO__TEXT = 'Hello from Foo!';
    /**
     * Command
     */
    const FOO_COMMAND = 'foo:hello';

    /**
     * Configuration of command
     */
    protected function configure()
    {

        $this
            ->setName(self::FOO_COMMAND);
    }

    /**
     * Execution of command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws \Symfony\Component\Console\Exception\ExceptionInterface
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = $this->getContainer()->get('logger');
        $logger->info("Executing " . self::FOO_COMMAND . " command itself first:");
        $output->writeln([
            self::FOO__TEXT,
        ]);
        $logger->info(self::FOO__TEXT);

        $logger->info("Executing " . self::FOO_COMMAND . " chain members:");
        $this->getContainer()->get('app.chain')->setDone(self::FOO_COMMAND);
        $command = $this->getContainer()->get('bar.command.bar');
        $command->run(new ArrayInput([]), $output);
        $logger->info("Execution of " . self::FOO_COMMAND . " chain completed!");
    }


}