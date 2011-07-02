jQuery(document).ready(function($) {
	$('#searchForm').submit(function() {
		var url = $(this).attr('action') + $('#searchTerm').val();
		window.location.href = url;
		return false;
	});
});