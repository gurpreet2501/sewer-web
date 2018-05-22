Vue.directive('tooltip', {
  // When the bound element is inserted into the DOM...
  inserted: function (el) {
  	 tippy(el, {
	    position: 'top',
	    // animation: 'scale',
	    duration: 10,
	    size:'big',
	    arrow: true
	  });
    // Focus the element
    // data-toggle="tooltip" data-placement="top"
    // $(el).data('data-toggle', 'tooltip');
	}
})
