<?php
declare(strict_types=1);

class SubstractTask extends BaseTask
{
    private const SUBSTRACT_VALUE = 2;

    private $value;

    public function run(): void
    {
        $this->value = $this->preDecessor->getResult();
        $this->value -= self::SUBSTRACT_VALUE;
    }

    public function getResult()
    {
        return $this->value;
    }
}
