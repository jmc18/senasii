$(function(){
	$('.update-modal-click').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
	});
});