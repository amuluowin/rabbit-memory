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
    public function __invoke(\Closure $function, string $name = '', float $timeout = 0.001, array $params = [])
    {
        try {
            while ($this->atomic->get() !== 0) {
                \Co::sleep($timeout);
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
