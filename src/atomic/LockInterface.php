<?php


namespace rabbit\memory\atomic;

/**
 * Interface LockInterface
 * @package rabbit\memory\atomic
 */
interface LockInterface
{
    /**
     * @param \Closure $function
     * @param array $params
     * @return mixed
     */
    public function __invoke(\Closure $function, string $name = '', float $timeout = 600, array $params = []);
}
