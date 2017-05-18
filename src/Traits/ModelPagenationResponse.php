<?php
namespace Ckryo\Laravel\Http\Extenion;
use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: liurong
 * Date: 2017/4/5
 * Time: 下午3:51
 */

trait ModelPagenationResponse {

    public function response () {
        if ($this instanceof Model) {



        }
        throw new \Exception(ModelPagenationResponse::class.'->response() 方法仅限模型使用');
    }

}