<?php

namespace App\Http\Controllers;


use App\Traits\GenTraits;
use App\Mail\NewMail;
use App\Models\Player;
use App\Models\EmailVer;
use App\Models\CoachRequest;
use Illuminate\Http\Request;
use App\Models\PhysicalActivity;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\EmailVerController;
use Illuminate\Support\Carbon;

class EmailVerController extends Controller
{
    use GenTraits;
    public function checkCode(Request $request)
    {
        $validator = Validator::make($request->all() ,[
            'email' => "required"
        ]);
        if ($validator->fails()) {
            return $this->error(["error" => $validator->errors()] , 500 ,  "");
        }

        $email=$request->input('email');
        $record=EmailVer::where('email' , '=' , $email)->first();
        
        if($record){
            $validator1 = Validator::make($request->all() ,[
                'confirm_code' => "required | integer"
            ]);
            if ($validator1->fails()) {
                return $this->error(["error" => $validator->errors()] , 500 ,  "");
            }

            $confirm_code=$request->input('confirm_code');
            $xCode=$record->vefrification_code;
            
            if($confirm_code === $xCode){
                $record->update([
                    'is_confirmed' => true
                ]);

                $user = $record->verable;

                $user->is_verified = true;
                $user->save();

                if($user->roles_id == 1){

                    $weight = $user->weight;
                    $height = $user->height;

                    $activity_id =$user->physical_activities_id;
                    $activity_factor = PhysicalActivity::find($activity_id)->factor;
                    $daily_water_need=  round( ($weight * $activity_factor) / 250 );

                    $age = Carbon::parse($request->input('birth_date'))->age;
                    $daily_calorie_need = round ( ((10 * $weight) + (6.25 * $height) - (5 * $age) - 161) * ($activity_factor / 25));

                        // all in grams
                    $daily_carb_need =  round(( ($daily_calorie_need * 0.55) *225 ) / 900  ); 
                    $daily_protein_need =  round (( ($daily_calorie_need * 0.20) * 50 ) / 200 );
                    $daily_fat_need =  round( (($daily_calorie_need * 0.25) * 44 ) / 400 );
                    $daily_fibers_need = round($daily_calorie_need / 71);

                    $user->dailyValue()->create([
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

                    $token = $user->createToken('player')->plainTextToken;

                    $record->delete();
                
                    return $this->success(["Token" => $token], 200 , "");
                }
                // as coach
                $record->delete();
            }
            else {
                return $this->error("", 500 , "Unfortunately your code is wrong.");
            }
        }
    }
}
