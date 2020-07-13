<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pharmacy;

class PharmacyController extends Controller
{
    public function index()
    {
        return Pharmacy::all();
    }

    public function findNearestPharmacy($lat, $long) {
        $nearestPharmacy = null;
        $nearestPharmacyDistance = null;
        $pharmacies = Pharmacy::all();

        foreach($pharmacies as $pharmacy) {
            $providedCoordinates = $lat .",". $long;
            $pharmacyCoordinates = $pharmacy->latitude .",". $pharmacy->longitude;
            $pharmacyDistance = $this->getRoadDirectionsDistanceFromGoogle($providedCoordinates,$pharmacyCoordinates);
            
            if(is_null($nearestPharmacyDistance) || $pharmacyDistance["value"] < $nearestPharmacyDistance["value"]) {
                $nearestPharmacyDistance = $pharmacyDistance;
                $nearestPharmacy = $pharmacy;
            }
        }

        return [
            "name"=>$nearestPharmacy->name,
            "address"=>$nearestPharmacy->address,
            "distance"=>$nearestPharmacyDistance["text"]
        ];
    }

    private function getRoadDirectionsDistanceFromGoogle($providedCoordinates, $pharmacyCoordinates) {
        $googleDirectionsApiUrl = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins="
            .$providedCoordinates."&destinations=".$pharmacyCoordinates."&key=AIzaSyD50R9hGC1dF5uYJZk-UQUxByfHlhqK9Lg";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $googleDirectionsApiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $distanceData = json_decode(curl_exec($ch), true);

        // Returns "value", an integer of Meters
        // and "text", a string of Miles
        return $distanceData["rows"][0]["elements"][0]["distance"];
    }
}


// {distance:,"rows":[{"elements":[{"distance":{"text":"78.9 mi","value":127051},"duration":{"text":"1 hour 18 mins","value":4650},"status":"OK"}]}],"status":"OK"}}
// r[0].el[0].dis
