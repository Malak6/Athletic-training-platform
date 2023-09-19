<?php

namespace App\Http\Controllers;


use App\Traits\GenTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests , GenTraits;

    public function addCup()
    {
        $user = auth('sanctum')->user();
        $daily_need =$user->dailyValue;
        $daily_intake = $daily_need->daily_water_intake;
        $daily_need->daily_water_intake =  $daily_intake +1 ;
        $daily_need->save(); 
        return $this->success("", 200 , "");
    }

    public function removeCup(){
        $user = auth('sanctum')->user();
        $daily_need =$user->dailyValue;
        $daily_intake = $daily_need->daily_water_intake;
        if ( $daily_intake > 0 ){
            $daily_need->daily_water_intake =  $daily_intake -1 ;
            $daily_need->save(); 
        }
        return $this->success("", 200 , "");
    }
   
    public function searchFood(Request $request){

        $rules = [
         'name'   => 'required | string' 
        ];
        $validator = Validator::make($request->all() , $rules );
        if ($validator->fails()) {
            return $this->error(["errors" => $validator->errors()] , 500 ,  "There is something wrong.");
        }
        $foodName = $request->input('name');
        $apiURL = 'https://trackapi.nutritionix.com/v2/search/instant?query=' . $foodName;

        $headers = [
            'x-app-id' => 'your-x-app-id',
            'x-app-key' => 'your-x-app-key' , 
            'x-remote-user-id' => 0 ,
        ];
      
        $response = Http::withHeaders($headers)->get($apiURL);
        if ($response->ok()) {
            $data = $response->json();
            // dd ($data['common']);
            return $this->success(["Data" => $data['common']], 200 , "");
        }
        else{
            return $this->error("" , 500 ,  "There is something wrong.");
        }
    }

    public function getFoodInfo(Request $request){
        $rules = [
            'name'   => 'required | string' 
           ];
           $validator = Validator::make($request->all() , $rules );
   
           if ($validator->fails()) {
               return $this->error(["errors" => $validator->errors()], 500 , "There is no name");
           }
        
        $foodName = $request->input('name');
        $apiURL = 'https://trackapi.nutritionix.com/v2/natural/nutrients';

        $headers = [
            'x-app-id' => 'your-x-app-id',
            'x-app-key' => 'your-x-app-key' , 
            'x-remote-user-id' => 0 ,
        ];

        $postInput = [
            "query" => $foodName
        ];
  
        $response = Http::withHeaders($headers)->post($apiURL , $postInput);
        $data = $response->json();
        // dd( $data['foods'][0] );
        return $this->success(["Data" => $data['foods']], 200 , "");
        
    }

    public function addFood(Request $request){
        $rules = [
            'serving_weight_grams'          => 'required' ,
            'grams'                         => 'required' ,
            'quantity'                      => 'required' ,
            'calorie'                       => 'required' ,
            'carb'                          => 'required' ,
            'protein'                       => 'required' ,
            'fat'                           => 'required' ,
            'fibers'                        => 'required' ,
        ];

        $validator = Validator::make($request->all() , $rules );

        if ($validator->fails()) {
            return $this->error(["errors" => $validator->errors()], 500 , "");
        }

        $food_grams =$request->input('serving_weight_grams'); //food grams 
        $input_grams= $request->input('grams'); // input grams
        $input_quantity= $request->input('quantity');
        $input_calorie =$request->input('calorie');
        $input_carb=$request->input('carb');
        $input_protein=$request->input('protein');
        $input_fat=$request->input('fat');
        $input_fibers=$request->input('fibers');
        
        $user = auth('sanctum')->user();
        $daily_need =$user->dailyValue;
        $daily_calorie_intake = $daily_need->daily_calorie_intake;
        $daily_carb_intake = $daily_need->daily_carb_intake;
        $daily_protein_intake = $daily_need->daily_protein_intake;
        $daily_fat_intake = $daily_need->daily_fat_intake;
        $daily_fibers_intake= $daily_need->daily_fibers_intake;
        $daily_need->daily_calorie_intake =   $daily_calorie_intake + ((($input_calorie * $input_grams)) / $food_grams)*$input_quantity ;
        $daily_need->daily_carb_intake =  $daily_carb_intake +   ((($input_carb  * $input_grams)) / $food_grams ) *$input_quantity ;
        $daily_need->daily_protein_intake =  $daily_protein_intake +  ((( $input_protein  * $input_grams)) / $food_grams ) *$input_quantity ;
        $daily_need->daily_fat_intake =  $daily_fat_intake + ( (( $input_fat  * $input_grams)) / $food_grams) *$input_quantity   ;
        if($input_fibers != null){
            $daily_need->daily_fibers_intake =  $daily_fibers_intake + ( (( $input_fibers   * $input_grams )) / $food_grams) *$input_quantity;
        }
        $daily_need->save();   
        return $this->success("", 200 , "");
    }

    public function viewDailyValue()
    {
        $user = auth('sanctum')->user();
        $daily_need =$user->dailyValue;
        $daily_carb_intake = $daily_need->daily_carb_intake;
        $daily_carb_need = $daily_need->daily_carb_need;
        $carb_percent = round ( ( ( 0.55 * $daily_carb_intake ) / $daily_carb_need) * 100 );
        $daily_fat_intake = $daily_need->daily_fat_intake;
        $daily_fat_need = $daily_need->daily_fat_need;
        $fat_percent = round ( ( ( 0.25 * $daily_fat_intake ) / $daily_fat_need) * 100 );
        $daily_protein_intake = $daily_need->daily_protein_intake;
        $daily_protein_need = $daily_need->daily_protein_need;
        $protein_percent = round ( ( ( 0.20 * $daily_protein_intake ) / $daily_protein_need) * 100 );

        $daily_value_percentage = [
            "carb percent"      => $carb_percent ,
            "fat percent"       => $fat_percent  ,
            "protein percent"   => $protein_percent
        ];

        return $this->success([
            "daily value percentage"  => $daily_value_percentage ,
            "daily value"             => $daily_need
        ]
        , 200 , "");        
    }

    public function sendNotification()
    {
        $user = auth('sanctum')->user();
        $fcmtoken = "your-token";
        $response = request('POST', 'https://fcm.googleapis.com/fcm/send', [
            'headers' => [
                'Authorization' => 'key=' . $fcmtoken,
                'Content-type' => 'application/json; charset=UTF-8',
            ],
            'json' => [
                'to' => '/topics/' . $user->id ,
                'notification' => [
                    'title' => "Stay Hydrated!",
                    'body' => "It is important to drink enough water. Take a break and have a glass of water now",
                    'sound' => 'default',
                ],
                'android' => [
                    'priority' => 'HIGH',
                    'notification' => [
                        'notification_priority' => 'PRIORITY_MAX',
                        'sound' => 'default',
                        'default_sound' => true,
                        'default_vibrate_timings' => true,
                    ],
                ],
            ],    
        ]);
        return $this->success(["response" => $response], 200 , "");
    
    }
} 