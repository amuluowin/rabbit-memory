<?php


namespace rabbit\memory\atomic;

use rabbit\helper\ExceptionHelper;

/**
 * Class AtomicLock
 * @package rabbit\memory\atomic
 */
class AtomicLock implements LockInterface
{
    /** @var \Swoole\Atomic|\Swoole\Atomic\Long */
    protected $atomic;

    /**
     * AtomicLock constructor.
     */
    public function __construct()
    {
        $this->atomic = new \Swoole\Atomic();
    }
    /**
     * @param \Closure $function
     * @param array $params
     * @return mixed
     */
    public function lock(\Closure $function, array $params = [])
    {
        try {
            while ($this->atomic->get() !== 0) {
                \Co::sleep(0.001);
            }
            $this->atomic->add();
            $result = call_user_func($function, ...$params);
            return $result;
        } catch (\Throwable $throwable) {
            print_r(ExceptionHelper::convertExceptionToArray($throwable));
        } finally {
            $this->atomic->sub();
        }
    }
}
