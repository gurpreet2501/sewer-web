
Mousetrap.bind('ctrl+y', function(e) {
	$('.ctrl_y_click').each(function(){
		var $ele = $(this);
		var $area = $($ele.attr('data-ctr_y_area_selector'));
		if(!$area.length)
			return;
		if($area.find(':focus').length)
			$ele.trigger('click');
	});
});


