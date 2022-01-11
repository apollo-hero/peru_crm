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

         $serviceAccount = ServiceAccount::fromArray([
            "type" => "service_account",
            "project_id" => 'pidelotaxi-f8733',
            "private_key_id" => '22f1973c319d20dcd736923adca2853f9742bae7',
            "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQC7sGPVj6VCXLzH\nFMc2xdRNrctSikJOwPlfpjy+rbjeMqQmthxpxC58Do+FJnCbQ/pVv5OsKO44qZKL\nj+pGPpunCLqol4aFO1UYPRGMuEYCo5Dt/3Ye6oa5MaB5uJtO43Bd5KU+AtgZDl/X\nLj5rCnxYGIDuGNCXNwz1aOE/tgqXQdmmojxDPIOBWjYQeQ292hhdGlKbIsaLFdTr\nX99y2q7xPL1bIHmCrveqnjil0SpphojC8wg3BwPHweGHptweGIk7uYtVwx0K8m6b\ngOLwb/V9psFUUOrrSWlQnRgQQ2Mlh5CzUvuFn63K8G2cLf2jdQwsNga971Zp1W6W\nD+5s0TDHAgMBAAECggEABcbdy8YYE30bzclrpf43pzD8f/FM5JjJpm263FXeyaW5\n8yA3z6mSJLPuBu6NqwLiVQy/VIwN9rdc2jEbyEbZnMA9voc9smwZFdTCNqqVT1ig\nUw5magrnCqVUYyGRL1IgxrDEDmWzcQjYOlPaDIqE8BpaHYw/H1YV3JfVzdzGz9D1\n+BypuL3or8S1wnZdmle300h0ZL03dYswQxgQFDdv271lWSXyuMpR0PufVAJ12hLU\n4z6e/y4IujGV8G1v6FitX+m0I4pLjY062AvHK1UotLjsDrAFTlrLwtlLPi1jK93e\nngmAk2rG1gf2pdFoknh/WuGLZsP7mBOTfw94UNzfwQKBgQD/QHKAIqhwbNU0IpfQ\nBJFmXS+tLNa+wABR7i9LRhdmPj2w6sTa6Olo2xvm9f12GtIQsxzyQbjpzVQ0scDz\nIOD5B2LYo9UfmJlnHXpN+0T5a6ItbZTI7gnf8ts6ZT7Z9iBBlvN5zKqy8Pq9B741\nY/VxS+Sh3GtujYTGVwD1Ra9+pQKBgQC8PT2SP883M08TS1gFyuJPbM7Wz7TMaSJo\nqgoHqm5aIuHm6aFUNXzZ0ETtOBXApAxZ/fxh8xI18UmK7iB2+hjQPQNdUyAlEA39\n+aG7XJ0zYgUPF4gixo3hj5cs7ahDQrUG0ak4JExMsqkX/JHtLTt+TylKTH1ekgN5\n7uidu93h+wKBgQC/WKe9KL4OcXeuepRFy3bYPtkjv+5H1pUm1iA8FJIsAlKq0oO5\n+0omYcLb8+IK7HY3MJ5teRlOo68RRYN4f1hHNuNBtidpZTLyWuW5mbiOJcLQvUoB\nCnj6mgsADq/8IwbxRGDHGMeKFx5QIILVcVaolRUSxbL/kDVNniFIvPGfRQKBgHtg\nvFl+P0gT9jFUQdZSGzEpxQxgyUTtZ+MoCDjsCTZFBMG/wcEa6cEt0++TwhYor/vQ\nEDr3Aamfg69u0pKI6/iY9PqXQEtqkXE0zD+svVBvX5d7ufvpHheIcPK+tnmXYGWe\nyAYHLIdc1p3lKpRFAGiSZCLRrZ5tn5+s6oRwHUc/AoGAKeeRutaAv2s6YD0p5WOz\nr0odRdyIrywIOaQfnQzKiRuKRrsAy3jN70wOpVjuWJFPfoa5Fj5nh6G4ZSBxkFra\nTyqXFoYDSDyRoJq44G0KOOBsX9LNUnmzhO6PHUPk1syPcCWaN2WWYrSeciWTDtcq\n5SreEiBO/mc+BvJt5/8gx9c=\n-----END PRIVATE KEY-----\n",
            "client_email" => 'firebase-adminsdk-fbksr@pidelotaxi-f8733.iam.gserviceaccount.com',
            "client_id" => '100239368104820418794',
            "auth_uri" => 'https://accounts.google.com/o/oauth2/auth',
            "token_uri" => 'https://oauth2.googleapis.com/token',
            "auth_provider_x509_cert_url" => 'https://www.googleapis.com/oauth2/v1/certs',
            "client_x509_cert_url" => 'https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-fbksr%40pidelotaxi-f8733.iam.gserviceaccount.com'
        ]);

        $this->firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://pidelotaxi-f8733.firebaseio.com/')
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
        $database = $this->firebase->getDatabase()->getReference('/laravel_'.$refer_key);
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

