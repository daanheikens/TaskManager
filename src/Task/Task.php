<?php
declare(strict_types=1);

namespace Tm\Task;

use Tm\Exception\TaskException;

interface Task
{
    /**
     * @return void
     * @throws TaskException
     */
    public function run();

    /**
     * @return mixed|null
     */
    public function getResult();

    /**
     * @return string
     */
    public function getError(): string;

    /**
     * @param Task|null $task
     * @return $this
     */
    public function setPredecessor(?Task $task): self;

    /**
     * @param callable $callback
     */
    public function onComplete(callable $callback): void;
}
