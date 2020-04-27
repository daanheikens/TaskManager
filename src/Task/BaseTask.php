<?php
declare(strict_types=1);

namespace Tm\Task;

abstract class BaseTask implements Task
{
    protected ?Task $preDecessor;

    protected string $error;

    public function setPredecessor(?Task $preDecessor): self
    {
        $this->preDecessor = $preDecessor;
        return $this;
    }

    public function getError(): string
    {
        return $this->error;
    }
}
