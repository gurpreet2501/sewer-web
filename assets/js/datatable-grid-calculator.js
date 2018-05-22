jQuery(function( $ ){

var Grid = function() {
	this.dataTable = $(".groceryCrudTable").dataTable();
};

Grid.prototype.total = function(index){
	console.log(index);
	var total = 0.00;
	$.each(this.dataTable._('tr', {"filter": "applied"}), function(key, item,theArray){
		total += parseFloat(item[index - 1]);
	});

	return total;
}

Grid.prototype.displayTotal = function(text, index){
	console.log(text+' '+index);
	var total = this.total(index);
	var span = '<span class="DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s"></span>';

	$('.groceryCrudTable thead th:nth-child(' + index + ') .DataTables_sort_wrapper')
	.html(text + ' ' + total.toFixed(2) + span);
}

var grid = new Grid();

var main = function(){

	if (location.href.endsWith('entry_type=IN')){
		grid.displayTotal('Net Wt In Q', 7);
	}else if (location.href.endsWith('entry_type=OUT')){
		grid.displayTotal('Net Wt In Q', 7);
	}else if (location.href.endsWith('data/cmrDetails')){
		grid.displayTotal('Quintals', 8);
		grid.displayTotal('No of bags', 9);
	}
}

main()
$(document).bind('click keyup', function() {
	main();
});



// var updateData = function(){
// 	var items = $(".groceryCrudTable").dataTable()._('tr', {"filter": "applied"});
// 	var quintalsIndex = 7;
// 	var bagsIndex = 8;
// 	var quintals = 0.00;
// 	var bags = 0.00;

// 	$.each(items, function(index, item){
// 		quintals += parseFloat(item[quintalsIndex - 1]);
// 		bags += parseFloat(item[bagsIndex - 1]);
// 	});


// 	var quintals = " " + quintals.toFixed(2) + "<span class=\"DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s\"></span>";

// 	var bags = " " + bags.toFixed(2) + "<span class=\"DataTables_sort_icon css_right ui-icon ui-icon-carat-2-n-s\"></span>";

// 	$('.groceryCrudTable thead th:nth-child(' + quintalsIndex + ') .DataTables_sort_wrapper').html(quintals);
// 	$('.groceryCrudTable thead th:nth-child(' + bagsIndex + ') .DataTables_sort_wrapper').html(bags);
// };

// updateData();

// $(document).bind('click keyup', function(event) {
// 	updateData();
// 	console.log('triggered');
// });

});
