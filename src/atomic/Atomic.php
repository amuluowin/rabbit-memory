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
 * Class Atomic
 * @package rabbit\memory\atomic
 */
class Atomic implements AtomicInterface
{
    /**
     * @var array
     */
    protected $atomics = [];
    /** @var string */
    protected $default = self::INT32;

    public function __construct(string $default = self::INT32)
    {
        $this->default = $default;
    }

    /**
     * @param string $name
     * @param int $init_value
     * @param string|null $type
     * @return mixed
     */
    public function getAtomic(string $name, int $init_value = 0, string $type = null)
    {
        $type = $type ?? $this->default;
        $atomic = new $type($init_value);
        $this->atomics[$name] = $atomic;
        return $atomic;
    }

    /**
     * @return array
     */
    public function getAtomics(): array
    {
        return $this->atomics;
    }

    /**
     * @param array $atomics
     */
    public function addAtomics(array $atomics): void
    {
        foreach ($atomics as $name => $init_value) {
            $this->getAtomic($name, $init_value);
        }
    }

    /**
     * @param string $name
     * @param $value
     * @return int
     */
    public function add(string $name, $value): int
    {
        return $this->getAtomic($name)->add($value);
    }

    /**
     * @param string $name
     * @param $value
     * @return int
     */
    public function sub(string $name, $value): int
    {
        return $this->getAtomic($name)->sub($value);
    }

    /**
     * @param string $name
     * @return int
     */
    public function get(string $name): int
    {
        return $this->getAtomic($name)->get($value);
    }

    /**
     * @param string $name
     * @param int $value
     */
    public function set(string $name, int $value): void
    {
        return $this->getAtomic($name)->set($value);
    }

    /**
     * @param int $cmp_value
     * @param int $set_value
     * @return bool
     */
    public function cmpset(int $cmp_value, int $set_value): bool
    {
        return $this->getAtomic($name)->cmpset($cmp_value, $set_value);
    }

    /**
     * @param float $timeout
     * @return bool
     */
    public function wait(float $timeout = 1.0): bool
    {
        if (($atomic = $this->getAtomic($name)) instanceof \Swoole\Atomic\Long) {
            throw new NotSupportedException("atomic {$name} not support " . __METHOD__);
        }
        return $atomic->wait($timeout);
    }

    /**
     * @param int $n
     * @return bool
     */
    public function wakeup(int $n = 1): bool
    {
        if (($atomic = $this->getAtomic($name)) instanceof \Swoole\Atomic\Long) {
            throw new NotSupportedException("atomic {$name} not support " . __METHOD__);
        }
        return $this->atomics[$name]->wakeup($n);
    }
}