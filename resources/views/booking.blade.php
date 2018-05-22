@include('header')
<div id="gtco-header" class="gtco-cover gtco-cover-md" role="banner" style="background-image: url(assets/images/tanahlot.jpg)">
	<div class="overlay"></div>
	<div class="gtco-container">
		<div class="row">
			<div class="col-md-12 col-md-offset-0 text-left">
				<div class="row row-mt-5em">
					<div class="col-md-6 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
						<div class="form-wrap">
							<div class="tab">
								<div class="tab-content">
									
									<form action="process" method="POST">
										{{ csrf_field() }}
										<input type="hidden" name="idProduct" class="form-control" value="{{$ListResult[0]->IdBook}}" readonly>
										<input type="hidden" name="shortname" class="form-control" value="{{$ListResult[0]->Shortname}}" readonly>
										<input type="hidden" name="tipe" class="form-control" value="{{$ListResult[0]->Tipe}}" readonly>
										<div class="row form-group">
											<div class="col-md-12">
												<label for="title">Nama Product</label>
												<input type="text" name="namaProduct" class="form-control" value="{{$ListResult[0]->Nama}}" readonly>
											</div>
										</div>
										@if($ListResult[0]->Tipe == 'Accommodation')
										<div class="row form-group">
											<div class="col-md-12">
												<label for="Nama" id="nama">Durasi</label>
												<input type="text" name="durasi" class="form-control"
												value="{{$ListResult[0]->durasi}}" readonly>
											</div>
										</div>
										@endif
										<div class="row form-group">
											<div class="col-md-12">
												<label for="check_out">Mulai</label>
												<input type="text" name="start" class="form-control" value="{{$ListResult[0]->start}}" readonly>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-md-12">
												<label for="check_out">Selesai</label>
												<input type="text" name="end" class="form-control" value="{{$ListResult[0]->end}}" readonly>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-md-12">
												<label for="check_out">Harga</label>
												<input type="text" name="harga" class="form-control" value="{{$ListResult[0]->Harga}}" readonly>
											</div>
										</div>										
									</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
						<div class="form-wrap">
							<div class="tab">
								<div class="tab-content">
									<div class="tab-content-inner active" data-content="signup">
										<h3>Book Your Trip</h3>
										
											<div class="row form-group">
												<div class="col-md-12">
													<label for="title">Title</label>
													<select name="title" id="title" class="form-control">
														<option value="Tn">Tuan</option>
														<option value="Ny">Nyonya</option>
													</select>
												</div>
											</div>
											<div class="row form-group">
												<div class="col-md-12">
													<label for="Nama" id="nama">Nama Depan</label>
													<input type="text" name="prefix" class="form-control">
												</div>
											</div>
											<div class="row form-group">
												<div class="col-md-12">
													<label for="check_out">Nama Belakang</label>
													<input type="text" name="sufix" class="form-control">
												</div>
											</div>
											<div class="row form-group">
												<div class="col-md-12">
													<label for="check_out">Permintaan Khusus</label>
													<input type="text" name="permintaan" class="form-control">
												</div>
											</div>
											<div class="row form-group">
												<div class="col-md-12">
													<label for="check_out">Kontak</label>
													<input type="text" name="kontak" class="form-control" placeholder="No.HP">
												</div>
											</div>
											<div class="row form-group">
												<div class="col-md-12">
													<label for="check_out">Email</label>
													<input type="text" name="email" class="form-control">
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
</div>
@include('footer')