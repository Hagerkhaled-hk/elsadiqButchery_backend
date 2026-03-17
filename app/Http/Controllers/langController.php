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
        "error"=>__("responses.lang-fail")

    ],401);

    App::setLocale($lang);
    Session::put("locale",$lang);
         return response()->json(
    [
        "success"=>true,
        "message"=>__("responses.lang-switch")

    ],200);

    }
    catch(\Exception $e)
   {

   return response()->json(
    [
        "success"=>false,
        "error"=>__("responses.server-error-message").$e->getMessage()

    ],500);
}
}
}