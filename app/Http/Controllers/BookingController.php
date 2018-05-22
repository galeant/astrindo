<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BookingController extends Controller
{
	public function booking($id)
	{
		$ListResult = DB::table('product')
			->join('result', 'result.IdProduct', '=', 'product.IdProduct')
			->join('ketersediaan', 'ketersediaan.IdBook', '=', 'product.IdBook')
			->join('provider', 'provider.IdProvider', '=', 'product.IdProvider')
			->select( 
				'product.IdBook',
				'product.Nama as Nama',
				'product.Gambar',
				'product.Deskripsi',
				'product.Tipe',
				'provider.Shortname',
				'ketersediaan.start',
				'ketersediaan.end',
				'ketersediaan.durasi',
				'ketersediaan.Harga'
			)
			->where('product.IdProduct',$id)
			->get();
		return view('booking',['ListResult' => $ListResult]);	
	}
	public function bookingProcess(Request $request)
	{
		$client_id = $this->generateClientId(8).'-'.$this->generateClientId(4).'-'.$this->generateClientId(4).'-'.$this->generateClientId(4).'-'.$this->generateClientId(12);

		$type  = $request->input('tipe');
		$shortname = $request->input('shortname');
		$idProduct = $request->input('idProduct');
		$namaProduct = $request->input('namaProduct');
		$start = $request->input('start');
		$end = $request->input('end');
		$harga = $request->input('harga');
		$title = $request->input('title');
		$prefix = $request->input('prefix');
		$sufix = $request->input('sufix');
		$permintaan = $request->input('permintaan');

		$permintaan = $request->input('permintaan');
		$reserver = $this->callApiBooking($client_id,$type,$shortname,$idProduct,$namaProduct,$start,$end,$harga,$title,$prefix,$sufix,$permintaan);
		// dd($reserver);

		$res = new Reservation;
		$res->IdReservasi = $reserver->Reservation->ReservationID;
		$res->Pemesan = $title.' '.$prefix.' '.$sufix;
		$res->IdBook = $idProduct;
		$res->NamaProduct = $namaProduct;
		$res->Kontak = $request->input('kontak');
		$res->Email = $request->input('email');
		$res->Durasi = $request->input('durasi');
		$res->Start = $start;
		$res->End = $end;
		$res->Harga = $harga;
		$res->Permintaan = $permintaan;
		$res->Status = $reserver->Reservation->BookingStatus;
		$res->BookInfo = $reserver->Reservation->NotesToCustomer->PlainText;
		$res->save();
		
		// dd($reserver);
		// return view('main.info', ['IdReservasi' => $reserver->Reservation->ReservationID]);
	}
    public function generateClientId($panjang)
	{
		$karakter= 'abcdef1234567890';
		$string = '';
		for ($i = 0; $i < $panjang; $i++) {
			$pos = rand(0, strlen($karakter)-1);
			$string .= $karakter{$pos};
		}
		return $string;
	}
	public function callApiBooking($client_id,$type,$shortname,$idProduct,$namaProduct,$start,$end,$harga,$title,$prefix,$sufix,$permintaan)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://apis.itx.co.id/CABS.Webservices/BookingService.asmx",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?><soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"><soap:Body><CABS_Booking_RQ xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.2/CABS_Booking_RQ.xsd\"><DistributionChannelRQ id=\"jk_astrindo\" key=\"805E60B4-B764-45F8-939A-DDFC50BD228A\" xmlns=\"\" /><Reservations xmlns=\"\"><Reservation client_id=\"".$client_id."\"><IndustryCategory type=\"".$type."\" /><Provider short_name=\"".$shortname."\" /><ProductDetails><Product num_adult=\"1\" num_children=\"0\" num_concession=\"0\" id=\"".$idProduct."\" name=\"".$namaProduct."\" start_date=\"".$start."\" finish_date=\"".$end."\" price=\"".$harga."\" /></ProductDetails><CustomerDetails><PersonName prefix=\"".$title."\" given_name=\"".$prefix."\" surname=\"".$sufix."\" /><Contact xsi:nil=\"true\" /><CustPreferences><MarketingPreferences xsi:nil=\"true\" /><OtherPreferences><Preference name=\"SpecialRequests\" value=\"".$permintaan."\" /></OtherPreferences></CustPreferences></CustomerDetails><PaymentDetails><PaymentType value=\"OnAccount\" /><PaymentAmount total=\"".$harga."\" customer_paid_distributor=\"".$harga."\" customer_paid_provider=\"0\" /><PaymentCard xsi:nil=\"true\" /><PayPal xsi:nil=\"true\" /></PaymentDetails></Reservation></Reservations></CABS_Booking_RQ></soap:Body></soap:Envelope>",
		  CURLOPT_HTTPHEADER => array(
		    "Cache-Control: no-cache",
		    "Content-Type: text/xml",
		    "Postman-Token: de942b23-fd5a-0f5b-db52-672fb4e737b0"
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
			dd($parser = simplexml_load_string($response2));
			return $parser->CABS_Booking_RS->Reservations;
		}
	}
	public function callApiDecline($IdReservasi,$client_id)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://apis.itx.co.id/CABS.Webservices/BookingService.asmx",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?><soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"><soap:Body><CABS_BookingStatus_RQ xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.2/CABS_ConfirmCancelBooking_RQ.xsd\"><DistributionChannelRQ id=\"jk_astrindo\" key=\"805E60B4-B764-45F8-939A-DDFC50BD228A\" xmlns=\"\" /><Reservations xmlns=\"\"><Reservation client_id=\"".$client_id."\"><ReservationID>".$IdReservasi."</ReservationID></Reservation></Reservations></CABS_BookingStatus_RQ></soap:Body></soap:Envelope>",
		  CURLOPT_HTTPHEADER => array(
		    "Cache-Control: no-cache",
		    "Content-Type: text/xml",
		    "Postman-Token: 7a794d34-8516-fcef-0e3f-50dcab8bec6d",
		    "SOAPAction: http://www.v3leisure.com/CABS/V3Leisure.CABS.Services.WebServices/DeclineBooking"
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
			return $parser;
		}
	}
	public function callApiConfirm($IdReservasi,$client_id)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://apis.itx.co.id/CABS.Webservices/BookingService.asmx",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?><soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"><soap:Body><CABS_BookingStatus_RQ xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.2/CABS_ConfirmCancelBooking_RQ.xsd\"><DistributionChannelRQ id=\"jk_astrindo\" key=\"805E60B4-B764-45F8-939A-DDFC50BD228A\" xmlns=\"\" /><Reservations xmlns=\"\"><Reservation client_id=\"".$client_id."\"><ReservationID>".$IdReservasi."</ReservationID></Reservation></Reservations></CABS_BookingStatus_RQ></soap:Body></soap:Envelope>",
		  CURLOPT_HTTPHEADER => array(
		    "Cache-Control: no-cache",
		    "Content-Type: text/xml",
		    "Postman-Token: 7a794d34-8516-fcef-0e3f-50dcab8bec6d",
		    "SOAPAction: http://www.v3leisure.com/CABS/V3Leisure.CABS.Services.WebServices/ConfirmBooking"
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
			return $parser;
		}
	}
	public function callApiCancel($IdReservasi,$client_id)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://apis.itx.co.id/CABS.Webservices/BookingService.asmx",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?><soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"><soap:Body><CABS_BookingStatus_RQ xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.2/CABS_ConfirmCancelBooking_RQ.xsd\"><DistributionChannelRQ id=\"jk_astrindo\" key=\"805E60B4-B764-45F8-939A-DDFC50BD228A\" xmlns=\"\" /><Reservations xmlns=\"\"><Reservation client_id=\"".$client_id."\"><ReservationID>".$IdReservasi."</ReservationID></Reservation></Reservations></CABS_BookingStatus_RQ></soap:Body></soap:Envelope>",
		  CURLOPT_HTTPHEADER => array(
		    "Cache-Control: no-cache",
		    "Content-Type: text/xml",
		    "Postman-Token: 7a794d34-8516-fcef-0e3f-50dcab8bec6d",
		    "SOAPAction: http://www.v3leisure.com/CABS/V3Leisure.CABS.Services.WebServices/CancelBooking"
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
			return $parser;
		}
	}
	public function callApiStatus($IdReservasi,$client_id)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://apis.itx.co.id/CABS.Webservices/BookingService.asmx",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "<?xml version=\"1.0\" encoding=\"utf-8\"?><soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"><soap:Body><CABS_BookingStatus_RQ xmlns=\"http://www.v3leisure.com/Schemas/CABS/1.2/CABS_ConfirmCancelBooking_RQ.xsd\"><DistributionChannelRQ id=\"jk_astrindo\" key=\"805E60B4-B764-45F8-939A-DDFC50BD228A\" xmlns=\"\" /><Reservations xmlns=\"\"><Reservation client_id=\"".$client_id."\"><ReservationID>".$IdReservasi."</ReservationID></Reservation></Reservations></CABS_BookingStatus_RQ></soap:Body></soap:Envelope>",
		  CURLOPT_HTTPHEADER => array(
		    "Cache-Control: no-cache",
		    "Content-Type: text/xml",
		    "Postman-Token: 7a794d34-8516-fcef-0e3f-50dcab8bec6d",
		    "SOAPAction: http://www.v3leisure.com/CABS/V3Leisure.CABS.Services.WebServices/GetBookingStatus"
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
			return $parser;
		}
	}
}
