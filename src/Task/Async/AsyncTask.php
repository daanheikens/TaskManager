<?php
declare(strict_types=1);

namespace Tm\Async;

use Tm\Exception\TaskException;

interface AsyncTask
{
    public function __invoke();

    /**
     * @throws TaskException
     */
    public function run(): void;

    /**
     * @return string
     */
    public function getError(): string;
}
