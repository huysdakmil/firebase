<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function send(Request $request)
    {
        return $this->sendNotification('d0508ff948131aea4a151cc2d532cd3ddd2b80ef5016ef7f87d2b5df4d6d629a', array(
            "title" => "Sample Message",
            "body" => "This is Test message body"
        ));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function sendNotification($device_token, $message)
    {
        $SERVER_API_KEY = 'AAAAeFNUr_c:APA91bHpOxvq56UoC6i7yAWyPZcz769vKgyM4kVTk5FkbaXUy1jumZ-hZKkqWbys29MNP8q21kNM9_DeFzzsCwytc_3eZLacR2dASViNrCOeMlUv4vpzga1_PzfrqA6hCOxw1QlTI_88';

        // payload data, it will vary according to requirement
        $data = [
            "to" => $device_token, // for single device id
            "data" => $message
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }
}
