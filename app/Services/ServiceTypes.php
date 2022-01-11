<?php 

namespace App\Services;

use Illuminate\Http\Request;
use Validator;
use Exception;
use DateTime;
use Carbon\Carbon;
use Auth;
use Lang;
use Setting;
use App\ServiceType;
use App\Promocode;
use App\Provider;
use App\ProviderService;
use App\Helpers\Helper;
use GuzzleHttp\Client;
use App\PeakHour;
use App\ServicePeakHour;
use Illuminate\Support\Str;

class ServiceTypes{

    public function __construct(){}

    /**
        * Get a validator for a tradepost.
        *
        * @param  array $data
        * @return \Illuminate\Contracts\Validation\Validator
    */
    protected function validator(array $data) {
        $rules = [
            'location'  => 'required',
        ];

        $messages = [
            'location.required' => 'Location Required!',
        ];

        return Validator::make($data,$rules,$messages);
    }

   
    /**
    * get the btc details.        
    * get the currency master data.        
    * get the payment methods master data.
    * @return response with data,system related errors
    */
    public function show() {
        
     
    }    

    /**
        * get all details.
        * @return response with data,system related errors
    */
    public function getAll() {
   
        
    }    

    /**
        * find tradepost.        
        * @param  $id
        * @return response with data,system related errors
    */

    public function find($id) {  
       
    }    
    
    /**
        * insert function
        * checking form field validations
        * @param  $postrequest
        * @return response with success,errors,system related errors
    */ 
    public function create($request) {
        
    } 

    /**
        * update function
        * checking form validations
        * @param  $postrequest
        * @return response with success,errors,system related errors
    */    
    public function update($request,$id) {
   

    } 

    /**
        * delete function.        
        * @param  $id
        * @return response with success,errors,system related errors
    */
    public function delete($id) {
           
    }

    public function calculateFare($request, $cflag=0){

        
        try{
           
            
            $total=$tax_price='';
            $location=$this->getLocationDistance($request);
            
            if(!empty($location['errors'])){
                throw new Exception($location['errors']);
            }
            else{

                if(config('constants.distance','Kms')=='Kms')
                    $total_kilometer = round($location['meter']/1000,1); //TKM
                else
                    $total_kilometer = round($location['meter']/1609.344,1); //TMi

                $requestarr['meter']=$total_kilometer;
                $requestarr['time']=$location['time'];
                $requestarr['seconds']=$location['seconds'];
                $requestarr['kilometer']=0;
                $requestarr['minutes']=0;
                $requestarr['service_type']=$request['service_type'];
                $requestarr['destino']=$location['destino'];
               

                $tax_percentage = config('constants.tax_percentage');
                $commission_percentage = config('constants.commission_percentage');
                $surge_trigger = config('constants.surge_trigger');
               
                $price_response=$this->applyPriceLogic($requestarr);

                if($tax_percentage>0){
                    $tax_price = $this->applyPercentage($price_response['price'],$tax_percentage);
                    $total = $price_response['price'] + $tax_price;
                }
                else{
                    $total = $price_response['price'];
                }


                if($cflag!=0){

                    if($commission_percentage>0){
                        $commission_price = $this->applyPercentage($price_response['price'],$commission_percentage);
                        $commission_price = $price_response['price'] + $commission_price;
                    }
                   
                    $surge = 0;                

                    /*if($surge_trigger>0){

                        $ActiveProviders = ProviderService::AvailableServiceProvider($request['service_type'])->get()->pluck('provider_id');

                        $distance = config('constants.provider_search_radius', '10');
                        $latitude = $request['s_latitude'];
                        $longitude = $request['s_longitude'];

                        $Providers = Provider::whereIn('id', $ActiveProviders)
                            ->where('status', 'approved')
                            ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                            ->get();

                        $surge = 0;

                        if($Providers->count() <= config('constants.surge_trigger') && $Providers->count() > 0){
                            $surge_price = $this->applyPercentage($total,config('constants.surge_percentage'));
                            $total += $surge_price;
                            $surge = 1;
                        }

                    }    

                    $surge_percentage = 1+(config('constants.surge_percentage')/100)."X";*/


                    $start_time = Carbon::now()->toTimeString();
                    
                    $start_time_check = PeakHour::where('start_time', '<=' ,$start_time)->where('end_time', '>=' ,$start_time)->first();

                    $surge_percentage = 1+(0/100)."X";

                    if($start_time_check){
                        $Peakcharges = ServicePeakHour::where('service_type_id',$request['service_type'])->where('peak_hours_id',$start_time_check->id)->first();

                        if($Peakcharges){                            
                            $surge_price=($Peakcharges->min_price/100) * $total;
                            $total += $surge_price;
                            $surge = 1;
                            $surge_percentage = 1+($Peakcharges->min_price/100)."X";
                        }
                    }    
                    
                }    
                
               // $return_data['estimated_fare']=$this->applyNumberFormat(floatval($total)); 
               // $return_data['estimated_fare']=floatval($total); 
               //$return_data['estimated_fare']=round($total,1); 

               $foo = round($total,1);
               $return_data['estimated_fare']=number_format((float)$foo, 2, '.', ''); ; 
               

                $return_data['distance']=$total_kilometer;    
                $return_data['time']=$location['time'];
                $return_data['tax_price']=$this->applyNumberFormat(floatval($tax_price));    
                $return_data['base_price']=$this->applyNumberFormat(floatval($price_response['base_price']));    
                $return_data['service_type']=(int)$request['service_type'];   
                $return_data['service']=$price_response['service_type'];   

                if(Auth::user()){
                    $return_data['surge']=$surge;    
                    $return_data['surge_value']=$surge_percentage;   
                    $return_data['wallet_balance']=$this->applyNumberFormat(floatval(Auth::user()->wallet_balance));  
                }

                $service_response["data"]=$return_data;                    
            }

        } catch(Exception $e) {
         
            $service_response["errors"]=$e->getMessage();
        }
    
        return $service_response;    
    } 

    public function applyPriceLogic($requestarr,$iflag=0){

        $fn_response=array();

        $service_type = ServiceType::findOrFail($requestarr['service_type']);
        $IncrementoPorTipoCarro=0;
        
        

        


        if($iflag==0){
            //for estimated fare
            $total_kilometer = $requestarr['meter']; //TKM || TMi
            $total_minutes = round($requestarr['seconds']/60); //TM        
            $total_hours=($requestarr['seconds']/60)/60; //TH
        }
        else{
            //for invoice fare
            $total_kilometer = $requestarr['kilometer']; //TKM || TMi       
            $total_minutes = $requestarr['minutes']; //TM        
            $total_hours= $requestarr['minutes']/60; //TH
        }

       
        //$ciudaddestino = $destinoOpcional;
        /*if($requestarr['destino']=='aaaa'){

            $ciudaddestino='aaaa';
        }
        else{*/
            $IncrementoPomalca=0;
            $IncrementoJLO_LA_VICTORIA=0;
            $IncrementoChiclayo=0;
            $IncrementoJLO=0;
            $ciudaddestino = $requestarr['destino'];
            $myString = $ciudaddestino;     
            //$containsPomalcaLambayeque = str_contains($myString, ['Pomalca', 'Lambayeque']);
            
            $containsPomalcaLambayeque = Str::contains($myString, ['Pomalca']);
            if ($containsPomalcaLambayeque) {
                $IncrementoPomalca=7;
            } 
            
            $containsJLO = Str::contains($myString, ['Leonardo Ortiz','Leonardo']);
            if ($containsJLO) {
                $IncrementoJLO=1;
            } 

            $IncrementoJLO_LA_VICTORIA = Str::contains($myString, ['La Victoria','Victoria']);
            if ($IncrementoJLO_LA_VICTORIA) {
                $IncrementoJLO_LA_VICTORIA=1;
            } 
            $IncrementoChiclayo = Str::contains($myString, ['Chiclayo','Chiclayo']);
            if ($IncrementoChiclayo) {
                $IncrementoChiclayo=1;
            } 

            
        //}
      
      
        //  $ciudaddestino = 'chiclayo,LAMBAYEQUE';
        
        //$rental = ceil($requestarr['rental_hours']);
       
        $per_minute=$service_type->minute; //PM
        $per_hour=$service_type->hour; //PH
        $per_kilometer=$service_type->price; //PKM
        $base_distance=$service_type->distance; //BD       
        $base_price=$service_type->fixed; //BP

   
            $IncrementoPorTipoCarro=0;

            $TipoCarro=$service_type->name;

              $cur_hour = (int)date('H'); // current hour(0-23)
              $cur_day = (int)date('N'); // current day(1-7)
              $incremnt = 0;
              if ($cur_hour <= 6 || $cur_hour >=22) {
              $incremnt = 1;
              }


         

            if($TipoCarro== 'Parrilla') {
                $IncrementoPorTipoCarro=2;
                $price=$price+$IncrementoPorTipoCarro;
            }else if($TipoCarro == 'Standar') {
              
                if($total_kilometer<=1.4){ 
                    $price=5+$IncrementoPomalca+$IncrementoJLO+$incremnt;
                    if($IncrementoJLO==0){
                        $price=$price+$IncrementoJLOorigen;
                    }
                }
                else if($total_kilometer<=3.0){
                    $price=6+$IncrementoPomalca+$IncrementoJLO+$incremnt;
                    if($IncrementoJLO==0){
                        $price=$price+$IncrementoJLOorigen;
                    }
                }
                else if($total_kilometer<=4.9){
                    $price=7+$IncrementoPomalca+$IncrementoJLO+$incremnt;
                    if($IncrementoJLO==0){
                        $price=$price+$IncrementoJLOorigen;
                    }
                   // $price=100;
                }
                else if($total_kilometer<=6.5){
                    $price=8+$IncrementoPomalca+$IncrementoJLO+$incremnt;
                    if($IncrementoJLO==0){
                        $price=$price+$IncrementoJLOorigen;
                    }
  
                }
                else if($total_kilometer<=7.9){
                    $price=9+$IncrementoPomalca+$IncrementoJLO+$incremnt;
                    if($IncrementoJLO==0){
                        $price=$price+$IncrementoJLOorigen;
                    }
  
                }
                else if($total_kilometer<=9.0){
                    $price=10+$IncrementoPomalca+$IncrementoJLO+$incremnt;
                    if($IncrementoJLO==0){
                        $price=$price+$IncrementoJLOorigen;
                    }
  
                }
                else{
                 
                        if($total_kilometer<=9.5){                 
                           
                                $price = (1.35 * $total_kilometer)+$incremnt+ $IncrementoPorTipoCarro+$IncrementoJLO+$IncrementoJLOorigen+$IncrementoPomalca; // lo cambie a 1.1 por km cuando es mayo a 10 km segun irvin 
                               // $price =$IncrementoPomalca;
                         }
                         else{
                            if($total_kilometer<=10.70){                 
                              
                                    $price = (1.40 * $total_kilometer)+$incremnt+ $IncrementoPorTipoCarro+$IncrementoJLO+$IncrementoJLOorigen+$IncrementoPomalca; // lo cambie a 1.1 por km cuando es mayo a 10 km segun irvin 
                                  
                             }
                             else{
                                if($total_kilometer<=12){                 
                                  
                                        $price = (1.35 * $total_kilometer)+$incremnt+ $IncrementoPorTipoCarro+$IncrementoJLO+$IncrementoJLOorigen+$IncrementoPomalca; // lo cambie a 1.1 por km cuando es mayo a 10 km segun irvin 
                                      
                                 }
                                 else{
                               
                                  
                                    if($total_kilometer<=15){                 
                                  
                                        $price = (1.33 * $total_kilometer)+$incremnt; // lo cambie a 1.1 por km cuando es mayo a 10 km segun irvin 
                                      
                                     }
                                    else{
                               
                                        if($total_kilometer<=25){                 
                                  
                                            $price = (1.1 * $total_kilometer)+$incremnt; // lo cambie a 1.1 por km cuando es mayo a 10 km segun irvin 
                                          
                                         }
                                        else{
                                   
                                            $price = (1.18 * $total_kilometer)+$incremnt; // lo cambie a 1.1 por km cuando es mayo a 10 km segun irvin 
                                      
                                         }
                                  
                                     }
                                
                                 }
                                
                             }
                            
                         }
                    
                     
  
  
                }
                
                
            }          
            else if($TipoCarro == 'Mototaxi') {
            
             if($cur_hour<=3){
                    // $KilometroAdicional=1.2;
                     if($TipoCarro == 'Mototaxi'||$TipoCarro == 'Conductor Mujer' || $TipoCarro == 'Courier') {
                       $TarifaBase=4.50;
                     }
                     else{
                     
                      $TarifaBase=$TarifaBaseDB;
                     }
 
                 }
                 else if($cur_hour<=5){
                     //$KilometroAdicional=1;
                     if($TipoCarro == 'Mototaxi'||$TipoCarro == 'Conductor Mujer' || $TipoCarro == 'Courier') {
                       $TarifaBase=3.50;
                     }
                     else{
                     
                      $TarifaBase=$TarifaBaseDB;
                     }
                 }
                 else if($cur_hour<=18){//
                     //$KilometroAdicional=1.5;
                     if($TipoCarro == 'Mototaxi'||$TipoCarro == 'Conductor Mujer' || $TipoCarro == 'Courier') {
                       $TarifaBase=3.00;
                     
                     }
                     else{
                     
                      $TarifaBase=$TarifaBaseDB;
                     }
                 }
                 else if($cur_hour<=22){
                     //$KilometroAdicional=1.2;
                     if($TipoCarro == 'Mototaxi'||$TipoCarro == 'Conductor Mujer' || $TipoCarro == 'Courier') {
                       $TarifaBase=3.50;
                     }
                     else{
                     
                      $TarifaBase=$TarifaBaseDB;
                     }
                 }
                 else{
                    // $KilometroAdicional=1.2;
                     if($TipoCarro == 'Mototaxi'||$TipoCarro == 'Conductor Mujer' || $TipoCarro == 'Courier') {
                       $TarifaBase=4.50;
                     }
                     else{
                     
                      $TarifaBase=$TarifaBaseDB;
                     }
 
                 }
 
 
 
 
             
             if($total_kilometer<=1){
                            
                    $price=$TarifaBase;
                    //$price=150;
              
 
                }
                else{
                  
                    
                   $CantidadKMadicionales=($total_kilometer-1);
                   if($CantidadKMadicionales<=2){
                     $KilometroAdicional=1.00;//1.20
                   }
                   else if($CantidadKMadicionales<=2.5){
                    $KilometroAdicional=1.50;
                  }
                   else if($CantidadKMadicionales<=4){
                     $KilometroAdicional=1.50;
                   }
                 
                  else {
                     $KilometroAdicional=1.80;
                  }
                    
                 
                      
                  $price=$TarifaBase+(($total_kilometer-1)* $KilometroAdicional);
                 // $price=($total_kilometer-1)* $KilometroAdicional;
                }

                
              
            }

            
         
            
       

        $fn_response['price']=$this->applyNumberFormat(floatval($price)); 
       // $fn_response['price']=$price; 
     
        $fn_response['base_price']=$base_price;
        if($base_distance>$total_kilometer){
            $fn_response['distance_fare']=0;
        }
        else{
            $fn_response['distance_fare']=($total_kilometer - $base_distance)*$per_kilometer;
        }    
        $fn_response['minute_fare']=$total_minutes * $per_minute;
        $fn_response['hour_fare']=$total_hours * $per_hour;
        $fn_response['calculator']=$service_type->calculator;
        $fn_response['service_type']=$service_type;

        return $fn_response;
    }

    public function applyPercentage($total,$percentage){
        return ($percentage/100)*$total;
    }

    public function applyNumberFormat($total){
        return round($total,config('constants.round_decimal'));
    }
    
    public function getLocationDistance($locationarr){

        $fn_response=array('data'=>null,'errors'=>null);
        
        try{

            $s_latitude = $locationarr['s_latitude'];
            $s_longitude = $locationarr['s_longitude'];
            $d_latitude = empty($locationarr['d_latitude']) ? $locationarr['s_latitude'] : $locationarr['d_latitude'];
            $d_longitude = empty($locationarr['d_longitude']) ? $locationarr['s_longitude'] : $locationarr['d_longitude'];

          //  $apiurl = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$s_latitude.",".$s_longitude."&destinations=".$d_latitude.",".$d_longitude."&mode=walking&sensor=false&units=metric&key=".config('constants.map_key');  
         

            
            $apiurl = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$s_latitude.",".$s_longitude."&destinations=".$d_latitude.",".$d_longitude."&mode=driving&departure_time=now&traffic_model=optimistic&units=imperial&key=".config('constants.map_key');  
            //walking

            $client = new Client;
            $location = $client->get($apiurl);           
            $location = json_decode($location->getBody(),true);
           
            if(!empty($location['rows'][0]['elements'][0]['status']) && $location['rows'][0]['elements'][0]['status']=='ZERO_RESULTS'){
                throw new Exception("Out of service area", 1);
                
            }
            $fn_response["meter"]=$location['rows'][0]['elements'][0]['distance']['value'];
           //$fn_response["meter"]=700;
            $fn_response["time"]=$location['rows'][0]['elements'][0]['duration']['text'];
            $fn_response["seconds"]=$location['rows'][0]['elements'][0]['duration']['value'];

            $fn_response["destino"]=$location['destination_addresses'][0];

        }
        catch(Exception $e){
            $fn_response["errors"]=trans('user.maperror');
        }      

        return $fn_response;    
    }
}