$('#myCarousel').carousel({
	  interval: 3000
	});

	// handles the carousel thumbnails
	$('[id^=carousel-selector-]').hover(function() {
	  var id_selector = $(this).attr("id");
	  //console.log(id_selector);
	  var id = id_selector.substr(id_selector.length - 1);
	  //console.log(id);
	  id = parseInt(id);
	  $('#myCarousel').carousel(id - 1);
	  $('[id^=carousel-selector-]').removeClass('selected');
	  $(this).addClass('selected');
	  //console.log(this);
	});

	// when the carousel slides, auto update
	$('#myCarousel').on('slid.bs.carousel', function(e) {
	  var id = $('.item.active').data('slide-number');
	  id = parseInt(id);
	  $('[id^=carousel-selector-]').removeClass('selected');
	  $('[id=carousel-selector-' + id + ']').addClass('selected');
	});