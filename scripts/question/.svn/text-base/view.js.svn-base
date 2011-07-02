jQuery(document).ready(function($) {
	
	$('.vote-up').click(function(e) {
		
		e.preventDefault();
		var question = $(this);
		$.post(baseUrl + 'question/ajax_vote_up', {
			question_id: question.attr('id').replace('question_id_', '')
		}, function(data) {
			if(data == 'E_OK') {
				question.next().html(parseInt(question.next().html(), 10) + 1);
			}
		});
		
	});
});