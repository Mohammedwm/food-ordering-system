
<?php

use App\Models\Setting;
use Twilio\Rest\Client;
use Google\Client as GoogleClient;

if (!function_exists('apiSuccess')) {
    function apiSuccess($data = null, $message = null, $status = 200)
    {
        return response()->json(
            [
                'success' => true,
                'data' => $data,
                'status' => $status,
                'message' => $message,
            ],
            $status
        )->header('Content-Type', 'application/json');
    }
}

if (!function_exists('apiError')) {
    function apiError($message = 'error', $status = 422, $data = null)
    {
        return response()->json(
            [
                'success' => false,
                'data' => $data,
                'status' => $status,
                'message' => $message,
            ],
            $status
        )->header('Content-Type', 'application/json');
    }
}
if (!function_exists('errorAllStr')) {
    function errorAllStr($error_array = [])
    {
        return implode("-", $error_array);

    }
}
