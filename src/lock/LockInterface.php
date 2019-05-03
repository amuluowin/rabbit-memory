<?php


namespace rabbit\memory\lock;

/**
 * Interface LockInterface
 * @package rabbit\memory\lock
 */
interface LockInterface
{
    /**
     * @param callable $function
     */
    public function lock(callable $function);

    /**
     * @param \Swoole\Lock $lock
     * @return LockInterface
     */
    public static function create(\Swoole\Lock $lock): self;
}