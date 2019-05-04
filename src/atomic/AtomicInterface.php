<?php


namespace rabbit\memory\atomic;

/**
 * Class AtomicInterface
 * @package rabbit\memory\atomic
 */
interface AtomicInterface
{
    const INT32 = '\Swoole\Atomic';
    const INT64 = '\Swoole\Atomic\Long';
    /**
     * @param string $name
     * @param $value
     * @return int
     */
    public function add(string $name, $value): int;

    /**
     * @param string $name
     * @param $value
     * @return int
     */
    public function sub(string $name, $value): int;

    /**
     * @param string $name
     * @return int
     */
    public function get(string $name): int;

    /**
     * @param string $name
     * @param int $value
     */
    public function set(string $name, int $value): void;

    /**
     * @param int $cmp_value
     * @param int $set_value
     * @return bool
     */
    public function cmpset(int $cmp_value, int $set_value): bool;

    /**
     * @param float $timeout
     * @return bool
     */
    public function wait(float $timeout = 1.0): bool;

    /**
     * @param int $n
     * @return bool
     */
    public function wakeup(int $n = 1): bool;
}