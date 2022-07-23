<?php

use App\Jobs\PushNotificationJob;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Kutia\Larafirebase\Facades\Larafirebase;
use Kreait\Firebase\Messaging\CloudMessage;


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
    if(request('name')?:false){
        dd('ok2');
    }
    dd('ok');
//server key : 'AAAAeFNUr_c:APA91bHpOxvq56UoC6i7yAWyPZcz769vKgyM4kVTk5FkbaXUy1jumZ-hZKkqWbys29MNP8q21kNM9_DeFzzsCwytc_3eZLacR2dASViNrCOeMlUv4vpzga1_PzfrqA6hCOxw1QlTI_88'
//    $deviceTokens = User::whereDay('birthday', now()->format('d'))
//        ->whereMonth('birthday', now()->format('m'))
//        ->pluck('device_token')
//        ->toArray();
    PushNotificationJob::dispatch('sendBatchNotification', [
        'd0508ff948131aea4a151cc2d532cd3ddd2b80ef5016ef7f87d2b5df4d6d629a',
//        'd0508ff948131aea4a151cc2d532cd3ddd2b80ef5016ef7f87d2b5df4d6d629a',
    //team id: 336TBZ25TJ
        [
            'topicName' => '336TBZ25TJ',
            'title' => 'Chúc mứng sinh nhật',
            'body' => 'Chúc bạn sinh nhật vui vẻ',
            'image' => 'https://picsum.photos/536/354',
        ],
    ]);
});
Route::get('2',function(){
    Larafirebase::withTitle('Test Title')->withBody('Test body')->sendNotification('d0508ff948131aea4a151cc2d532cd3ddd2b80ef5016ef7f87d2b5df4d6d629a');
});
Route::get('3', function () {
    /* We are using the sandbox version of the APNS for development. For production
    environments, change this to ssl://gateway.push.apple.com:2195 */
    $apnsServer = 'ssl://gateway.sandbox.push.apple.com:2195';
    /* Make sure this is set to the password that you set for your private key
    when you exported it to the .pem file using openssl on your OS X */
    $privateKeyPassword = '1234';
    /* Put your own message here if you want to */
    $message = 'Welcome to iOS 7 Push Notifications';
    /* Pur your device token here */
    $deviceToken =
        'd0508ff948131aea4a151cc2d532cd3ddd2b80ef5016ef7f87d2b5df4d6d629a';
    /* Replace this with the name of the file that you have placed by your PHP
    script file, containing your private key and certificate that you generated
    earlier */
    $pushCertAndKeyPemFile = public_path('cer/pushcert.pem');
    $stream = stream_context_create();
    stream_context_set_option($stream,
        'ssl',
        'passphrase',
        $privateKeyPassword);
    stream_context_set_option($stream,
        'ssl',
        'local_cert',
        $pushCertAndKeyPemFile);
    $connectionTimeout = 20;
    $connectionType = STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT;
    $connection = stream_socket_client($apnsServer,
        $errorNumber,
        $errorString,
        $connectionTimeout,
        $connectionType,
        $stream);
    if (!$connection) {
        echo "Failed to connect to the APNS server. Error no = $errorNumber<br/>";
        exit;
    } else {
        echo "Successfully connected to the APNS. Processing...</br>";
    }
    $messageBody['aps'] = array('alert' => $message,
        'sound' => 'default',
        'badge' => 2,
    );
    $payload = json_encode($messageBody);
    $notification = chr(0) .
        pack('n', 32) .
        pack('H*', $deviceToken) .
        pack('n', strlen($payload)) .
        $payload;
    $wroteSuccessfully = fwrite($connection, $notification, strlen($notification));
    if (!$wroteSuccessfully) {
        echo "Could not send the message<br/>";
    } else {
        echo "Successfully sent the message<br/>";
    }
    fclose($connection);
});
Route::get('4',function(){

    $deviceToken = 'd0508ff948131aea4a151cc2d532cd3ddd2b80ef5016ef7f87d2b5df4d6d629a';

    $messaging = CloudMessage::withTarget('token', $deviceToken)
        ->withNotification($notification) // optional
        ->withData($data) // optional
    ;

    $message = CloudMessage::fromArray([
        'token' => $deviceToken,
        'notification' => [/* Notification data as array */], // optional
        'data' => [/* data array */], // optional
    ]);

    $messaging->send($message);
});
//Key ID: S34KP28HYS
//team ID: 336TBZ25TJ
