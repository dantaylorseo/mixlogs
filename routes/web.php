<?php

use App\Models\Application;
use App\Models\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::get('log/{sessionid}', function( Application $application, $sessionid ) {
    $logs = Log::where('sessionid', $sessionid)->orderBy('timestamp')->get();

    return view('log', [
        'logs' => $logs,
        'sessionid' => $sessionid,
        'application' => $application
    ]);
});

Route::get('log/{sessionid}/raw', function( $sessionid ) {
    // if( !Str::startsWith($sessionid, 'nvaa') ) {
    //     $sessionid = 'nvaa'.$sessionid;
    // }
    $logs = Log::where('sessionid', $sessionid)->orderBy('timestamp')->get();

    //$logs = $logs->groupBy('service');

    return $logs;

    // $contents = $logs->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    // $filename = $sessionid.'.json';
    // $headers = array(
    //     "Content-type" => "text/csv",
    //     "Content-Disposition" => "attachment; filename=$filename",
    //     "Pragma" => "no-cache",
    //     "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
    //     "Expires" => "0"
    // );

    // // return response()->streamDownload(function () use ($contents) {
    // //     echo $contents;
    // // }, $filename);

    // return Response::stream(function () use($contents) {
    //     echo $contents;
    // }, 200, $headers)->send();
});

Route::get('log/{sessionid}/download', function( $sessionid ) {
    if( !Str::startsWith($sessionid, 'nvaa') ) {
        $sessionid = 'nvaa'.$sessionid;
    }
    $logs = Log::where('sessionid', $sessionid)->orderBy('timestamp')->get();

    $logs = $logs->groupBy('service');

    //return $logs->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $contents = $logs->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $filename = $sessionid.'.json';
    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    // return response()->streamDownload(function () use ($contents) {
    //     echo $contents;
    // }, $filename);

    return Response::stream(function () use($contents) {
        echo $contents;
    }, 200, $headers)->send();
});

Route::get('/logs/{application}', function (Application $application) {
    return view('logs-list', ['application' => $application]);
})->middleware(['auth'])->name('logs');

require __DIR__.'/auth.php';
