<header id="gtco-header" class="gtco-cover gtco-cover-md" role="banner" style="background-image: url(images/tanahlot.jpg)">
	<div class="overlay"></div>
	<div class="gtco-container">
		<div class="row">
			<div class="col-md-12 col-md-offset-0 text-left">
				<div class="row row-mt-5em">
					<div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
						<h1>Planing Trip To Anywhere in Indonesia?</h1>
					</div>
					<div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
						<div class="form-wrap">
							<div class="tab">
								<div class="tab-content">
									<div class="tab-content-inner active" data-content="signup">
										<h3>Book Your Trip</h3>
										<form action="cari" method="GET">
											<div class="row form-group">
												<div class="col-md-12">
													<label for="fullname">Destination</label>
													<select name="destinasi" id="" class="form-control">
														<option value="">Select</option>
														@php
														
														$kota = DB::table('kota')->select('IdLokasi as Id','Nama')->orderBy('Nama')->get();

														@endphp
														@foreach($kota as $kota)
														<option value="{{$kota->Id}}">{{$kota->Nama}}</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="row form-group">
												<div class="col-md-12">
													<label for="activities">Product</label>
													<select name="tipe" id="tipe" class="form-control">
														<option value="">Select</option>
														<option value="Accommodation">Accommodation</option>
														<option value="Tours">Tours</option>
														<option value="Events">Events</option>
														<option value="Attractions">Attractions</option>
													</select>
												</div>
											</div>
											<div class="row form-group" id="other" style="display: none">
												<div class="col-md-12">
													<label for="date-start">Arrival</label>
													<input class="form-control datepicker" data-date-format="yyyy-mm-dd" name="date" id="date">
												</div>
											</div>
											<div class="row form-group" id="akomodasi" style="display: none">
												<div class="col-md-12">
													<label for="date-start">Arrival</label>
													<div class="input-group input-daterange">
												    	<input type="text" class="form-control" data-date-format="yyyy-mm-dd" name="start" id="start">
												    	<div class="input-group-addon">to</div>
												    	<input type="text" class="form-control" data-date-format="yyyy-mm-dd" name="end" id="end">
													</div>
												</div>
											</div>
											<div class="row form-group">
												<div class="col-md-12">
													<input type="submit" class="btn btn-primary btn-block" value="Submit">
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
