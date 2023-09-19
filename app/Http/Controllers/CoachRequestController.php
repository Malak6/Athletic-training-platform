<?php

namespace App\Http\Controllers;


use App\Traits\GenTraits;
use App\Mail\NewMail;
use App\Models\EmailVer;
use App\Models\CoachRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CoachRequestController extends Controller
{
    use GenTraits;
    public function coachRegister(Request $request)
    {
        $rules = [
            'name'                      => 'required | string' ,
            'gender'                    => 'required' ,
            'height'                    => 'required' ,
            'gender'                    => 'required' ,
            'birth_date'                => 'required | date',
            'password'                  => 'required' ,
            'experience_certificate'    => 'required' ,
            'email'                     => 'required' ,
            'confirm_password'          => 'required' ,
        ];
       
        $validator = Validator::make($request->all() , $rules );
        
        if ($validator->fails()) {
            return $this->error( ["errors" => $validator->errors()], 500 , "");
        }
        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');

        if(!( $password === $confirm_password)){
            return $this->error( "", 500 , "password did not match");
        }
        $email = $request->input('email') ;
        $coachRequest = CoachRequest::create([
            'name'                      =>  $request->input('name'),
            'gender'                    =>  $request->input('gender'),
            'weight'                    =>  $request->input('weight'),
            'height'                    =>  $request->input('height'),   
            'birth_date'                =>  $request->input('birth_date'),
            'password'                  =>  Hash::make($request->input('password')) ,
            'email'                     =>  $request->input('email') ,
            'phone_number'              =>  $request->input('phone_number'),
            'is_accepted'               =>  false,
            'is_verified'               =>  false,
            'experience_certificate'    =>  $request->input('experience_certificate') ,
        ]);

        $code = rand(1000 , 9999);
        Mail::to($email)->send(new NewMail($code));
        $user_type = $request->input('user_type');
        $coachRequest->email()->create([
           'email' => $email,
           'vefrification_code' => $code,
           'is_confirmed' =>false ,
        ]);

        return $this->success( "", 200 ,"The request send to the admins");
    }
}
