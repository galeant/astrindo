<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ketersediaan;
use App\Result;
use App\Product;
use DB;
use DateTime;

class SearchDataController extends Controller
{
	public function listProduct($tipe)
	{
		if($tipe == 'Accommodation')
		{
			$ListResult = DB::table('product')
			->groupBy('provider.Nama')
			->join('provider', 'product.IdProvider', '=', 'provider.IdProvider')
			->where('product.Tipe',$tipe)
			->get();
		}else{
			$ListResult = DB::table('product')
			->groupBy('service.Nama')
			->join('service', 'product.IdService', '=', 'service.IdService')
			->where('product.Tipe',$tipe)
			->get();
		}
		// $c = $ListResult[0]->Gambar;
		// dd($linkGambar = explode('|',$c));
		// dd($ListResult);
		return view('list',['ListResult' => $ListResult]);
	}

	public function searchData(Request $request)
	{
		DB::table('result')->delete();
		DB::table('ketersediaan')->delete();

		$tipe = $request->input('tipe');
		$tujuan = $request->input('destinasi');
		if($tipe == 'Accommodation')
		{
			$start = $request->input('start');
			$end = new DateTime($request->input('end'));

			if($start != null && $end != null){
				$date = new DateTime($start);
				$lama = $date->diff($end)->format("%d");
			}
		}else{
			$start = $request->input('date');	
		}
		$search = $this->callApiSearchLocation($start,$tujuan);
		foreach($search as $result)
		{
			foreach($result->Children->Entity as $result2)
			{
				if($result2->Availability->Calendar->DailyRates->DailyRateModel['IsAvailable'] != 'false')
				{
					$cek4 = Product::where('IdProduct', $result2['Id'])->count();
					if($cek4 != 0)
					{
						$cari = Product::where('IdProduct', $result2['Id'])->firstOrFail();
						$result = new Result;
						$result->IdProduct = $cari->IdProduct;
						$result->Nama = $cari->Nama;
						$result->save();
					}
				}
			}	
		}

		$listProvider = DB::table('provider')
            ->join('product', 'product.IdProvider', '=', 'provider.IdProvider')
            ->select(
            	'provider.Shortname',
            	'product.Tipe'
            )
            ->where('product.TIpe',$tipe)
            ->groupBy('provider.Shortname')
            ->get();

		foreach($listProvider as $provider)
		{
			if($provider->Tipe == 'Accommodation')
			{
				$sn = $provider->Shortname;
				$ketersediaan = $this->callApiAvailabilityAcomodation($start,$sn,$lama);
				$cek5 = Ketersediaan::where('shortname', $sn)->count();
				if($cek5 == 0)
				{
					if($ketersediaan != 0){
						foreach($ketersediaan as $sedia)
						{			
							$se = new Ketersediaan;
							$se->IdBook = $sedia['id'];
							$se->Nama = $sedia['name'];
							$se->Shortname = $sn;
							$se->Start = $sedia->Availability->Nights['start_date'];
							$se->End = $sedia->Availability->Nights['finish_date'];
							$se->Durasi = $lama;
							$se->Harga = $sedia->Availability->Nights['price'];
							$se->save();
						}
					}
				}
			}else if($provider->Tipe == 'Tours'){
				$sn = $provider->Shortname;
				$ketersediaan = $this->callApiAvailabilityActivity($start,$sn);
				$cek5 = Ketersediaan::where('Shortname', $sn)->count();
				if($cek5 == 0)
				{
					if($ketersediaan != 0){
						foreach($ketersediaan as $sedia)
						{			
							$se = new Ketersediaan;
							$se->IdBook = $sedia['id'];
							$se->Nama = $sedia['name'];
							$se->Shortname = $sn;
							$se->Start = $sedia->Availability->Nights['start_date'];
							$se->End = $sedia->Availability->Nights['finish_date'];
							$se->Durasi = $lama;
							$se->Harga = $sedia->Availability->Nights['price'];
							$se->save();
						}
					}
				}
			}else if($provider->Tipe == 'Events'){
				$sn = $provider->Shortname;
				$ketersediaan = $this->callApiAvailabilityEvents($start,$sn);
				$cek5 = Ketersediaan::where('Shortname', $sn)->count();
				if($cek5 == 0)
				{
					if($ketersediaan != 0){
						foreach($ketersediaan as $sedia)
						{			
							$se = new Ketersediaan;
							$se->IdBook = $sedia['id'];
							$se->Nama = $sedia['name'];
							$se->Shortname = $sn;
							$se->Start = $sedia->Availability->Nights['start_date'];
							$se->End = $sedia->Availability->Nights['finish_date'];
							$se->Durasi = $lama;
							$se->Harga = $sedia->Availability->Nights['price'];
							$se->save();
						}
					}
				}
			}else if($provider->Tipe == 'Attractions'){
				$sn = $provider->Shortname;
				$ketersediaan = $this->callApiAvailabilityAttractions($start,$sn);
				$cek5 = Ketersediaan::where('Shortname', $sn)->count();
				if($cek5 == 0)
				{
					if($ketersediaan != 0){
						foreach($ketersediaan as $sedia)
						{			
							$se = new Ketersediaan;
							$se->IdBook = $sedia['id'];
							$se->Nama = $sedia['name'];
							$se->Shortname = $sn;
							$se->Start = $sedia->Availability->Nights['start_date'];
							$se->End = $sedia->Availability->Nights['finish_date'];
							$se->Durasi = $lama;
							$se->Harga = $sedia->Availability->Nights['price'];
							$se->save();
						}
					}
				}
			}else{
				return 'tidak ada dalam tipe';
			}
		}

		$ListResult = DB::table('product')
			->groupBy('IdService')
			->join('result', 'result.IdProduct', '=', 'product.IdProduct')
			->join('service', 'product.IdService', '=', 'service.IdService')
			->join('ketersediaan', 'ketersediaan.IdBook', '=', 'product.IdBook')
			->select( 
				'product.IdService',
				'ketersediaan.Start',
				'ketersediaan.End',
				'ketersediaan.shortname',
				'service.Nama as Nama',
				'product.gambar',
				DB::raw('min(ketersediaan.Harga) as Termurah')
			)
			->where('product.Tipe',$tipe)
			->get();
		
		return view('list',[
			'ListResult' => $ListResult
		]);
	}

	public function detail($id)
	{
		$ListResult = DB::table('product')
			->join('result', 'result.IdProduct', '=', 'product.IdProduct')
			->join('service', 'product.IdService', '=', 'service.IdService')
			->join('ketersediaan', 'ketersediaan.IdBook', '=', 'product.IdBook')
			->select( 
				'service.Nama as nama_service',
				'service.Nama as deskripsi_service',
				'product.IdProduct',
				'product.Nama as Nama',
				'product.Gambar',
				'product.Deskripsi',
				'ketersediaan.Harga'
			)
			->where('product.IdService',$id)
			->get();

		return view('detail',['ListResult' => $ListResult]);
	}

    public function callApiSearchLocation($tgl,$tujuan)
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
		  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?><soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"><soap:Body><Search xmlns=\"http://www.v3travel.com/CABS4/Services/EntityService\"><EntitySearch_RQ Shortname=\"jk_astrindo\" xmlns=\"http://www.v3travel.com/CABS4/Services/EntityService/Models\"><Availability MergeMethod=\"NoMerge\"><Specific Date=\"".$tgl."\" Duration=\"2\" /></Availability><Filter Type=\"Service\" MustBeInAdCampaign=\"true\" MustBeInDealCampaign=\"true\"><Geolocation MustHaveGeocode=\"false\"><LocationIds><LocationId>".$tujuan."</LocationId></LocationIds></Geolocation></Filter><Output AdvancedContent=\"false\" Features=\"false\" Settings=\"false\"><CommonContent Name=\"true\" Description=\"false\" Images=\"false\" Capabilities=\"false\" IndustryCategories=\"false\" /><Children><Filter Type=\"Unspecified\" MustBeInAdCampaign=\"false\" MustBeInDealCampaign=\"false\"><Names /></Filter><Output AdvancedContent=\"true\" Features=\"false\" Settings=\"false\"><Availability StartDate=\"".$tgl."\" NumberOfDays=\"1\" FlagCampaign=\"true\" LowestRateOnly=\"false\" MergeMethod=\"LowestRate\" /><CommonContent Name=\"true\" Description=\"false\" Images=\"false\" Capabilities=\"false\" IndustryCategories=\"true\" /></Output></Children></Output></EntitySearch_RQ></Search></soap:Body></soap:Envelope>",
		  CURLOPT_HTTPHEADER => array(
		    "Cache-Control: no-cache",
		    "Content-Type: text/xml",
		    "Postman-Token: 2b6a8174-b93a-6bb4-5ddb-6c14897d7642"
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
			return $parser->SearchResponse->EntitySearch_RS->Entities->Entity;
		}
    }
    public function callApiAvailabilityAcomodation($tgl, $sn, $lama)
    {
    	$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://apis.itx.co.id/CABS.Webservices/SearchService.asmx",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?><soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"><soap:Body><CABS_ProductAvailability_RQ xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_ProductAvailability_RQ.xsd\"><Channels><DistributionChannelRQ id=\"jk_astrindo\" key=\"805E60B4-B764-45F8-939A-DDFC50BD228A\" xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\" /></Channels><Providers><ProviderRQ short_name=\"".$sn."\" xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\" /></Providers><Query><IndustryCategory xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\">Accommodation</IndustryCategory><IndustryCategoryGroup xmlns=\"\">Accommodation</IndustryCategoryGroup><SearchCriteria xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\"><LengthNights minimum=\"".$lama."\" maximum=\"".$lama."\" /><CommencingSpecific date=\"".$tgl."\" /><Consumers><Consumer adults=\"1\" children=\"0\" concessions=\"0\" /></Consumers></SearchCriteria></Query></CABS_ProductAvailability_RQ></soap:Body></soap:Envelope>",
		  CURLOPT_HTTPHEADER => array(
		    "Cache-Control: no-cache",
		    "Content-Type: text/xml",
		    "Postman-Token: 21d0a43c-d3cd-3b04-a830-2727c285a4fa"
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
			$array = array();
			foreach($parser->CABS_ProductAvailability_RS->Channels->PA_DistributionChannelRSType->Providers->Provider as $k => $v) {
				$array[$k] = $v;
			}
			// dd($array);
			if(count($array)!=0){
				return $parser->CABS_ProductAvailability_RS->Channels->PA_DistributionChannelRSType->Providers->Provider->ProductGroups->ProductGroup->Products->Product;
			}else{
				return '0';
			}
			
		}
    }
    public function callApiAvailabilityActivity($tgl, $sn)
    {
    	$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://apis.itx.co.id/CABS.Webservices/SearchService.asmx",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?><soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"><soap:Body><CABS_ProductAvailability_RQ xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_ProductAvailability_RQ.xsd\"><Channels><DistributionChannelRQ id=\"jk_astrindo\" key=\"805E60B4-B764-45F8-939A-DDFC50BD228A\" xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\" /></Channels><Providers><ProviderRQ short_name=\"".$sn."\" xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\" /></Providers><Query><IndustryCategory xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\">Tours</IndustryCategory><IndustryCategoryGroup xmlns=\"\">Activities</IndustryCategoryGroup><SearchCriteria xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\"><LengthDays /><CommencingSpecific date=\"".$tgl."\" /><Consumers><Consumer adults=\"1\" children=\"0\" concessions=\"0\" /></Consumers></SearchCriteria></Query></CABS_ProductAvailability_RQ></soap:Body></soap:Envelope>",
		  CURLOPT_HTTPHEADER => array(
		    "Cache-Control: no-cache",
		    "Content-Type: text/xml",
		    "Postman-Token: 053e90cd-3f88-e2f4-7ef9-2904a1086758"
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
			$array = array();
			foreach($parser->CABS_ProductAvailability_RS->Channels->PA_DistributionChannelRSType->Providers->Provider as $k => $v) {
				$array[$k] = $v;
			}
			// dd($array);
			if(count($array)!=0){
				return $parser->CABS_ProductAvailability_RS->Channels->PA_DistributionChannelRSType->Providers->Provider->ProductGroups->ProductGroup->Products->Product;
			}else{
				return '0';
			}
		}
	}
	public function callApiAvailabilityEvents($tgl, $sn)
    {
    	$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://apis.itx.co.id/CABS.Webservices/SearchService.asmx",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?><soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"><soap:Body><CABS_ProductAvailability_RQ xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_ProductAvailability_RQ.xsd\"><Channels><DistributionChannelRQ id=\"jk_astrindo\" key=\"805E60B4-B764-45F8-939A-DDFC50BD228A\" xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\" /></Channels><Providers><ProviderRQ short_name=\"".$sn."\" xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\" /></Providers><Query><IndustryCategory xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\">Events</IndustryCategory><IndustryCategoryGroup xmlns=\"\">Activities</IndustryCategoryGroup><SearchCriteria xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\"><LengthDays /><CommencingSpecific date=\"".$tgl."\" /><Consumers><Consumer adults=\"1\" children=\"0\" concessions=\"0\" /></Consumers></SearchCriteria></Query></CABS_ProductAvailability_RQ></soap:Body></soap:Envelope>",
		  CURLOPT_HTTPHEADER => array(
		    "Cache-Control: no-cache",
		    "Content-Type: text/xml",
		    "Postman-Token: 053e90cd-3f88-e2f4-7ef9-2904a1086758"
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
			$parser->CABS_ProductAvailability_RS->Channels->PA_DistributionChannelRSType->Providers->Provider;
			$array = array();
			foreach($parser->CABS_ProductAvailability_RS->Channels->PA_DistributionChannelRSType->Providers->Provider as $k => $v) {
				$array[$k] = $v;
			 }
			// dd($array);
			if(count($array)!=0){
				return $parser->CABS_ProductAvailability_RS->Channels->PA_DistributionChannelRSType->Providers->Provider->ProductGroups->ProductGroup->Products->Product;
			}else{
				return '0';
			}
		}
	}
	public function callApiAvailabilityAttractions($tgl, $sn)
    {
    	$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://apis.itx.co.id/CABS.Webservices/SearchService.asmx",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?><soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"><soap:Body><CABS_ProductAvailability_RQ xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_ProductAvailability_RQ.xsd\"><Channels><DistributionChannelRQ id=\"jk_astrindo\" key=\"805E60B4-B764-45F8-939A-DDFC50BD228A\" xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\" /></Channels><Providers><ProviderRQ short_name=\"".$sn."\" xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\" /></Providers><Query><IndustryCategory xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\">Attraction</IndustryCategory><IndustryCategoryGroup xmlns=\"\">Activities</IndustryCategoryGroup><SearchCriteria xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\"><LengthDays /><CommencingSpecific date=\"".$tgl."\" /><Consumers><Consumer adults=\"1\" children=\"0\" concessions=\"0\" /></Consumers></SearchCriteria></Query></CABS_ProductAvailability_RQ></soap:Body></soap:Envelope>",
		  CURLOPT_HTTPHEADER => array(
		    "Cache-Control: no-cache",
		    "Content-Type: text/xml",
		    "Postman-Token: 053e90cd-3f88-e2f4-7ef9-2904a1086758"
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
			$array = array();
			foreach($parser->CABS_ProductAvailability_RS->Channels->PA_DistributionChannelRSType->Providers->Provider as $k => $v) {
				$array[$k] = $v;
			 }
			// dd($array);
			if(count($array)!=0){
				return $parser->CABS_ProductAvailability_RS->Channels->PA_DistributionChannelRSType->Providers->Provider->ProductGroups->ProductGroup->Products->Product;
			}else{
				return '0';
			}
		}
    }
}
