<?php

namespace Ckryo\Http;

use Ckryo\Http\Contracts\ExceptionFactory;
use Ckryo\Http\Facades\ErrorCode;

class ErrorCodeException extends \Exception implements ExceptionFactory
{
    protected $code;
    protected $message;
    protected $data;

    public function __construct($code, $message = null, $data = null)
    {
        $this->code = $code;
        $this->data = $data;
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