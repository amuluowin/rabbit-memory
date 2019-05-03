<?php


namespace rabbit\memory\lock;

/**
 * Class LockCtl
 * @package rabbit\memory\lock
 */
class Lock implements LockInterface
{
    /** @var \Swoole\Lock */
    private $lock;

    /**
     * LockCtl constructor.
     * @param \Swoole\Lock $lock
     */
    public function __construct(\Swoole\Lock $lock)
    {
        $this->lock = $lock;
    }

    /**
     * @return \Swoole\Lock
     */
    public function getLock(): \Swoole\Lock
    {
        return $this->lock;
    }

    /**
     * @param callable $function
     */
    public function lock(callable $function)
    {
        $this->lock->lock();
        $result = call_user_func($function);
        $this->lock->unlock();
        return $result;
    }

    /**
     * @param \Swoole\Lock $lock
     * @return LockCtl
     */
    public static function create(\Swoole\Lock $lock): LockInterface
    {
        return new static($lock);
    }
}