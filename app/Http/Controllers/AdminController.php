<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\Role;
use App\Models\Admin;
use App\Models\Coach;
use App\Models\Player;
use App\Mail\RespondMail;
use App\Models\Complaint;
use App\Traits\GenTraits;
use App\Models\CoachRequest;
use Illuminate\Http\Request;
use App\Models\Complaintcoach;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    use GenTraits;
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (! $admin || !($request->password == $admin->password)) {
            return $this->error( "", 500 , 'The provided credentials are incorrect.');
        }

        $token = $admin->createToken('admin')->plainTextToken;
        return $this->success( ['access_token' => $token], 200 , "");
    }
    public function viewAllJoiningRequest(){
        $coaches = CoachRequest::all();
        return $coaches;

    }

    public function acceptRequest(Request $request)
    {
        $validator = Validator::make($request->all() ,[
            'email' => "required"   
        ]);

        if ($validator->fails()) {
            return $this->error(["error" =>  $validator->errors() ], 500 ,  "There is something wrong.");
        }
        $email = $request->input('email');
        $coach = CoachRequest::where('email' , '=' , $email)->first();

        if($coach && $coach->is_verified == true){
            $daily_water_need =  round( ((($coach->weight * 2.20462) *0.5) *29.5735 ) / 250 );

            $age = Carbon::parse($coach->birth_date)->age;
            $daily_calorie_need = round ( ((10 * $coach->weight) + (6.25 * $coach->height) - (5 * $age) - 161) );

            $registeredCoach = Coach::create([
                'name'                    => $coach->name ,
                'roles_id'                => 2,
                'gender'                  => $coach->gender,
                'weight'                  => $coach->weight,
                'height'                  => $coach->height,
                'birth_date'              => $coach->birth_date,
                'password'                => $coach->password,
                'email'                   => $coach->email,
                'phone_number'            => $coach->phone_number,
                'is_freez'                => false,
                'is_active'               => true,
                'rate'                    => 5,
                'wallet_balance'          => 15,
                'experience_certificate'  => $coach->experience_certificate,
            ]);

             // all in grams
             $daily_carb_need =  round(( ($daily_calorie_need * 0.55) *225 ) / 900  );
             $daily_protein_need =  round (( ($daily_calorie_need * 0.20) * 50 ) / 200 );
             $daily_fat_need =  round( (($daily_calorie_need * 0.25) * 44 ) / 400 );
             $daily_fibers_need = round($daily_calorie_need / 71);

            $registeredCoach->dailyValue()->create([
                'daily_water_need'      => $daily_water_need,
                'daily_water_intake'    => 0,
                'daily_calorie_need'    => $daily_calorie_need,
                'daily_calorie_intake'  => 0,
                'daily_carb_need'       => $daily_carb_need,
                'daily_carb_intake'     => 0,
                'daily_protein_need'    => $daily_protein_need,
                'daily_protein_intake'  => 0,
                'daily_fat_need'        => $daily_fat_need,
                'daily_fat_intake'      => 0,
                'daily_fibers_need'     => $daily_fibers_need,
                'daily_fibers_intake'   => 0,
                ]);

            $coach->update([
                'is_accepted' => true
            ]);

            $m = "\n Your joining request has been approved.";
            Mail::to($email)->send(new RespondMail($m));

            $coach->delete();

            $token =$registeredCoach->createToken('coach')->plainTextToken;

            return $this->success(["Token"   => $token] , 200 , "You Are now Registered.");
           
        }
        else{
            return $this->error("" , 500 ,  "There is something wrong (in email or verified).");
        }
    }

    public function rejectRequest(Request $request){

        $validator = Validator::make($request->all() ,[
            'email' => "required"
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        $email = $request->input('email');
        $coach = CoachRequest::where('email' , '=' , $email)->first();

        if($coach){
            $coach->update([
                'is_accepted' => false
            ]);

            $m = "\n Sorry, your request has been rejected, it seems that there is a problem verifying your certificates.";
            Mail::to($email)->send(new RespondMail($m));

            $coach->delete();

            return $this->success("" , 200 , "Your request has been rejected.");
        }
        else{
            return $this->error("" , 500 , "There is something wrong.");
        }

    }

    public function freezingCoach(Request $request){
        $header = getallheaders();
        $id     = $header['id'];
        $coach  = Coach::find($id);
        if($coach->is_freez == false){
            $coach->update([
                'is_freez' => true
            ]);
            return $this->success("" , 200 , "The account has been freezed");
        }
        else if ($coach->is_freez == true){
            $coach->update([
                'is_freez' => false
            ]);
            return $this->success("" , 200 , "The account has been unfreezed");
        }
        else {
            return $this->error("" , 500 , "SOME THING WRONG");
        }
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function freezingPlayer(){
        $header = getallheaders();
        $id     = $header['id'];
        $player = Player::find($id);
        if($player->is_freez == false){
            $player->update([
                'is_freez' => true
            ]);

            return $this->success("" , 200 , "The account has been freezed");
        }

        else if ($player->is_freez == true){
            $player->update([
                'is_freez' => false
            ]);
    
            return $this->success("" , 200 , "The account has been unfreezed");
        }

        else {
            return $this->error("" , 500 , "SOME THING WRONG");
        }
    }



    public function showcomplaintid($id)
    {
        $complaint = Complaint::find($id);
        if($complaint){
            return $this->success(['complaint' => $complaint] , 200 , "");
        }
        else{
            return $this->error("" , 500 , "No complaint with this id");
        }
    }



    public function showcomplaint()
    {
        $complaints = Complaint::all();
        return $this->success(['complaint' => $complaints] , 200 , "");
    }

///////////////////////////////////////////////////

    public function viewAllCoaches(){
        $role = Role::find(2);
        $coaches =  $role->coaches;
        return $this->success(['Coaches' => $coaches] , 200 , "");
    }

    public function viewAllPlayers(){
        $role = Role::find(1);
        $players =  $role->players;
        return $this->success(['Players' => $players] , 200 , "");
    }


}
