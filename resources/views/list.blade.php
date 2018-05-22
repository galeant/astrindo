@include('header')
<div class="gtco-section">
	<div class="gtco-container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 text-center gtco-heading">
				<h2>Best Value Trips</h2>
				<p>Best Offer Trips From Us.</p>
			</div>
		</div>
		<div class="row">
			@foreach($ListResult as $result)
			<div class="col-lg-4 col-md-4 col-sm-6">
				<a href ="{{ URL('detail',$result->IdService) }}" class="fh5co-card-item">
					<figure>
						<div class="overlay"><i class="ti-plus"></i></div>
						<div id="myCarousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								@php
								$linkGambar = explode('|',$result->Gambar);
								$j = count($linkGambar);
								@endphp
								<div class="item active">
									<img src="{{$linkGambar[$j-1]}}" alt="Image" class="img-responsive" style="position: center; width:100%;">
								</div>
								@for($i=1;$i<$j;$i++)
								<div class="item">
									<img src="{{$linkGambar[$i]}}" alt="Image" class="img-responsive" style="position: center; width:100%;">
								</div>
								@endfor
							</div>
						</div>
					</figure>
					<div class="fh5co-text" style="height: 100px">
						<h2>{{$result->Nama}}</h2>
					</div>
				</a>
			</div>
			@endforeach
		</div>
	</div>
</div>
<div id="gtco-features">
	<div class="gtco-container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 text-center gtco-heading animate-box">
				<h2>Why Choose Us</h2>
				<p>Here are respons you should plan with us.</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 col-sm-6">
				<div class="feature-center animate-box" data-animate-effect="fadeIn">
					<img src="{{ URL::asset('images/QUALITY.jpg') }}" class="img-circle">
					<h3>SERVICE QUALITY</h3>
					<p>Memberikan pelayanan terbaik <br/>sesuai dengan moto kami <br/> "Your Satisfaction Is Our Pleasure"</p>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="feature-center animate-box" data-animate-effect="fadeIn">
					<img src="{{ URL::asset('images/EASY.jpg') }}" class="img-circle">
					<h3>EASY AND CONVINIENT</h3>
					<p>Dengan didukung teknologi terintegrasi <br/> anda tidak perlu cemas, karena transaksi<br/> perjalnan anda dijamin memberikan akses<br/>dengan kemudahan pelayanan dan harga yang lebih efisien</p>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="feature-center animate-box" data-animate-effect="fadeIn">
					<img src="{{ URL::asset('images/24J.jpg') }}" class="img-circle">
						<h3>24 Hours Services</h3>
						<p>Jika anda memiliki kesulitan, kami memberikan layanan akses 24 Jam setiap harinya untuk membantu anda<br/>Telepon : <b>0804 1888 111</b></p>
					</div>
				</div>


			</div>
		</div>
	</div>
	<div id="gtco-counter" class="gtco-section">
		<div class="gtco-container">

			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center gtco-heading animate-box">
					<h2>Our Succes</h2>
					<p>Terima Kasih Atas Kepercayaan Anda</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
					<div class="feature-center">
						<span class="counter js-counter" data-from="0" data-to="196" data-speed="5000" data-refresh-interval="50">1</span>
						<span class="counter-label">Tour</span>

					</div>
				</div>
				<div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
					<div class="feature-center">
						<span class="counter js-counter" data-from="0" data-to="97" data-speed="5000" data-refresh-interval="50">1</span>
						<span class="counter-label">Event</span>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
					<div class="feature-center">
						<span class="counter js-counter" data-from="0" data-to="12402" data-speed="5000" data-refresh-interval="50">1</span>
						<span class="counter-label">Accomodation</span>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
					<div class="feature-center">
						<span class="counter js-counter" data-from="0" data-to="12202" data-speed="5000" data-refresh-interval="50">1</span>
						<span class="counter-label">Attraction</span>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="gtco-subscribe">
		<div class="gtco-container">
			<div class="row animate-box">
				<div class="col-md-8 col-md-offset-2 text-center gtco-heading">
					<h2>Subscribe</h2>
					<p>Be the first to know about the new promo.</p>
				</div>
			</div>
			<div class="row animate-box">
				<div class="col-md-8 col-md-offset-2">
					<form class="form-inline">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label for="email" class="sr-only">Email</label>
								<input type="email" class="form-control" id="email" placeholder="Your Email">
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<button type="submit" class="btn btn-default btn-block">Subscribe</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@include('footer')