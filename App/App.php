<?php


namespace Webazex\App;
use Webazex\App\Core\Kernel\DB\DB as DB;

class App
{
    public function __construct()
    {

    }
    public function test(){
        DB::connect();
//        DB::insert('test', [
//            'id' => NUll,
//            'name' => 'test2',
//            'description' => 'test insert method 1',
//            'value' => '090',
//        ]);

    }
}