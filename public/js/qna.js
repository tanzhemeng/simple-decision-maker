var qna = (function($) {
	'use strict';

	var getFormGroupTemplate = function (number) {
		return '<div class="form-group">' +
			'<div class="input-group">' +
				'<input type="text" name="choice['+number+']" class="form-control" placeholder="Choice '+number+'" id="choice'+number+'">'+
				'<span class="input-group-btn">' +
					'<button class="btn btn-danger removeButton" type="button"><i class="fa fa-trash"></i></button>' +
				'</span>' +
			'</div>' +
		'</div>';
	};

	var resetErrors = function (obj) {
		obj.find('.form-group').removeClass('has-error');
		obj.find('.help-block').remove();
		obj.find('.alert').remove();
	};

	var addChoice = function (e) {
		e.preventDefault();

		var choices = $('#choices');
		var formGroups = choices.find('.form-group');
		var number = formGroups.length + 1;
		var template = getFormGroupTemplate(number);

		choices.append(template);
	};

	var removeChoice = function (e) {
		e.preventDefault();

		$(this).closest('.form-group').remove();
	};

	var submitForm = function (e) {
		e.preventDefault();

		var form = $(this);
		var data = form.serialize();
		var url = form.attr('action');
		var submit = form.find('[type=submit]');

		submit.button('loading');

		var request = $.ajax({
			data: data,
			dataType: 'json',
			type: 'post',
			url: url
		});

		request.done(function (data, textStatus, jqXHR) {
			if (jqXHR.status === 200) {
				var data = $.parseJSON(jqXHR.responseText);

				window.location.href = data.url;
			}
		});

		request.fail(function (jqXHR, textStatus, errorThrown) {
			resetErrors(form);

			if (jqXHR.status === 422) {
				var errors = $.parseJSON(jqXHR.responseText);

				$.each(errors, function(fieldName, errorMessage) {
					fieldName = fieldName.replace(/\./g, '');
					var field = $('#'+fieldName, form);
					var formGroup = field.closest('.form-group');
					formGroup.append('<p class="help-block">'+errorMessage+'</p>');
					formGroup.addClass('has-error');
				});
			}

			submit.button('reset');
		});
	};

	return {
		addChoice: addChoice,
		removeChoice: removeChoice,
		submitForm: submitForm
	};

})(jQuery);

$(function() {
	'use strict';

	$(document).on('click', '#addButton', qna.addChoice);
	$(document).on('click', '.removeButton', qna.removeChoice);
	$(document).on('submit', '#questionForm', qna.submitForm);
});