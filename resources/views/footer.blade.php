	<footer id="gtco-footer" role="contentinfo">
		<div class="gtco-container">
			<div class="row row-pb-md">

				<div class="col-md-4">
					<div class="gtco-widget">
						<h3>About Us</h3>
						<p align="justify">PT.Astrindo Strya Kharisma or widely known as "ASTRINDO Travel Services" has been serving clients clients since 1987. With office in Jakarta and Bali, ASTRINDO Travel Services is recognized as one of the leading of the leading travel agencies and tour operators in Indonesia.</p>
					</div>
				</div>

				<div class="col-md-2 col-md-push-1">
					<div class="gtco-widget">
						<h3>Destination</h3>
						<ul class="gtco-footer-links">
							<li><a href="#">Bali</a></li>
							<li><a href="#">Lombok</a></li>
							<li><a href="#">Belitung</a></li>
							<li><a href="#">Medan</a></li>
							<li><a href="#">Yogyakarta</a></li>
						</ul>
					</div>
				</div>

				<div class="col-md-2 col-md-push-1">
					<div class="gtco-widget">
						<h3>Hotels</h3>
						<ul class="gtco-footer-links">
							<li><a href="#">Grand Melia Hotel</a></li>
							<li><a href="#">Melia Purosani Hotel</a></li>
							<li><a href="#">Grand Indonesia Hotel</a></li>
							<li><a href="#">Grand Sahid Hotel</a></li>
							<li><a href="#">Sangrila Hotel</a></li>
						</ul>
					</div>
				</div>

				<div class="col-md-3 col-md-push-1">
					<div class="gtco-widget">
						<h3>Contact Us</h3>
						<ul class="gtco-quick-contact">
							<li><a href="#"><i class="icon-phone"></i> +62 21 390 7576</a></li>
							<li><a href="#"><i class="icon-mail2"></i> info@astrindotour.co.id</a></li>
							<li><a href="#"><i class="icon-chat"></i> Live Chat</a></li>
						</ul>
					</div>
				</div>

			</div>

			<div class="row copyright">
				<div class="col-md-12">
					<p class="pull-left">
						<small class="block">&copy; <a href="http://GetTemplates.co/" target="_blank">2018</a> . <a href="http://astrindotour.co.id/" target="_blank">Astrindo Travel Services.</a></small>
					</p>
					<p class="pull-right">
						<ul class="gtco-social-icons pull-right">
							<li><a href="https://twitter.com/astrindotravel" target="blank"><i class="icon-twitter"></i></a></li>
							<li><a href="https://www.facebook.com/AstrindoTravelServicesIndonesia/?fref=ts" target="blank"><i class="icon-facebook"></i></a></li>
							<li><a href="https://www.instagram.com/astrindotravelservices/" target="blank"><i class="icon-instagram"></i></a></li>
							<li><a href="https://plus.google.com/+Astrindotravelservices" target="blank"><i class="icon-google"></i></a></li>
						</ul>
					</p>
				</div>
			</div>

		</div>
	</footer>
	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
	</div>

	<!-- jQuery -->
	<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
	<!-- jQuery Easing -->
	<script src="{{ URL::asset('js/jquery.easing.1.3.js') }}"></script>
	<!-- Bootstrap -->
	<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
	<!-- Waypoints -->
	<script src="{{ URL::asset('js/jquery.waypoints.min.js') }}"></script>
	<!-- Carousel -->
	<script src="{{ URL::asset('js/owl.carousel.min.js') }}"></script>
	<!-- countTo -->
	<script src="{{ URL::asset('js/jquery.countTo.js') }}"></script>

	<!-- Stellar Parallax -->
	<script src="{{ URL::asset('js/jquery.stellar.min.js') }}"></script>

	<!-- Magnific Popup -->
	<script src="{{ URL::asset('js/jquery.magnific-popup.min.js') }}"></script>
	<script src="{{ URL::asset('js/magnific-popup-options.js') }}"></script>

	<!-- Datepicker -->
	<script src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>


	<!-- Main -->
	<script src="{{ URL::asset('js/main.js') }}"></script>
	<script type="text/javascript">
		// date picker
		$('#date').datepicker({
		    startDate: '-0d',
		});
		$('#start').datepicker({
		    startDate: '-0d',
		});
		$('#start').change(function(){
			$('#end').datepicker({
			    startDate: '-0d',
			    datesDisabled : $(this).val()
			});
		});
		// type event
		$('#tipe').change(function(){
			if($(this).val() == 'Accommodation')
			{	
				$('#other').hide(450);
				$('#akomodasi').show(450);
				$('#date').val() == '';
				$('#date').val() == '';
			}else if($(this).val() == '')
			{
				$('#other').hide(450);
				$('#akomodasi').hide(450);
				$('#date').val() == '';
				$('#start').val() == '';
				$('#end').val() == '';
			}else{
				$('#other').show(450);
				$('#akomodasi').hide(450);
				$('#start').val() == '';
				$('#end').val() == '';
			}
		});
	</script>
</body>
</html>
