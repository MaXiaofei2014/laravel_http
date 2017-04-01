<?php

namespace Ckryo\Http;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class HttpServiceProvider extends ServiceProvider
{

    public function boot (ErrorCode $errorCode) {
        /// 部署配置
        $this->mergeConfigFrom(__DIR__.'/../config/errorCode.php', config_path('errorCode.php'));
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        /**
         * 定义全局 json 方法 -> origin
         */
        Response::macro('origin', function ($value) {
            return Response::make(json_encode($value, JSON_UNESCAPED_UNICODE), 200)
                ->withHeaders([
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Allow-Origin' => '*',
                    'Content-Type' => 'application/json'
                ]);
        });

        Response::macro('ok', function ($msg = '操作成功', $data = null) {
            return Response::make(json_encode([
                'errCode' => 0,
                'errMsg' => $msg,
                'data' => $data
            ], JSON_UNESCAPED_UNICODE), 200)
                ->withHeaders([
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Allow-Origin' => '*',
                    'Content-Type' => 'application/json'
                ]);
        });

        /**
         * 注册配置文件中的错误码
         */
        if (file_exists(config_path('errorCode.php'))) {
            foreach (config('errorCode') as $model => $codes) {
                $errorCode->regist($model, $codes);
            }
        }
    }

    public function register()
    {
        $this->app->singleton('errorcode', function () {
            return new ErrorCode();
        });

        $this->app->bind(ErrorCode::class, function ($app) {
            return $app->make('errorcode');
        });

        $this->app->singleton('logi', function ($app) {
            return new Logi($app);
        });

        $this->app->bind(Logi::class, function ($app) {
            return $app->make('logi');
        });
    }

}