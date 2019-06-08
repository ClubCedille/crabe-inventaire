<?php

namespace App\Http\Controllers;
use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;


class Controller extends BaseController
{
    /**
     * Application's healthcheck
     *
     * @param  Request  $request
     * @return Response
     */
    public function getHealth(Request $request)
    {
        $code = 200;
        return response()->json(['status' => "healthy"], $code);
    }

}
