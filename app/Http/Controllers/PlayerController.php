<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Mail\NewMail;
use App\Models\Coach;
use App\Models\Player;
use App\Models\Program;
use App\Models\EmailVer;
use App\Models\Complaint;
use App\Traits\GenTraits;
use App\Models\DailyValue;
use App\Models\CoachRating;
use Illuminate\Http\Request;
use App\Models\ProgramRequest;
use App\Models\PhysicalActivity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\EmailVerController;


class PlayerController extends Controller
{
    use GenTraits;
    public function playerRegister(Request $request)
    {
            $rules = [
                'name'                      => 'required | string' ,
                'physical_activities_id'    => 'required' ,
                'weight'                    => 'required' ,
                'height'                    => 'required' ,
                'gender'                    => 'required' ,
                'phone_number'              => 'required' ,
                'birth_date'                => 'required | date',
                'disease'                   => 'nullable' ,
                'password'                  => 'required' ,
                'email'                     => 'required' ,
                'confirm_password'          => 'required'
            ];

            $validator = Validator::make($request->all() , $rules );

            if ($validator->fails()) {
                return $this->error(["errors" => $validator->errors()], 500 , "");
            }
            $password = $request->input('password');
            $confirm_password = $request->input('confirm_password');

            if(!( $password === $confirm_password)){
                return $this->error("", 500 , "password did not match");
            }

            $email = $request->input('email') ;

            $birth_date = $request->input('birth_date');

            $years = Carbon::parse($birth_date)->age;

            $player = Player::create([
                'name'                      =>  $request->input('name'),
                'roles_id'                  => 1,
                'physical_activities_id'    =>  $request->input('physical_activities_id'),
                'weight'                    =>  $request->input('weight'),
                'height'                    =>  $request->input('height'),
                'gender'                    =>  $request->input('gender'),
                'birth_date'                =>   $request->input('birth_date'),
                'phone_number'              =>  $request->input('phone_number'),
                'disease'                   =>  $request->input('disease'),
                'password'                  =>  Hash::make($request->input('password')) ,
                'email'                     =>  $request->input('email') ,
                'wallet_balance'            =>  15,
                'is_freez'                  =>  false,
                'is_verified'               =>  false,
            ]);

            $code = rand(1000 , 9999);
            Mail::to($email)->send(new NewMail($code));
            $user_type = $request->input('user_type');
            $player->email()->create([
               'email' => $email,
               'vefrification_code' => $code,
               'is_confirmed' =>false ,
           ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $player = Player::where('email', $request->email)->first();

        if (! $player||! Hash::check($request->password, $player->password))
        {
            return $this->error("", 500 , 'The provided credentials are incorrect.');
        }

        $token = $player->createToken('player')->plainTextToken;
        return $this->success(["Token" => $token], 200 , "");
    }

    public function findPlayer($id)
    {

        $player =Player::findOrFail($id);
        return $this->success(["Player" => $player], 200 , "");
    }

    public function viewAllProgramRequest()
    {
        $player_id = auth('sanctum')->user()->id;
        $coaches = DB::table('coaches')
        ->join('programs', 'coaches.id', '=', 'programs.coaches_id')
        ->where('programs.players_id', $player_id)
        // ->select('coaches.name')
        ->get();
        return $this->success(["Coaches" =>  $coaches], 200 , "");
    }


    public function updateTrainerRating(Request $request, $id)
    {
        $rating_value = $request->input('rating');
        $trainer = Coach::find($id);

        if ($rating_value < 1 || $rating_value > 5) {
            return $this->error("", 500 , 'Rating value should be between 1 and 5');
        }

        $rating = new CoachRating([
            'trainer_id' => $trainer->id,
            'rating' => $rating_value
        ]);
        $rating->save();
        $ratings = CoachRating::where('trainer_id', $trainer->id)->pluck('rating');
        $average_rating = $ratings->avg();
        $trainer->rate = $average_rating;
        $trainer->save();

        return $this->success("", 200 , 'Trainer rating updated successfully');
    }


    public function show($id)
    {
        $user = Player::findOrFail($id);
        return $this->success(["User" => $user] , 200 , "");

    }
    public function store(Request $request)
    {
        $player = auth('sanctum')->user();
        $complaint =$request->input('text');
        $player->complaints()->create([
            "text" => $complaint
        ]);
        return $this->success("", 200 , 'Complaint saved successfully');
    }


    public function update(Request $request, $id)
    {
        $Player = Player::find($id);

        if (!$Player) {
            return $this->error("", 404 , 'User not found.');
        }
        
        if ($request->input('weight')){
            $Player->weight = $request->input('weight');
            $Player->save();
        }
        if ($request->input('height')){
            $Player->height = $request->input('height');
            $Player->save();
        }
        if ($request->input('phone_number')){
            $Player->phone_number = $request->input('phone_number');
            $Player->save();
        }
        if ($request->input('password')){
            $Player->password = Hash::make($request->input('password'));
            $Player->save();
        }
        return $this->success(['data' => $Player], 200 , 'Player updated successfully');
    }


    public function programRequest(Request $request)
    {
        $player = auth('sanctum')->user();
        $player_id = $player->id;
        $coach_id = $request->input('coach_id');
        $note = $request->input('note');
        $payment = 5 ;

        $currentProgram = Program::where('players_id', $player_id)
                                    ->where('end_date', '>', now())
                                    ->first();

        if ($currentProgram) {
            return $this->error("", 400, "You cannot request another program before the current program ends.");
        }

        if($player->wallet_balance >= 5){
        $player->wallet_balance =$player->wallet_balance -5;
        $player->save();

        $programReqest = ProgramRequest::create([
            'players_id'     => $player_id ,
            'coaches_id'      => $coach_id ,
            'note'          => $note ,
            'payment'       => $payment ,
            'is_accepted'   => false,
        ]);
        return $this->success("", 200 , "your request has been delivered wait for accept or reject");
        }
        else {
            return $this->error("", 404 , "you do not have enough monye");
        }

    }

    public function viewPersonalPrograms()
    {
        $player = auth('sanctum')->user();
        $programs = Program::where("players_id" , "=" ,$player->id )->get();
        return $this->success(["Programs" =>$programs], 200 , "");

    }

}
