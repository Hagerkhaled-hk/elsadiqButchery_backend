<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class langController extends Controller
{

public function setlocale($lang)
{
    try
    {
    if(!\in_array($lang,["en","ar"]))
        return response()->json(
    [
        "success"=>false,
        "error"=>_("responses.lang-fail")

    ],401);

    App::setLocale($lang);
    Session::put("locale",$lang);
         return response()->json(
    [
        "success"=>true,
        "message"=>_("responses.lang-switch")

    ],200);

    }
    catch(\Exception $e)
   {

   return response()->json(
    [
        "success"=>false,
        "error"=>_("responses.server-error-message").$e->getMessage()

    ],500);
}
}
}