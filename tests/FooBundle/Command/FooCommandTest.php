<?php
/**
 * Created by Dmytro Gorpynenko.
 * User: digorp@gmail.com
 * Date: 26.11.16
 * Time: 12:51
 */

namespace FooBundle\Command;

use BarBundle\Command\BarCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class FooCommandTest extends KernelTestCase
{
    public function testSuccessExecute()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new FooCommand());

        $command = $application->find('foo:hello');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),
        ));
        $output = $commandTester->getDisplay();
        $this->assertEquals(FooCommand::FOO__TEXT."\n".BarCommand::BAR__TEXT."\n", $output);
    }
}

