<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (Request $request) {
    $array = [
        'tenant-app.local.com' => 'production',
        'tenant-app-test.local.com' => 'domain_test',
        'tenant-app-development.local.com' => 'domain_dev',

    ];
    $host = $request->getHost();
    $keys = array_keys($array);
    if (in_array($host, $keys)) {
        $db = $array[$host];
        DB::purge('mysql');
        Config::set('database.connections.mysql.database', $db);
        Db::reconnect('mysql');
    }


    dd(DB::table('users')->get()->toArray());
    return view('welcome', compact('host'));
});
