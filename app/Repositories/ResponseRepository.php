<?php

namespace App\Repositories;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ResponseRepository
{
    /**
     * ResponseError
     *
     * Returns the errors data if there is any error
     *
     * @param object $errors
     * @return Response
     */
    public static function ResponseError($errors, $message = 'Data is invalid', $status_code = JsonResponse::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'status' => 404,
            'message' => $message,
            'errors' => $errors,
            'data' => null,
        ], $status_code);
    }

    /**
     * ResponseSuccess
     *
     * Returns the success data and message if there is any error
     *
     * @param object $data
     * @param string $message
     * @param integer $status_code
     * @return Response
     */
    public static function ResponseSuccess($data, $message = "Successfull", $status_code = JsonResponse::HTTP_OK)
    {
        return response()->json([
            'status' => 200,
            'message' => $message,
            'errors' => null,
            'data' => $data,
        ], $status_code);
    }
}
