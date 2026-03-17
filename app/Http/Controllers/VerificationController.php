<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VerificationController extends Controller
{
public function verify(Request $request ,$id ,$hash){

$user =User::findOrFail($id);
$message='';
if( $this->hash_Not_equals($hash,$user)){
$message='Invalid verification link';
    return  view("verification.failed",compact('message'));
}

if($user->hasVerifiedEmail())
    {
    $message='Email already verified';

    return  view("verification.success",compact('message'));
    }

if($user->markEmailAsVerified())
event(new Verified($user));



    $message='Email verified successfully';
    return  view("verification.success",compact('message'));


}


public function resendExpired(Request $request ){

$request->validate(['email' => 'required|email:rfc,dns', 'password'=>'required']);

$user = User::where("email",$request->email)->first();

if(!$user)
return response()->json(['success'=>false, 'error' => 'user not found'], 404);


if(!Hash::check($request->password,$user->password))
return response()->json(['success'=>false, 'error' => ' password is uncorrect'], 404);


if($user->hasVerifiedEmail() )
return response()->json(['success'=>true,'error' => 'Email already verified'], 400);


$user->sendEmailVerificationNotification();


return response()->json(['success'=>true,'message' => 'Verification link sent'],200);
}


private function hash_Not_equals($hash,$user)
{
return !hash_equals((string)$hash,sha1($user->getEmailForVerification()));
}


}