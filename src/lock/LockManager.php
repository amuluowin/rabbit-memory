<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/25
 * Time: 13:47
 */

namespace rabbit\memory\lock;

use Swoole\Lock as SwooleLock;

/**
 * Class SwooleLock
 * @package rabbit\memory\lock
 */
class LockManager
{
    /**
     * @var array
     */
    private $locks = [];
    /**
     * @var
     */
    private $lockCrl = Lock::class;

    /**
     * Lock constructor.
     * @param LockInterface $lockCrl
     */
    public function __construct(string $lockCrl = null)
    {
        if ($lockCrl) {
            $this->lockCrl = $lockCrl;
        }
    }

    /**
     * @param string $name
     * @param int $locktype
     * @param string|null $lockfile
     */
    public function addLock(string $name, int $locktype, string $lockfile = null): void
    {
        if ($locktype === SWOOLE_FILELOCK) {
            if (!$lockfile) {
                throw new \InvalidArgumentException('the filelock must with a file!');
            }
            $this->locks[$name] = $this->lockCrl::create(new SwooleLock($locktype, $lockfile));
        } else {
            $this->locks[$name] = $this->lockCrl::create(new SwooleLock($locktype));
        }
    }

    /**
     * @param array $locks
     */
    public function addLocks(array $locks): void
    {
        foreach ($locks as $name => $lock) {
            $this->locks[$name] = $lock;
        }
    }

    /**
     * @param string $name
     * @return null|SwooleLock
     */
    public function getLock(string $name): ?SwooleLock
    {
        return isset($this->locks[$name]) ? $this->locks[$name] : null;
    }

    /**
     * @return array
     */
    public function getLocks(): array
    {
        return $this->locks;
    }
}