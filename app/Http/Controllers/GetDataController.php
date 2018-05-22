<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provider;
use App\Service;
use App\Product;

class GetDataController extends Controller
{
	public function getData()
	{
		$providers = $this->callApiProvider();
		foreach($providers as $provider)
		{	
			$cek1 = Provider::where('IdProvider', $provider['id'])->count();
			if($cek1 == 0)
			{
				$prov = new Provider;
				$prov->IdProvider = $provider['id'];
				$prov->Shortname = $provider['short_name'];
				$prov->Nama = $provider['full_name'];
				$prov->Deskripsi = $provider->Description;
				$prov->Alamat = $provider->ContactDetails->AddressDetails['address_1'];
				$prov->Kota = $provider->ContactDetails->AddressDetails['city'];
				$prov->Provinsi = $provider->ContactDetails->AddressDetails['state'];
				$prov->KodePos = $provider->ContactDetails->AddressDetails['post_code'];
				$prov->Telepon = $provider->ContactDetails->MainPhone['area_code'].$provider->ContactDetails->MainPhone['number'];
				$prov->Email = $provider->ContactDetails->PublicEmail['email_address'];
				$prov->save();

				foreach($provider->Products->Product as $product)
				{
					
					$cek2 = Product::where('IdProduct', $product['id'])->count();
					if($cek2 == 0)
					{
						$gambar = '';
						foreach($product->Images->Image as $gmb)
						{
							$gambar .= '|http://book.itx.co.id'.$gmb['relative_url'];    
						}

						$prod = new Product;
						$prod->IdProduct = $product['id'];
						$prod->IdBook = $product['obx_id'];
						$prod->Nama = $product['name'];
						$prod->Tipe = '';
						$prod->Deskripsi = $product->Description;
						$prod->Gambar = $gambar;
						$prod->IdService = '';
						$prod->IdProvider = $provider['id'];
						$prod->save();	
					}else{

						$gambar = '';
						foreach($product->Images->Image as $gmb)
						{
							$gambar .= '|http://book.itx.co.id'.$gmb['relative_url'];    
						}

						Product::where('IdProduct',$product['Id'])->update([
							'Nama' => $product['name'],
							'Deskripsi' =>  $product->Description,
							'Gambar' => $gambar
						]);	
					}
				}
			}else{
				Provider::where('IdProvider',$provider['id'])->update([
					'Nama' => $provider['full_name'],
					'Alamat' =>  $provider->ContactDetails->AddressDetails['address_1'],
					'Kota' => $provider->ContactDetails->AddressDetails['city'],
					'Provinsi' => $provider->ContactDetails->AddressDetails['state'],
					'KodePos' => $provider->ContactDetails->AddressDetails['post_code'],
					'Telepon' => $provider->ContactDetails->MainPhone['area_code'].$provider->ContactDetails->MainPhone['number'],
					'Email' => $provider->ContactDetails->PublicEmail['email_address'],
				]);	
				foreach($provider->Products->Product as $product)
				{
					$cek2 = Product::where('IdProduct', $product['id'])->count();
					if($cek2 == 0)
					{
						$gambar = '';
						foreach($product->Images->Image as $gmb)
						{
							$gambar .= '|http://book.itx.co.id'.$gmb['relative_url'];    
						}

						$prod = new Product;
						$prod->IdProduct = $product['id'];
						$prod->IdBook = $product['obx_id'];
						$prod->Nama = $product['name'];
						$prod->Tipe = '';
						$prod->Deskripsi = $product->Description;
						$prod->Gambar = $gambar;
						$prod->IdService = '';
						$prod->IdProvider = $provider['id'];
						$prod->save();	
					}else{

						$gambar = '';
						foreach($product->Images->Image as $gmb)
						{
							$gambar .= '|http://book.itx.co.id'.$gmb['relative_url'];    
						}

						Product::where('IdProduct',$product['Id'])->update([
							'Nama' => $product['name'],
							'Deskripsi' =>  $product->Description,
							'Gambar' => $gambar
						]);	
					}
				}
			}
		}

		$entity = $this->callApiService();
		foreach($entity as $service)
		{
			$cek3 = Service::where('IdService', $service['Id'])->count();
			if($cek3 == 0)
			{
				$se = new Service;
				$se->IdService = $service['Id'];
				$se->Nama = $service['Name'];
				$se->Deskripsi = $service->LongDescription;
				$se->IdProvider = $service['ParentId'];
				$se->save();
			}else{
				Service::where('IdService',$service['Id'])->update([
					'Nama' => $service['Name'],
					'Deskripsi' =>  $service->LongDescription
				]);	
			}
			

			foreach($service->Children->Entity as $product2)
			{
				Product::where('IdProduct',$product2['Id'])->update([
					'Tipe' => $product2->IndustryCategory,
					'IdService' => $service['Id']
				]);	
			}
		}
		return view('home');
	}
	
    public function callApiProvider()
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
		  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?><soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"><soap:Body><CABS_ProviderSearch_RQ xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_ProviderSearch_RQ.xsd\"><Channels><CO_DistributionChannelRQType id=\"jk_astrindo\" key=\"805E60B4-B764-45F8-939A-DDFC50BD228A\" /></Channels><Query><SearchGroup xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\" /></Query><Response><IncludeContactDetails include=\"true\" xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\" /><IncludeDescription include=\"true\" xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\" /><IncludeProducts include=\"true\" xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\" /><IncludeProductDescription include=\"true\" xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\" /><IncludeProductImages include=\"true\" xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.0/CABS_Common.xsd\" /></Response></CABS_ProviderSearch_RQ></soap:Body></soap:Envelope>",
		  CURLOPT_HTTPHEADER => array(
		    "Cache-Control: no-cache",
		    "Content-Type: text/xml",
		    "Postman-Token: 2b02da08-50e5-6aa9-7316-24cd4df6b09f"
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
			return $parser->CABS_ProviderSearch_RS->Channels->Channel->Providers->Provider;
		}
    }
    public function callApiService()
    {
    	$idlocation = '401d4920-7acb-47ea-aeb5-5024e365a87f';

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://book.itx.co.id/v4/Services/EntityService.asmx",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?><soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"><soap:Body><Search xmlns=\"http://www.v3travel.com/CABS4/Services/EntityService\"><EntitySearch_RQ Shortname=\"jk_astrindo\" xmlns=\"http://www.v3travel.com/CABS4/Services/EntityService/Models\"><Filter Type=\"Service\" MustBeInAdCampaign=\"true\" MustBeInDealCampaign=\"true\" /><Output AdvancedContent=\"false\" Features=\"false\" Settings=\"false\"><CommonContent Name=\"true\" Description=\"true\" Images=\"false\" Capabilities=\"false\" IndustryCategories=\"false\" /><Children><Filter Type=\"Unspecified\" MustBeInAdCampaign=\"false\" MustBeInDealCampaign=\"false\"><Names /></Filter><Output AdvancedContent=\"true\" Features=\"false\" Settings=\"false\"><CommonContent Name=\"true\" Description=\"false\" Images=\"false\" Capabilities=\"false\" IndustryCategories=\"true\" /></Output></Children></Output></EntitySearch_RQ></Search></soap:Body></soap:Envelope>",
		  CURLOPT_HTTPHEADER => array(
		    "Cache-Control: no-cache",
		    "Content-Type: text/xml",
		    "Postman-Token: 255735bf-25bc-fa28-b3eb-91d52fa67a4b"
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
}
