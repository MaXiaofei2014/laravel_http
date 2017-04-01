<?php
namespace Ckryo\Laravel\Http\Contracts;

interface ExceptionFactory {
    /**
     * 回调处理错误信息
     *
     * @return bool
     */
    public function handle();

}