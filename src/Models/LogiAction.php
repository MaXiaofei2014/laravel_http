<?php
namespace Ckryo\Http\Models;
use Illuminate\Database\Eloquent\Model;


class LogiAction extends Model
{
    protected $table = 'logi_actions';
    protected $connection = 'mysql';
    public $timestamps = false;
}