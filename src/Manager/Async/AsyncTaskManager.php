<?php
declare(strict_types=1);

namespace Manager\Async;

use Spatie\Async\Pool;
use Tm\Async\AsyncTask;
use Tm\Exception\TaskException;
use Tm\Manager\TaskManagerCallback;

class AsyncTaskManager
{
    /** @var int */
    private const DEFAULT_CONCURRENCY = 20;
    /** @var int */
    private const DEFAULT_TIMEOUT = 300;
    /** @var TaskManagerCallback */
    private TaskManagerCallback $callback;
    /** @var int */
    private int $concurrency = self::DEFAULT_CONCURRENCY;
    /** @var int */
    private int $timeout = self::DEFAULT_TIMEOUT;
    /** @var AsyncTask[] */
    private array $tasks = [];

    public function __construct(TaskManagerCallback $callback)
    {
        $this->callback = $callback;
    }

    public function setConcurrency(int $concurrency): self
    {
        $this->concurrency = $concurrency;
        return $this;
    }

    public function setTimeout(int $timeout): self
    {
        $this->timeout = $timeout;
        return $this;
    }

    public function addTasks(AsyncTask ...$tasks)
    {
        $this->tasks = $tasks;
        return $this;
    }

    public function run()
    {
        $pool = $this->buildProcessPool();
        foreach ($this->tasks as $task) {
            $pool
                ->add($task)
                ->timeout(function () use ($pool) {
                    $this->callback->onError("Timeout exceeded: " . $this->timeout);
                    $pool->stop();
                })->catch(function (TaskException $e) use ($task, $pool) {
                    $this->callback->onError($task->getError(), $e);
                    $pool->stop();
                });
        }

        $pool->wait();
    }

    private function buildProcessPool()
    {
        return Pool::create()
            ->concurrency($this->concurrency)
            ->timeout($this->timeout);
    }
}
