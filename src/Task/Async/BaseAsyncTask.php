<?php
declare(strict_types=1);

namespace Tm\Async;

use Tm\Exception\TaskException;
use Tm\Task\Task;

abstract class BaseAsyncTask implements AsyncTask
{
    protected string $error;

    /**
     * @throws TaskException
     */
    public function __invoke()
    {
        $this->run();
    }

    public function getError(): string
    {
        return $this->error;
    }
}
