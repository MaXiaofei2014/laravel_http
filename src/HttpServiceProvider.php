<?php

namespace Ckryo\Laravel\Http;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class HttpServiceProvider extends ServiceProvider
{

    public function boot (ErrorCode $errorCode) {
        /// 部署配置
        $this->mergeConfigFrom(__DIR__.'/../config/errorCode.php', config_path('errorCode.php'));
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $json_headers = [
            'Content-Type' => 'application/json'
        ];

        Response::macro('ok', function ($msg = '操作成功', $data = null) use ($json_headers) {
            return Response::make(json_encode([
                'errCode' => 0,
                'errMsg' => $msg,
                'data' => $data
            ], JSON_UNESCAPED_UNICODE), 200)->withHeaders($json_headers);
        });

        Response::macro('data', function ($data = null) use ($json_headers) {
            return Response::make(json_encode([
                'errCode' => 0,
                'errMsg' => '操作成功',
                'data' => $data
            ], JSON_UNESCAPED_UNICODE), 200)->withHeaders($json_headers);
        });

        Response::macro('page', function ($result) use ($json_headers) {
            return Response::make(json_encode([
                'errCode' => 0,
                'errMsg' => 'ok',
                'datas' => $result->items(),
                'pages' => [
                    'total' => $result->total(),
                    'per_page' => $result->perPage(),
                    'current_page' => $result->currentPage()
                ]
            ], JSON_UNESCAPED_UNICODE), 200)->withHeaders($json_headers);
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