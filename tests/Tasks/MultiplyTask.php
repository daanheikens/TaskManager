<?php
declare(strict_types=1);

class MultiplyTask extends BaseTask
{
    private const MULTIPLY_VALUE = 3;

    private $value;

    public function run(): void
    {
        $this->value = $this->preDecessor->getResult();
        $this->value *= self::MULTIPLY_VALUE;
    }

    public function getResult()
    {
        return $this->value;
    }
}