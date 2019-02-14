<?php
namespace App\Admin;

class ResponseCreator
{
    public static function responseCreate($statusCode = 200, $statusText, $body= [], $extData=null)
    {
        $result = [
            'timestamp' => Date('U'),
            'statusCode' => $statusCode,
            'statusText' => $statusText,
            'body' => $body
        ];

        if ($extData) {
            $result = array_merge($result, $extData);
        }

        echo json_encode($result);
        die();
    }
}
