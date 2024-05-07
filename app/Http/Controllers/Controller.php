<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Send a success response.
     *
     * @param string $message The success message
     * @param mixed  $data    The data to be included in the response
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($message = '', $data = null)
    {
        return response()->json(
            [
                'success' => true,
                'data' => $data,
                'message' => $message,
            ],
            200
        );
    }

    /**
     * Send an error response.
     *
     * @param string $message   The error message
     * @param int    $errorCode The error code
     * @param mixed  $data      The data to be included in the response
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse(
        string $message = '',
        $errorCode = 400,
        $data = null
    ) {
        $response = [
            'success' => false,
            'message' => $message,
            'data' => $data,
        ];

        return $errorCode ? response()->json($response, $errorCode) : response()->json($response);
    }

     /**
      * Send a delete response.
      *
      * @param string $message The message for successful deletion
      *
      * @return \Illuminate\Http\JsonResponse
      */
    public function deleteResponse(
        string $message = ''
    ) {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => [],
        ];

        return response()->json($response, 204);
    }
}
