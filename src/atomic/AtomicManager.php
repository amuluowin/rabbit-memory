<?php


namespace rabbit\memory\atomic;

/**
 * Class AtomicManager
 * @package rabbit\memory\atomic
 */
class AtomicManager
{
    /** @var array */
    private $atomics = [];

    /**
     * AtomicManager constructor.
     * @param array $atomics
     */
    public function __construct(array $atomics)
    {
        $this->atomics = $atomics;
    }

    /**
     * @param string $name
     * @return AtomicInterface|null
     */
    public function getAtomic(string $name): ?AtomicInterface
    {
        if (isset($this->atomics[$name])) {
            return $this->atomics[$name];
        }
        return null;
    }
}
