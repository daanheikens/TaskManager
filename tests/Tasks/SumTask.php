<?php
declare(strict_types=1);

use TM\Task\BaseTask;

class SumTask extends BaseTask
{
    private const SUM_VALUE = 2;

    private $initialValue = 1;

    public function run(): void
    {
        $this->initialValue += self::SUM_VALUE;
    }

    public function getResult()
    {
        return $this->initialValue;
    }

    public function configure(): void
    {
        // TODO: Implement configure() method.
    }
}