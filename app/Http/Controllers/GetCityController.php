<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kota;

class GetCityController extends Controller
{
	public function getCity()
	{
		$kode = '19a77830-a0e9-44b4-8bab-c1f49acf56fb';
		$provinsi = $this->callApi($kode);
		foreach($provinsi as $provinsi)
		{	
			$location = new Kota;
			$location->IdLokasi = $provinsi->Id;
			$location->Nama = $provinsi->Name;
			$location->Latitude = $provinsi->GPS->Lat;	
			$location->Longitude = $provinsi->GPS->Lng;	
			$location->save();

			$city = $this->callApi($provinsi->Id);
			foreach($city as $city)
			{
				$location = new Kota;
				$location->IdLokasi = $city->Id;
				$location->Nama = $city->Name;
				$location->Latitude = $city->GPS->Lat;	
				$location->Longitude = $city->GPS->Lng;	
				$location->save();				
			}
		}
		return view('home');
	}

    public function callApi($kode)
    {
    	$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://book.itx.co.id/v4/Services/EntityService.asmx",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?><soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\"><soap:Body><GetChildLocations xmlns=\"http://www.v3travel.com/CABS4/Services/EntityService\"><parentLocationId>".$kode."</parentLocationId></GetChildLocations><MaxResultsToReturn>9999</MaxResultsToReturn></soap:Body></soap:Envelope>",
			CURLOPT_HTTPHEADER => array(
				"Cache-Control: no-cache",
				"Content-Type: text/xml",
				"Postman-Token: 7cebcef0-8bd3-14cb-8054-0f19a499737e"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			$response1 = str_replace("<soap:Body>","",$response);
			$response2 = str_replace("</soap:Body>","",$response1);
			$parser = simplexml_load_string($response2);
			return $parser->GetChildLocationsResponse->GetChildLocationsResult->Location;
		}
    }
}