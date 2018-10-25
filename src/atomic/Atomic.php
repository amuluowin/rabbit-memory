<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/25
 * Time: 13:39
 */

namespace rabbit\memory\atomic;

use Swoole\Atomic as SwooleAtomic;

/**
 * Class Atomic
 * @package rabbit\memory\atomic
 */
class Atomic
{
    /**
     * @var array
     */
    private $atomics = [];

    /**
     * @param string $name
     * @return null|SwooleAtomic
     */
    public function getAtomic(string $name): ?SwooleAtomic
    {
        return isset($this->atomics[$name]) ? $this->atomics[$name] : null;
    }

    /**
     * @return array
     */
    public function getAtomics(): array
    {
        return $this->atomics;
    }

    /**
     * @param string $name
     * @param SwooleAtomic $atomic
     */
    public function addAtomic(string $name, int $init_value): void
    {
        $this->atomics[$name] = new SwooleAtomic($init_value);
    }

    /**
     * @param array $atomics
     */
    public function addAtomics(array $atomics): void
    {
        foreach ($atomics as $name => $atomic) {
            $this->setAtomic($name, $atomic);
        }
    }
}