<?php

use App\Jobs\PushNotificationJob;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Kutia\Larafirebase\Facades\Larafirebase;

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

//    $deviceTokens = User::whereDay('birthday', now()->format('d'))
//        ->whereMonth('birthday', now()->format('m'))
//        ->pluck('device_token')
//        ->toArray();
    PushNotificationJob::dispatch('sendBatchNotification', [
        '7e3e3325ac53a2125cf267fed358fd19',
        [
            'topicName' => '/topics/test',
            'title' => 'Chúc mứng sinh nhật',
            'body' => 'Chúc bạn sinh nhật vui vẻ',
            'image' => 'https://picsum.photos/536/354',
        ],
    ]);
});
Route::get('2',function(){
    Larafirebase::withTitle('Test Title')->withBody('Test body')->sendNotification('d0508ff948131aea4a151cc2d532cd3ddd2b80ef5016ef7f87d2b5df4d6d629a');
});
