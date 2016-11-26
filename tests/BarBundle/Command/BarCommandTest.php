<?php
/**
 * Created by Dmytro Gorpynenko.
 * User: digorp@gmail.com
 * Date: 26.11.16
 * Time: 12:51
 */

namespace BarBundle\Command;
namespace Tests\AppBundle\Command;

use BarBundle\Command\BarCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class BarCommandTest extends KernelTestCase
{
    public function testFailedExecute()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new BarCommand('foo:hello'));

        $command = $application->find('bar:hi');
        $commandTester = new CommandTester($command);

        $this->expectException('\Exception');
        $this->expectExceptionMessage('Error: bar:hi command is a member of foo:hello command chain and cannot be executed on its own.');
        $commandTester->execute(array(
            'command'  => $command->getName(),
        ));
    }

    public function testSuccessExecute()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new BarCommand('foo:hello'));

        self::$kernel->getContainer()->get('app.chain')->setDone('foo:hello');
        $command = $application->find('bar:hi');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),
        ));
        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertContains(BarCommand::BAR__TEXT, $output);
    }
}

