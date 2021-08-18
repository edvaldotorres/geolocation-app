<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class HotelController extends Controller
{

    public function index()
    {
        return view('home.index');
    }


    public function getNearbyHotels(Request $request)
    {
        $myLatitude = $request->latitude;
        $myLongitude = $request->longitude;

        $hotelsJson = file_get_contents('https://buzzvel-interviews.s3.eu-west-1.amazonaws.com/hotels.json');

        $hotelsResult = (array) json_decode($hotelsJson);

        foreach ($hotelsResult['message'] as $key => $hotel) {

            if (is_numeric($hotel[1])) {
                $latitudeHotel = $hotel[1];
                $logitudeHotel = $hotel[2];
            } elseif (is_numeric($hotel[2])) {
                $latitudeHotel = $hotel[2];
                $logitudeHotel = $hotel[3];
            } else {
                unset($hotelsResult['message'][$key]);
                continue;
            }

            $hotelsResult['message'][$key]['distance'] = $this->distance($myLatitude, $myLongitude, $latitudeHotel, $logitudeHotel);
        }

        $hotels = collect($hotelsResult['message'])->sortBy('distance');

        return view('home.index', compact('hotels'));
    }
}
