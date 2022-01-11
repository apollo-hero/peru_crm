<?php

namespace App\Services;

use Exception;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Exception\Auth\EmailExists as FirebaseEmailExists;
use PHPUnit\Framework\Constraint\IsFalse;

class FirebaseService
{
    /**
     * @var Firebase
     */
    protected $firebase;

    public function __construct()
    {
        /*$serviceAccount = ServiceAccount::fromArray([
            "type" => "service_account",
            "project_id" => 'taxiimperialprovider',
            "private_key_id" => '0f0c483bb5bbe1ee3bf5d790af569249af05872d',
            "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQCuOiDN96VWLMC8\naBxQbtOAiPqTKdPkdWBHRaC2DX0o0LYIH0+XCzg79YC84bYxDwOuOHkwQrfgV5JB\nVQHPvkuGnTpHPi9RfyRzF810lY+9yiSYy+1FuRa2c5fL0oXb3MmjSNJFnfHzHUq2\noxOk7Xe3XC9piAeaYE4+Kaoy68dGqMPV+7i6hNQxJxQM7+EwG932nMvvXasilyzk\nyn7jCqIukY+N5ciaTLufdOBFu1LRuLo6T868MRyksySSqSXTSO5d9SUa2NANrqC0\n2eXjpgXLIFRNo5gpbMt4oMOgRrZHqH+I7yoEZReRupHCv6jSIf1exhjSrjRmwejQ\nv51/3tsZAgMBAAECggEAAhILxhbYKVQtKDAJN3AnEE3Qbdj0koWjPXBCOYJN3KMk\n/qdh7+wWC38JPCAR5QxbdqxneEowBY5U3R+QVB0xUuoMbBX87vgsATglB2p9mPui\n1V6wX6s+7gUlUSqbz6Hp6DMF2LDzU/h4T6pUIe92hEB9XxYwQkaRt3hm9Dr2v8wI\nOj6vXLUR2y2Ft9PnUv0jrRg58pfo+4TNA47qPIDyBpwy86pXqsxxdfYUtgEp5yvH\njvPQG9VFuNJbY/rbIrTRJjO/gMpp/5EFHhuHvqr9lHfVYjJZ426IBrzqDPgFrwMN\nyRu5WyFvKOQ+dbsfWb+EcKs0jkQRaLpNZo0VpF/52QKBgQD2N14RJicXGOHUTise\nFY6AWs9TOC6V8kmtC18jCbxfFun85AHghmheFYhFKPdxynzV8m/QpdLdMkIfI+n6\nZ99960vGtB7wYuIY7uVnTB/zxPppU4q3mJ4QDuEm2ZqJP3tWHHi5wON6FdZSILbt\nNvK/gRAkEEwDdJfUR6rGnYBttQKBgQC1JnN90NBg0GFxC1CgoDv1f8kvQZytniie\nrvxvtPrRdGH6d4C//DCJq5oZ6AzvU3yDyWx9hNlvrgTrduIVRFADQm6E9KQHqj6/\nK+l6Ft8CztiO/JhGJkgI86gEBnh3MlX8nOMxsdpgn2wooeXBLon0c2JksKXmZh/1\nP3VNnKV2VQKBgQDoJoJiRwf6hjKAPIf5ILgxG+559/Is3btMFvnIDqj3O6K6GL4Q\nVorXkxPeqebN+u9DxwhYwdGVUIr506IMwZ3/mzjijPjTDVlDyxSwFh3WefbmEqgr\nvhHi8DSorepA2INRSR0nf9C8TxS6cTApcHLn0ChI6LjTVT7HIB/Mj7sFNQKBgQCy\nC87r1HdbELUVRMfEeHk2PJji55w1UQQfo2Hd8YWspLVAVoCnMhoK1i0qVVeRSv9R\nEIKfhBmqmOGhBUIFIRV7fqnd6A3osr3lbCWYqC4dNmzHbSHFoQ6gLcvv2ORCU6kM\nFq9/Qo2e9lJ6RVXq3/Eb4OTOjokgwTOb+vkyhUpj2QKBgQCbGWmbl9eTvVJOFYui\nU9yCz4HHJEFxXz4YERmLmOjLD+biGaNh1N8+CQBJlQZ+ggDal8RFRNUEUgDGitn+\n0+ZjwDxwNKXaiwoiJDcLoH2z3ygXVTiuzsHTE0YarLC0+naj1wxEqvH9bvpIxPwo\nHeYmrPDxFLRhBhN5NijM/f7t2A==\n-----END PRIVATE KEY-----\n",
            "client_email" => 'taxiimperialprovider@appspot.gserviceaccount.com',
            "client_id" => '111826649651545586959',
            "auth_uri" => 'https://accounts.google.com/o/oauth2/auth',
            "token_uri" => 'https://oauth2.googleapis.com/token',
            "auth_provider_x509_cert_url" => 'https://www.googleapis.com/oauth2/v1/certs',
            "client_x509_cert_url" => 'https://www.googleapis.com/robot/v1/metadata/x509/taxiimperialprovider%40appspot.gserviceaccount.com'
        ]);

        $this->firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://taxiimperialprovider.firebaseio.com/')
        ->create();*/

     /*  $serviceAccount = ServiceAccount::fromArray([
            "type" => "service_account",
            "project_id" => 'miappdetaxiscom',
            "private_key_id" => 'df8fb4189d9d26edb35695847d2be0bf70414901',
            "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCtsaLluRtKWO0n\n07FxxT6Sadqhyzpex9BgM2I+a2WeqJ4HlIyiUY92+8JK43/sRglKxK9Cn1Z05Pk9\n2whNA83rJlngFlI/YL6u20+vtn88gI5jLsNTVk06iqgpTbh9Vsn5JlFpdRR10tw/\nhp1OUh4blEO6pJtYQbpJWcDkvvrshdu6GnYf6EQkyuwytbEQfLAvOqrwwyjPTmV2\ndXAZXrjsMGcOqD9VHWOPCEDOqZhrhBKM7IVtbyqRdEFDB7Yai/68iex9IPKZ6PGJ\nqKcD4P3MzQ+GK27SO/PmV+UQYFXcVUvYFqV30iRljpQtzmssbnXwIsuI+/fuTaur\nVSTzjowrAgMBAAECggEAIVEwmPYPyQwTuY7+u38FSJpraJuN/74+NyXEE4sQPAXG\nAlg5Pa19YmpaU3keAZlRkPj3UUU1FUkSkg3gor03E4MQvE4ryqJpEStaNq8/6sAS\nD+5ZYzPrrm4IYZvZ5pjuNw9lkF/3473lp33P0MUpp0qiTzvh3GUHMai4umfzw8h8\nfP/lqvRbcV69QJeNJWS4QkDvIsD1SCMXg5m7XaULfw5PhlXOz7AzbXA4rEbLm+Uj\nFeGssdmjxBj/+WxZPG1L4sS33sw5c/jcun4MxxPOkePvniEswOyIysG1Z8ZOGy9s\nXuDHKmQNyH54YI+ZNjjijMh+NRWG9EWRAJwB8c7sSQKBgQDVlJjw6lKngqOw6B7c\nAZbAQK/BCCaIXPb5CkD0hdBwODil5j/qaiYc0/Nelc/GK3MQBsb1fepNIxfWAS0w\nstkt29MwopK8w5fAJh4aRjPvXhb8iL/SvTDjq2gpHvWd0RBCtUJvzLJFVNL2mndA\nxImh1D6E7EIKB6Hq95o2HryQVQKBgQDQMQY4mgqJJnoaDM7MfGZh1H4jKLy4X2+P\n9vZptY5NLlyBYkvrpP5r/AfT78D1cjVmvIt0IKvzsdUyx0D17C2Q1KVUZHX4vXyT\nNjwurOyzvGQOgijGvlN24YGpYZwgDhbrZeK6gGVKMOILr1JS1Sq5PBtxaAIpKlS6\n+eKXZAEqfwKBgQCFSyEMMeF1w5VvQd6IhcFUqMpHWVPbBNHp6RlSwfStJJlOCF3Z\naXfxw+F+JVcvoUxFM0WWTogcrgshN0jBvMzHzwqFruCPSC578A4XbbrZ58nGv32g\nAwzw+bee+kBlxuU0DLWy2nhjxqWG3C4S0NXolnKSOHSal9rYrsCiiBo8pQKBgCD3\nwm5wJj71stwxLwY+pM/VIGxc5RWlNztq9jZjI7ehIdDzSeZ06D0dWff7vWigv0gX\nj1XCXrhmbsZtuyG2Vrjak5u7lNrg1rtRGVKi25DSwl1xyxc9yGXI7AlwhZKl6Ic6\nSR8Tefa3qvQCvVyUmQFgPVBGEiGGrIg3TeR/V5ftAoGBAKSMC968JrOI5IdiKKjg\ndvmo6Y/Uw0SR95y11z1aXiqkiRPZ3confeoJP/Tfe0UNKmWGqT6ev7AcYJXdxwiZ\nFOI+FV6dr57n3BllcQhDbdWlFTl9z+M6NDQKrfyNVw6vXlPmrOHqZBYnBVwcXe25\nC3G8wpa1gkq/XVCUZIjVKa9t\n-----END PRIVATE KEY-----\n",
            "client_email" => 'miappdetaxiscom@appspot.gserviceaccount.com',
            "client_id" => '102835745248359728452',
            "auth_uri" => 'https://accounts.google.com/o/oauth2/auth',
            "token_uri" => 'https://oauth2.googleapis.com/token',
            "auth_provider_x509_cert_url" => 'https://www.googleapis.com/oauth2/v1/certs',
            "client_x509_cert_url" => 'https://www.googleapis.com/robot/v1/metadata/x509/miappdetaxiscom%40appspot.gserviceaccount.com'
        ]);

        $this->firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://miappdetaxiscom.firebaseio.com/')
            ->create();*/
       $serviceAccount = ServiceAccount::fromArray([
                "type" => "service_account",
                "project_id" => 'zyrodriver',
                "private_key_id" => '2ed1412880133a423dfdffa900fd09dfdf7c7131',
                "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCF3bb4Lb24Xx9h\nHQ9vIZ/7T3IelTNbT7i3RDrfF6o2hJi4rXWVMG659FIwb00D4LDSeq9XyZ30TX3j\ns2XdSDoahnQQbdSHW9XsBwY/8Y1snE1+mpkezdwRU4p+7RM9lLa4fcx7rpPu6e+Q\n/3tNuK3/dZUMrNw1zubUABZZuB1pcQbElhvapVyaJ02TrNsk2IOnvlRucKsYQ1/i\n6LfCLu5u+KTX0fLB7T/g56qa0Hz+vlJWKxMM9fNQFo8kVLChnv4um5BbTl2MgWrd\n2KNEPBvY835GjeJOfTh445EkM/jXiNzBZX1FsrBY3k4whxOwXP7JRlbka07AKjCv\nSLusqEH/AgMBAAECggEAAuHmvdau6pOhJ2ug2JpwDkdS9al4AqAscLtSX6h1yli6\n4DIz95DzLbeNwETGfOkeMePhT743jrVZEPrJEqWNG1mR9DZ0SIigYs+E1VEHWgIw\n0A+bXTXmUqUveY4uqc0Fax3dZzwQP4u4mTroTBbSAE/Jm75+CiVWcHIFREJfBoaO\nJ8i0HDCMdV249SBPLOJCMRvRB46edrLGn2Q1KOpn71OvqXZz9AbkwdMbzP5WWePg\nMumSDTpTMIgKVdAv4OUUIhMJrPBK64AuG+oRi5F9b1jPw15S3DPtdf3U+KlbwCCx\nN2XzEVuW8ujO8StZBrNdXJrbN2bdW8qvjhOkuuGUsQKBgQC5QElY/gOyvSodmtTe\npNpuHa5LojwW5BPcRhSXSjh4ZymcYc+CMVS+8n4gjBRbyJyqZZZMHsectsRVa5+m\nrACQW7M3ZmdGPbYabpJTcx+XnuZLtsMGRNWA5v4nFrf6ZBXtJDHW9Z5j/7qDHfFj\nl7YrM2hXdLD2DjPcWQk5bPYEJwKBgQC4/Zeep5h2Htm9SpkbeO+5lKOJ+pXBjhgx\nfIa3rIZ8v9Q9fW0zrUldEBhyRiqBUYZ9qtlmLUIJVF7y0OhdVpWTnQ2YovAv8pAi\nEuPONxKJy+A6sUvGIYOw6gl+egU75zwoLycBfkaeiO/hbqIvDEI6s99JQIvPGATu\n2F46+G3CaQKBgBO4BBa08y/Tcugz0vTgF2AhSKxEWKEXJgYMb6SrAdfPI17CCpSR\nK7Qnm8VbI8+hSwvYRGdV32mPCtcM3bGgHW9AU5NSEywm5XtqyaiYWISLJXhpu9iu\n+wr9i5AdmvfML4lOkP+QpYt/bRsH1OoE/B8dGb41baDDYkHSOGkkcAuBAoGAEhld\nmDw1gnkKPKbry/BNJA8S4REPTdylKVJRq+7JSbNLBKkc4g12PBCzE5sh1X0wd2Mb\n2g9bgqYqk/80fM1X3RVkmyZ18Xr99xd6ClcBDVJRIezuyPfGdqyvORyfHnlFPXk/\ni7nbFu+26It2ervsTuoCUpxqEVz8PpIUxhhAROECgYEAjMMbu3YQlFUztrEA/Jyx\ne4eNh4EszODM443SN4eLri0t+9/wAsx9pkQrzvkBo8TXjeEkyNka95WUH2PX11j/\nc7CAMaIUABrqR9fF/cejfXCBErfcX84dxTi8VklgRHl6GY5WDbwlhzqfv3IfWCA6\nCUWYQ9VzxaDS/FQ0jDuVH60=\n-----END PRIVATE KEY-----\n",
                "client_email" => 'firebase-adminsdk-tgnsn@zyrodriver.iam.gserviceaccount.com',
                "client_id" => '109618365654698062076',
                "auth_uri" => 'https://accounts.google.com/o/oauth2/auth',
                "token_uri" => 'https://oauth2.googleapis.com/token',
                "auth_provider_x509_cert_url" => 'https://www.googleapis.com/oauth2/v1/certs',
                "client_x509_cert_url" => 'https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-tgnsn%40zyrodriver.iam.gserviceaccount.com'
            ]);
    
            $this->firebase = (new Factory)
                ->withServiceAccount($serviceAccount)
                ->withDatabaseUri('https://zyrodriver-default-rtdb.firebaseio.com/')
                ->create();
    }


    public function distanciaGeodesica($lat1, $long1, $lat2, $long2){

        $degtorad = 0.01745329;
        $radtodeg = 57.29577951;
        
        $dlong = ($long1 - $long2);
        $dvalue = (sin($lat1 * $degtorad) * sin($lat2 * $degtorad))
        + (cos($lat1 * $degtorad) * cos($lat2 * $degtorad)
        * cos($dlong * $degtorad));
        
        $dd = acos($dvalue) * $radtodeg;
        
        $miles = ($dd * 69.16);
        $km = ($dd * 111.302);
       

        $refer_key = time();
                $database = $this->firebase->getDatabase()->getReference('/laravel_'.$refer_key);               
                $database->set([
                    'key' => "001",
                    'value' =>$km
                ]);

        return $km;
        }

    public function get_ids_by_android_version($lat1,$long1,$radio_maximo) {
        $ans  = array();
        $arr = array();
      

        
        try {
            $database = $this->firebase->getDatabase()->getReference()->getSnapshot();
            $database = $database->getValue();
           
           

            foreach($database as $key => $value) {
                $v2 = empty($value['versionAndroid']) ? "Vers: 0" : $value['versionAndroid'];
                $vf = floatval(substr($v2, 6));
                $lat=floatval($value['lat']);
                $lng=$value['lng'];

                $lat2=$lat;
                $long2=$lng;
                //$kmDistance=distanciaGeodesica($latitude,$longitude,$lat,$lng);
               // distanciaGeodesica($latitude,$longitude,$lat,$lng);

               $lat1=floatval($lat1);
               $long1=floatval($long1);

               $degtorad = 0.01745329;
               $radtodeg = 57.29577951;
               
               $dlong = ($long1 - $long2);
               $dvalue = (sin($lat1 * $degtorad) * sin($lat2 * $degtorad))
               + (cos($lat1 * $degtorad) * cos($lat2 * $degtorad)
               * cos($dlong * $degtorad));
               
               $dd = acos($dvalue) * $radtodeg;
               
               $miles = ($dd * 69.16);
               $km = ($dd * 111.302);





               /* $refer_key = time();
                $database = $this->firebase->getDatabase()->getReference('/laravel_'.$refer_key);               
              
                $database->set([                  
                    'latitud_origen' =>$lat1,
                    'longitud_origen' =>$long1,
                    'latitud_destino' =>$lat2,
                    'longitud_destino' =>$long2,                   
                    'distancia km' =>$km,
                    'radio_maximo'=>$radio_maximo
                ]);*/

              /*  $database->set([
                    'key' => "long1",
                    'latitud_origen' =>$long1
                ]);

                $database->set([
                    'key' => "lat2",
                    'latitud_destino' =>$lat2
                ]);
                $database->set([
                    'key' => "long2",
                    'latitud_destino' =>$long2
                ]);*/

                //$lat=floatval($value['lat']);
                //$lng=$value['lng'];
               //save_data("latitude_",$value['versionAndroid'], false);
                //distanciaGeodesica($latitude,$longitude,$lat,$lng);
               // $kmDistance=distanciaGeodesica($latitude,$longitude,$lat,$lng);
                
                if($km>$radio_maximo)continue;
                if($vf < 1.0) continue;

                $id = floatval(substr($key, 6));
                array_push($ans, array(
                    'key' => $id,
                    'version' => $vf,
                    'value_id' => $key,
                    've' => $v2
                    
                ));
                array_push($arr, $id);
            }
            
            return array($ans, $arr);
        }
        catch(Exception $ee) {
            return $ee->getMessage();
        }
    }

    public function get_position($para_id) {
        try {
            $database = $this->firebase->getDatabase()->getReference()->getSnapshot();
            $database = $database->getValue();

            // condition to get ?

            $ans = array(
                'success' => 0
            );
            foreach($database as $key => $value) {
                $id = floatval(substr($key, 6));
                if($id != $para_id) continue;
                $ans = array(
                    'success' => 1,
                    'lat' => $value['lat'],
                    'lng' => $value['lng']
                );
                break;
            }
            return $ans;
        }
        catch(Exception $ee) {
            return array(
                'success' => 0,
                'error' => $ee->getMessage()
            );
        }
    }

    public function save_data($key, $value, $is_json = false) {
        $refer_key = time();
        $database = $this->firebase->getDatabase()->getReference('/alertas/laravel_'.$refer_key);
        if($is_json) {
            $value['key'] = $key;
            $database->set(
                $value
            );
        }
        else {
            $database->set([
                'key' => $key,
                'value' =>$value
            ]);
        }
    }
}