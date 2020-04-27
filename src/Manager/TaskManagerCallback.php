<?php
declare(strict_types=1);

namespace Tm\Manager;

use Throwable;

interface TaskManagerCallback
{
    /**
     * @param mixed|null $result
     */
    public function onSuccess($result = null): void;

    /**
     * @param string $error
     * @param Throwable|null $throwable
     */
    public function onError(string $error, Throwable $throwable = null): void;
}