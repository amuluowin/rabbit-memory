<?php


namespace rabbit\memory\atomic;

/**
 * Class LockManager
 * @package rabbit\memory\atomic
 */
class LockManager
{
    /** @var array */
    private $locks = [];

    /**
     * LockManager constructor.
     * @param array $locks
     */
    public function __construct(array $locks)
    {
        $this->locks = $locks;
    }

    /**
     * @param string $name
     * @return LockInterface|null
     */
    public function getLock(string $name): ?LockInterface
    {
        if (isset($this->locks[$name])) {
            return $this->locks[$name];
        }
        return null;
    }
}