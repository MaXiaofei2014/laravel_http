<?php
namespace Ckryo\Http\Models;
use Illuminate\Database\Eloquent\Model;


class LogiIp extends Model
{
    protected $table = 'logi_ips';
    protected $connection = 'mysql';
    public $timestamps = false;
}