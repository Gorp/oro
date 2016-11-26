<?php
/**
 * Created by Dmytro Gorpynenko.
 * User: digorp@gmail.com
 * Date: 26.11.16
 * Time: 14:21
 */

namespace FooBundle\Service;


/**
 * Class Chain
 * @package FooBundle\Service
 */
class Chain
{

    /**
     * List of executed commands
     *
     * @var array
     */
    private $done = [];

    /**
     * Check if command was executed
     *
     * @param $command
     *
     * @return bool
     */
    public function isDone($command)
    {
        return in_array($command, $this->done);
    }

    /**
     * Add command to list of executed command
     *
     * @param $command
     */
    public function setDone($command)
    {
        array_push($this->done, $command);
    }
}