<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Mail\NewMail;
use App\Models\Coach;
use App\Models\Player;
use App\Models\Program;
use App\Mail\RespondMail;
use App\Traits\GenTraits;
use Illuminate\Http\Request;
use App\Models\Complaintcoach;
use App\Models\ProgramRequest;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;


class CoachController extends Controller
{
    use GenTraits;
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $coach = Coach::where('email', $request->email)->first();
        if (! $coach || ! Hash::check($request->password, $coach->password)) {
            return $this->error( "", 500 , 'The provided credentials are incorrect.');
        }

        $token = $coach->createToken('coach')->plainTextToken;
        return $this->success( ['access_token' => $token], 200 , "");
    }


    public function searchByName(Request $request){

        $validator = Validator::make($request->all() ,[
            'name' => "required"
        ]);

        if ($validator->fails()) {
            return $this->error( ["error" => $validator->errors()], 500 , "");
        }
        $name = $request->input('name');
        $coaches = Coach::where([
            ['name' ,'LIKE', '%'.$name.'%'],
            /**
             * If the coach account is freez it will not show in search resulte
             */
            ['is_freez' , '=' , false],
            ['is_active' , '=' , true]
            ])->get();
 
        return $this->success( ["Coaches" => $coaches], 200 , "");
            
    }

    public function viewTopRatedCoaches(){

        $coaches = Coach::where(function ($query) {
            $query->where('rate', '=', 5)
                  ->orWhere('rate', '=', 4);
        })->where([
            ['is_freez', '=', false],
            ['is_active', '=', true]
        ])->orderBy('name')->get();

        return $this->success( ["Coaches" => $coaches], 200 , "");
    }


    public function viewAllCoaches(){

        $coaches = Coach::where([
            ['is_freez' , '=' , false],
            ['is_active' , '=' , true]
        ])->get();

        return $this->success( ["Coaches" => $coaches], 200 , "");
    }



    public function show($id)
    {
        $user = Coach::findOrFail($id);
        return $this->success( ["Coach" =>  $user ], 200 , "");

    }


    public function update(Request $request, $id)
    {
        $coach = Coach::find($id);
        // $user = auth('sanctum')->user();

        if (!$coach) {
            return $this->error( "", 500 , 'User not found.');
        }

        if ($request->input('weight')){
            $coach->weight = $request->input('weight');
            $coach->save();
        }
        if ($request->input('height')){
            $coach->height = $request->input('height');
            $coach->save();
        }
        if ($request->input('phone_number')){
            $coach->phone_number = $request->input('phone_number');
            $coach->save();
        }
        if ($request->input('password')){
            $coach->password = Hash::make($request->input('password'));
            $coach->save();
        }
        return $this->success( ["Coach" => $coach], 200 , "Coach updated successfully.");

    }

    public function updateStatus(Request $request)
    {
        $coach = auth('sanctum')->user();

        if (!$coach) {
            return $this->error( "", 404 , 'Coach not found.');
        }

        $coach->is_active = !$coach->is_active;
        $coach->save();

        $message = $coach->is_active ? 'Coach is now active.' : 'Coach is now inactive.';
        return $this->success( "", 200 , $message);
    }

    public function viewProgramRequest(){

        $user = auth('sanctum')->user();
        $requests = ProgramRequest::where('coaches_id' , '=' , $user->id)->get();
        if($requests){
            return $this->success( ["Requests" => $requests ], 200 , "");
        }
        else{
            return $this->success("", 200 , "you have no request yet");
        }
    }

    public function rejectProgramRequest(){
        $header = getallheaders();
        $id     = $header['id'];
        $programrequest = ProgramRequest::findOrFail($id);

        $player_id= $programrequest->players_id;
        $player = Player::findOrFail($player_id);

        $email = $player->email;
        
        $player->wallet_balance += $programrequest->payment;
        
        $player->save();

        $programrequest->payment =0;
        $programrequest->save();
       
        $programrequest->delete();
        
        $m = "\n Your program request has been rejected.";
        Mail::to($email)->send(new RespondMail($m));

        return $this->success("", 200 , 'Rejected');
        
    }

    public function acceptProgramRequest(Request $request){
        $header = getallheaders();
        $id     = $header['id'];
        $programrequest = ProgramRequest::findOrFail($id);

        //  to send email 
        $player_id= $programrequest->players_id;
        $player = Player::findOrFail($player_id);
        $email = $player->email;

        $programrequest->is_accepted = true;
        $programrequest->save();

        // to send email
        $m = "\n Your program request has been accepted.";
        Mail::to($email)->send(new RespondMail($m));

        return $this->success("", 200 , 'Accepted');

    }

    public function createProgram(Request $request){
        $header = getallheaders();
        $id     = $header['id'];
        $programrequest = ProgramRequest::findOrFail($id);

        if($programrequest->is_accepted == 1){

        $coach = Coach::findOrFail($programrequest->coaches_id);
        $coach_id = $coach->id;
        $coach = Coach::findOrFail($coach_id);
        $coach->wallet_balance += $programrequest->payment;
        $coach->save();
        $programrequest->payment = 0;
        $programrequest->save();
    
        $currentDate = Carbon::now();
        $endDate = $currentDate->addDays(30);

        $program = Program::create([
            'players_id'  => $programrequest->players_id ,
            'coaches_id'  => $programrequest->coaches_id ,
            'first_day'   => $request->input('first_day')  ,
            'second_day'  => $request->input('second_day')  ,
            'third_day'   => $request->input('third_day')  ,
            'fourth_day'  => $request->input('fourth_day')  , 
            'fifth_day'   => $request->input('fifth_day')  ,
            'sixth_day'   => $request->input('sixth_day')  ,  
            'seventh_day' => $request->input('seventh_day')  ,
            'notes'       => $request->input('notes')  ,
            'end_date'    => $endDate, 
        ]);

        $coach->wallet_balance = $coach->wallet_balance + $programrequest->payment;
        $coach->save();
        return $this->success("", 200 , 'The program has been sent.');
        }
            
    }

    public function viewAllSubscriber()
    {
        $coach_id = auth('sanctum')->user()->id;
        $players = DB::table('players')
        ->join('programs', 'players.id', '=', 'programs.players_id')
        ->where('programs.coaches_id', $coach_id)
        // ->select('players.name')
        ->get();

        return $this->success(["Player and Program" => $players], 200 ,"");

    }


    public function store(Request $request)
    {
        $coach = auth('sanctum')->user();
        $complaint =$request->input('text');
        $coach->complaints()->create([
            "text" => $complaint
        ]);
        return $this->success("", 200 , 'Complaint saved successfully');
    }


}
