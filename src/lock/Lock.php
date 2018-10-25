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
 * Class Lock
 * @package rabbit\memory\lock
 */
class Lock
{
    /**
     * @var array
     */
    private $locks = [];

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
            $this->locks[$name] = new SwooleLock($locktype, $lockfile);
        } else {
            $this->locks[$name] = new SwooleLock($locktype);
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