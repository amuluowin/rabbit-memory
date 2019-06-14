<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/25
 * Time: 13:39
 */

namespace rabbit\memory\atomic;


use rabbit\exception\NotSupportedException;

/**
 * Class Atomic64
 * @package rabbit\memory\atomic
 */
class Atomic64 extends Atomic
{
    /**
     * Atomic64 constructor.
     * @param int $init_value
     */
    public function __construct(int $init_value = 0)
    {
        $this->atomic = new \Swoole\Atomic\Long($init_value);
    }

    /**
     * @param float $timeout
     * @return bool
     */
    public function wait(float $timeout = 1.0): bool
    {
        throw new NotSupportedException("64bit atomic not support " . __METHOD__);
    }

    /**
     * @param int $n
     * @return bool
     */
    public function wakeup(int $n = 1): bool
    {
        throw new NotSupportedException("64bit atomic not support " . __METHOD__);
    }
}