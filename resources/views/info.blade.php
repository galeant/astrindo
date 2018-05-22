@include('header')
<div id="gtco-header" class="gtco-cover gtco-cover-md" role="banner" style="background-image: url(assets/images/tanahlot.jpg)" style="height: auto">
	<div class="overlay"></div>
	<div class="gtco-container">
		<div class="row">
			<div class="col-md-12 col-md-offset-0 text-left">
				<div class="row row-mt-5em">
					<div class="col-md-6 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
						<div class="form-wrap">
							<div class="tab-content">
								<form action="decline" method="POST">
									{{ csrf_field() }}
									<div class="row form-group">
										<div class="col-md-12">
											<label for="title">Untuk Pengecekan</label>
											<label for="title">ID Reservasi = {{$IdReservasi}}</label>
											<label for="title">Decline Book</label>
											<label for="title">ID Reservation</label>
											<input type="text" name="idReservation" class="form-control">
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12">
											<input type="submit" class="btn btn-primary btn-block" value="Submit">
										</div>
									</div>	
								</form>
								<h2>Confirm Reservation</h2>
								<form action="confirm" method="POST">
									{{ csrf_field() }}
									<div class="row form-group">
										<div class="col-md-12">
											<label for="title">Confirm Book</label>
											<label for="title">ID Reservation</label>
											<input type="text" name="idReservation" class="form-control">
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12">
											<input type="submit" class="btn btn-primary btn-block" value="Submit">
										</div>
									</div>	
								</form>
								<form action="cancel" method="POST">
									{{ csrf_field() }}
									<div class="row form-group">
										<div class="col-md-12">
											<label for="title">Cancel Book</label>
											<label for="title">ID Reservation</label>
											<input type="text" name="idReservation" class="form-control">
										</div>
									</div>
									<div class="row form-group">
										<div class="col-md-12">
											<input type="submit" class="btn btn-primary btn-block" value="Submit">
										</div>
									</div>	
								</form>
								<form action="status" method="POST">
									{{ csrf_field() }}
									<div class="row form-group">
										<div class="col-md-12">
											<label for="title">Cek Status</label>
											<label for="title">ID Reservation</label>
											<input type="text" name="idReservation" class="form-control">
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
@include('footer')