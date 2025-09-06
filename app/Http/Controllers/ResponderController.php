<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Responder;

class ResponderController extends Controller
{
    public function me(Request $request)
    {
        $responder = $request->user(); 

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $responder->id,
                'email' => $responder->email,
            ]
        ]);
    }
}
