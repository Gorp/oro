<?php
/**
 * Created by Dmytro Gorpynenko.
 * User: digorp@gmail.com
 * Date: 26.11.16
 * Time: 15:31
 */

namespace FooBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ChainTest extends KernelTestCase
{
    const COMMAND = 'test';

    public function testIsDoneSuccess()
    {
        $chainService = new Chain();
        $chainService->setDone(self::COMMAND);

        $this->assertTrue($chainService->isDone(self::COMMAND));
    }

    public function testIsDoneFailed()
    {
        $chainService = new Chain();

        $this->assertFalse($chainService->isDone(self::COMMAND));
    }
}
