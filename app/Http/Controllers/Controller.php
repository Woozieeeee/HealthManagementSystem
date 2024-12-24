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
     * Handle success responses.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data = null, $message = 'Operation successful', $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Handle error responses.
     *
     * @param  string  $message
     * @param  int  $status
     * @param  mixed  $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message = 'Operation failed', $status = 400, $data = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Redirect back with success message.
     *
     * @param  string  $message
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function backWithSuccess($message)
    {
        return redirect()->back()->with('success', $message);
    }

    /**
     * Redirect back with error message.
     *
     * @param  string  $message
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function backWithError($message)
    {
        return redirect()->back()->with('error', $message);
    }
}