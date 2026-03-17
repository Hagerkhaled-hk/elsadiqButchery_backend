<?php

namespace App\Http\Controllers;

use App\Http\Requests\authRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
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

         event(new Registered($user) );
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
