<?php

namespace Ckryo\Laravel\Http;

use Ckryo\Laravel\Http\Contracts\ExceptionFactory;
use Ckryo\Laravel\Http\Facades\ErrorCode;

class ErrorCodeException extends \Exception implements ExceptionFactory
{
    protected $code;
    protected $message;
    protected $data;

    public function __construct($code, $message = null, $data = null)
    {
        $this->code = $code;
        $this->data = $data ?: $this;
        $this->message = $message ?: ErrorCode::getErrMsg($code);
    }

    public function handle()
    {
        return response()->origin([
            'errCode' => $this->code,
            'errMsg' => $this->message,
            'data' => $this->data
        ]);
    }
}