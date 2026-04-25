<?php

namespace App\Http\Controllers;

use App\Http\Requests\authRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(authRequest $authRequest)
    {
        try
        {
            $validated=$authRequest->validated();


          $user = User::create([
            "name"=>$validated["name"],
            "email"=>$validated["email"],
            "password"=>Hash::make($validated["password"]),
            "phone"=>$validated["phone"],
          ]);

         event(new Registered($user));
                return response()->json(
    [
        "success"=>true,
        "message"=>__("responses.register-success")

    ],200);



        }catch(\Exception $e)
        {
    return response()->json(
    [
        "success"=>false,
        "error"=>__("responses.server-error-message").$e->getMessage()

    ],500);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function login(Request $request)
    {
        $credentials=$request->validate([
            "email"=>"required|exists:users,email",
            "password"=>"required",
        ]);
    try
    {
        $remember=$request->boolean("remember");
        if(Auth::attempt($credentials,$remember))
         {
        $request->session()->regenerate();
          return response()->json(
    [
        "success"=>true,
        "data"=>Auth::user(),
        "message"=>__("responses.login-success")

    ],200);
}

  return response()->json(
    [
        "success"=>false,
        "error"=>__("responses.login-error")

    ],401);


    }
    catch(\Exception $e){
        return response()->json(
    [
        "success"=>false,
        "error"=>__("responses.server-error-message").$e->getMessage()

    ],500);
    }

    }
    public function logout(Request $request)
    {

    try
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

      return response()->json(
    [
        "success"=>true,
        "message"=>__("responses.logout-success")

    ],200);


    }
    catch(\Exception $e){
        return response()->json(
    [
        "success"=>false,
        "error"=>__("responses.server-error-message").$e->getMessage()

    ],500);
    }

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try
        {

            return "show";
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}