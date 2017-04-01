<?php
namespace Ckryo\Http\Models;
use Illuminate\Database\Eloquent\Model;


class IpBlack extends Model
{
    protected $table = 'ip_blacks';
    protected $connection = 'mysql';
    public $timestamps = false;


    function current() {
        return static::where('ip', $this->ip)->where('block_time', '>', time())->count();
    }

    function totoal() {
        return static::where('ip', $this->ip)->count();
    }

    function blockTime() {
        return static::where('ip', $this->ip)->last();
    }

}