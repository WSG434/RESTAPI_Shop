<?php

function responseOk() : \Illuminate\Http\JsonResponse
{
    return response()->json([
        'status' => 'success'
    ]);
}
