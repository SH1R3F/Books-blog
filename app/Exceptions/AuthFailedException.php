<?php

namespace App\Exceptions;

use Exception;

class AuthFailedException extends Exception
{

    public function render()
    {
        return response()->json([
          'message' => 'البيانات التي أدخلتها لا تتطابق مع سجلاتنا.'
        ], 422);
    }

}
