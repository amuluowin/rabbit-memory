<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/25
 * Time: 13:39
 */

namespace rabbit\memory\atomic;


/**
 * Class Atomic
 * @package rabbit\memory\atomic
 */
class Atomic implements AtomicInterface
{
    /** @var \Swoole\Atomic|\Swoole\Atomic\Long */
    protected $atomic;

    public function __construct(int $init_value = 0)
    {
        $this->atomic = new \Swoole\Atomic($init_value);
    }

    /**
     * @param $value
     * @return int
     */
    public function add($value): int
    {
        return $this->atomic->add($value);
    }

    /**
     * @param $value
     * @return int
     */
    public function sub($value): int
    {
        return $this->atomic->sub($value);
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->atomic->get($value);
    }

    /**
     * @param int $value
     */
    public function set(int $value): void
    {
        $this->atomic->set($value);
    }

    /**
     * @param int $cmp_value
     * @param int $set_value
     * @return bool
     */
    public function cmpset(int $cmp_value, int $set_value): bool
    {
        return $this->atomic->cmpset($cmp_value, $set_value);
    }

    /**
     * @param float $timeout
     * @return bool
     */
    public function wait(float $timeout = 1.0): bool
    {
        return $this->atomic->wait($timeout);
    }

    /**
     * @param int $n
     * @return bool
     */
    public function wakeup(int $n = 1): bool
    {
        return $this->atomic->wakeup($n);
    }

    /**
     * @param \Closure $function
     * @param array $params
     * @return mixed
     */
    public function lock(\Closure $function, array $params = [])
    {
        while ($this->atomic->get() !== 0) {
            \Co::sleep(0.001);
        }
        $this->atomic->add();
        $result = call_user_func($function, ...$params);
        $this->atomic->sub();
        return $result;
    }
}