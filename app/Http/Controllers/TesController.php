<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TesController extends Controller
{
    public function index()
    {
    	/*$client = new client();
    	$response = $client->request('GET','https://api.rajaongkir.com/starter/province?id=12',[
		    'headers' => [
    			'key' => '9b63943a45fd67f133446e060d52eead'
		    ]
		]);

		$body = $response->getBody();
		// Implicitly cast the body to a string and echo it
		dd(json_decode($body));
		*/
		
		$client = new client();
    	$response = $client->request('POST','http://book.itx.co.id/v4/Services/EntityService.asmx',[
		    'headers' => [
    			// 'key' => '9b63943a45fd67f133446e060d52eead'
    			'Cache-Control' => 'no-cache',
			    'Content-Type' => 'text/xml',
			    'Postman-Token' => 'd35f9299-30ba-94c8-ec19-d63f2a2bda32'
		    ],
		    'body' => "<?xml version=\"1.0\" encoding=\"utf-8\"?><soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\"><soap:Body><GetChildLocations xmlns=\"http://www.v3travel.com/CABS4/Services/EntityService\"><parentLocationId>19a77830-a0e9-44b4-8bab-c1f49acf56fb</parentLocationId></GetChildLocations><MaxResultsToReturn>9999</MaxResultsToReturn></soap:Body></soap:Envelope>"
		]);

		$body = $response->getBody();
		dd($response = $this->parser($body));
		// Implicitly cast the body to a string and echo it
		// echo $body;
		// $simple = "<para><note>simple note</note></para>";
		// $p = xml_parser_create();
		// xml_parse_into_struct($p, $body, $vals, $index);
		// xml_parser_free($p);
		// // echo "Index array\n";
		// echo '<pre>';
		// // print_r($index);
		// echo "\nVals array\n";
		// print_r($vals);
		// echo '</pre>';
    }
    public function parser($response)
    {
    	$response1 = str_replace("<soap:Body>","",$response);
		$response2 = str_replace("</soap:Body>","",$response1);
		return simplexml_load_string($response2);
    }
}
