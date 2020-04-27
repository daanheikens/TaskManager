<?php
declare(strict_types=1);

namespace Tm\Manager;

use Tm\Exception\TaskException;
use Tm\Task\Task;

class TaskManager
{
    private TaskManagerCallback $callback;

    /** @var Task[] */
    private array $tasks = [];

    public function __construct(TaskManagerCallback $callback)
    {
        $this->callback = $callback;
    }

    public function addTasks(Task ...$tasks)
    {
        $previousTask = null;
        foreach ($tasks as $task) {
            if ($previousTask === null) {
                $previousTask = $task;
                continue;
            }
            $task->setPredecessor($previousTask);
            $previousTask = $task;
        }

        $this->tasks = $tasks;
        return $this;
    }

    public function run()
    {
        $lastExecutedTask = null;
        foreach ($this->tasks as $task) {
            try {
                $task->run();
            } catch (TaskException $e) {
                $this->callback->onError($task->getError(), $e);
                return;
            }

            $lastExecutedTask = $task;
        }

        if ($lastExecutedTask instanceof Task) {
            $this->callback->onSuccess($lastExecutedTask->getResult());
        }
    }
}
