<?php


namespace rabbit\memory\atomic;

/**
 * Class AtomicInterface
 * @package rabbit\memory\atomic
 */
interface AtomicInterface
{
    /**
     * @param $value
     * @return int
     */
    public function add(int $value = 1): int;

    /**
     * @param $value
     * @return int
     */
    public function sub(int $value = 1): int;

    /**
     * @return int
     */
    public function get(): int;

    /**
     * @param int $value
     */
    public function set(int $value): void;

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