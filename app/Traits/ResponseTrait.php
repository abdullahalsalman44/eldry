<?php

namespace App\Traits;

trait ResponseTrait
{
    public function paginateSuccessResponse($data, $message = 'success', $code = 200)
    {
        $meta = [
            'total' => $data->total(),
            'count' => $data->count(),
            'per_page' => $data->perPage(),
            'current_page' => $data->currentPage(),
            'total_pages' => $data->lastPage(),
        ];
        return response()->json(['status' => true, 'data' => $data, 'meta' => $meta, 'message' => $message], $code);
    }

    public function paginateErrorResponse($data, $message = 'success', $code = 200)
    {
        $meta = [
            'total' => $data->total(),
            'count' => $data->count(),
            'per_page' => $data->perPage(),
            'current_page' => $data->currentPage(),
            'total_pages' => $data->lastPage(),
        ];
        return response()->json(['status' => false, 'data' => $data, 'meta' => $meta, 'message' => $message], $code);
    }

    public function successResponse($data, $message = 'success', $code = 200)
    {
        return response()->json(['status' => true, 'data' => $data, 'message' => $message], $code);
    }

    public function errorResponse($data, $message = 'success', $code = 200)
    {
        return response()->json(['status' => false, 'data' => $data, 'message' => $message], $code);
    }

    public function messageSuccessResponse($message = 'success', $code = 200)
    {
        return response()->json(['status' => true, 'message' => $message], $code);
    }

    public function messageErrorResponse($message = 'success', $code = 5000)
    {
        return response()->json(['status' => false, 'message' => $message], $code);
    }
}
