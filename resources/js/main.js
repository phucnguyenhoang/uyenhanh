$(function () {
	App.run();
});


var App = {
	message: {
		'rule': {
			message: {
	            required: 'Thông tin bắt buộc.',
	            max_length: 'Cho phép tối đa %length% ký tự.'
          	}
		}
	},
	init: function () {
		var self = this;

		if ($('#frmProductCreate').length) {
			$('#frmProductCreate').gValidator(self.message.rule);
		}

		if ($('#frmProductEdit').length) {
			$('#frmProductEdit').gValidator(self.message.rule);
		}

		$('#confirmDelete').on('show.bs.modal', function(e) {
			$(this).find('.cf-name').text($(e.relatedTarget).data('name'));
		    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
		});
	},

	run: function() {
		this.init();
	}
};