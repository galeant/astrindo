@include('header')
<div class="gtco-section">
	<div class="container">
		<div class="col-lg-6 col-md-6 col-sm-6">
			<a class="fh5co-card-item">
				<figure style="height: 290px">
					<div id="myCarousel" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner">
							@php
							$linkGambar = explode('|',$ListResult[0]->Gambar);
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
				<div class="fh5co-text" style="height: 300px">
					<h2>{{$ListResult[0]->Deskripsi}}</h2>
				</div>
			</a>
		</div>
		@foreach($ListResult as $result)
		<div class="col-lg-3 col-md-3 col-sm-6">
			<a class="fh5co-card-item" href="{{ URL('book',$result->IdProduct) }}">
				<figure style="height: 150px">
					<div class="overlay"><i class="ti-bag"></i></div>
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
				<div class="fh5co-text">
					<p style="font-size: 13px">{{$result->Nama}}</p>
					<h2>Rp.{{$result->Harga}}</h2>
				</div>
			</a>
		</div>
		@endforeach
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
@include('footer')