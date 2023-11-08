<?php

namespace App\Traits;

trait RespondsWithHttpStatus {
    protected function success($message, $data = [], $status = 200)
    {
        return response([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    protected function failure ($message, $data = [], $status = 422) 
    {
        return response([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}