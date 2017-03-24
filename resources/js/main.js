$(function () {
	App.run();
});


var App = {
	data: null,
	message: {
		editSuccess: 'Sửa thông tin thành công.',
		required: 'Thông tin bắt buộc.',
		emailInvalid: 'Email không hợp lệ.',
		sendEmailSuccess: 'Gửi email thành công.',
		hasError: 'Có lỗi xảy ra.',
		orderExist: 'Đơn hàng đã tồn tại <a href="/orders/view/%id" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span> Xem</a>',
		saveOrderSuccess: 'Sửa đơn hàng thành công.',
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

		if ($('#frmCustomerCreate').length) {
			$('#frmCustomerCreate').gValidator(self.message.rule);
		}

		if ($('#frmCustomerEdit').length) {
			$('#frmCustomerEdit').gValidator(self.message.rule);
		}

		$('#confirmDelete').on('show.bs.modal', function(e) {
			$(this).find('.cf-name').text($(e.relatedTarget).data('name'));
		    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
		});

		if ($('.datepicker').length) {
			$('.datepicker').datepicker({
				format: 'dd-mm-yyyy',
				autoclose: true,
				todayHighlight: true,
				language: 'vi'
			});
		}
	},
	eventHandler: function() {
		this._dateButtonClick();
		this._changeOrderDate();
		this._addOrder();
		this._editOrder();
		this._autoComplateProduct();
		this._autoNumber();
		this._collapsePanel();
		this._handleAddProduct();
		this._handleEditProduct();
		this._sendEmail();
	},
	_dateButtonClick: function() {
		$('.btn-date').click(function() {
			$(this).closest('.input-group').find('input.datepicker').focus();
		});
	},
	_changeOrderDate: function() {
		$('#txtOrderDate').change(function() {
			$(this).closest('form').submit();
		});
	},
	_addOrder: function() {
		var self = this,
			modalAddOrder = $('#modalAddOrder');

		modalAddOrder.on('shown.bs.modal', function (e) {
			modalAddOrder.find('#txtDate').val($('#txtOrderDate').val());
			modalAddOrder.find('#cboCustomer').val(modalAddOrder.find("#cboCustomer option:first").val());
			modalAddOrder.find('#txtNote').val('');
			modalAddOrder.find('input[type="radio"]').prop('checked', false);
			modalAddOrder.find('input[type="radio"]').first().prop('checked', true);
		});

		modalAddOrder.on('click', '.btn-ok', function() {
			var orderDate = modalAddOrder.find('#txtDate').val(),
				customer = modalAddOrder.find('#cboCustomer').val(),
				note = modalAddOrder.find('#txtNote').val(),
				type = modalAddOrder.find('input[type="radio"]:checked').val();

			$.ajax({
				url: '/orders/is-exist',
				method: 'post',
				data: {
					'date': orderDate,
					'customer': customer,
					'type': type
				},
				dataType: 'json',
				error: function(err) {
					modalAddOrder.find('.modal-body').prepend(self._showError('danger', self.message.hasError));
				},
				success: function(data) {
					if (data.existed) {
						msg = self.message.orderExist;
						msg = msg.replace('%id', data.id);
						modalAddOrder.find('.modal-body').prepend(self._showError('danger', msg));
						return false;
					}

					modalAddOrder.closest('form').submit();
				}
			});
		});
	},
	_editOrder: function() {
		var self = this;

		$('#btnSaveOrder').click(function() {
			var btn = $(this),
				panOrderInfo = $('#panOrderInfo');

			btn.prop('disabled', true);
			$.ajax({
				url: '/orders/edit',
				method: 'post',
				data: {
					id: btn.data('id'),
					note: $('#txtNote').val(),
					type: panOrderInfo.find('input[type="radio"]:checked').val()
				},
				dataType: 'json',
				error: function(err) {
					panOrderInfo.prepend(self._showError('danger', self.message.hasError));
					btn.prop('disabled', false);
				},
				success: function(data) {
					if (data.status) {
						panOrderInfo.prepend(self._showError('success', self.message.saveOrderSuccess));
					} else {
						panOrderInfo.prepend(self._showError('danger', self.message.hasError));
					}
					btn.prop('disabled', false);
				}
			});
		});
	},
	_autoComplateProduct: function() {
		var self = this,
			txtProduct = $('#txtProduct');

		if (txtProduct.length <= 0) return false;

		$.ajax({
			url: '/products/autocomplate',
			method: 'get',
			dataType: 'json',
			success: function(data) {
				self.data = data;
				txtProduct.typeahead({
				 	source: data,
				    autoSelect: true,
				    showHintOnFocus: 'all',
				    fitToElement: true
				});
			}
		});
	},
	_autoNumber: function() {
		if ($('.auto-number').length <= 0) return false;

		$('.auto-number').autoNumeric('init', {
			digitGroupSeparator: ',',
			decimalCharacterf: '.',
			minimumValue: '0.00',
			allowDecimalPadding: false
		});
	},
	_collapsePanel: function() {
		$('.collapse').on('shown.bs.collapse', function () {
			var ico = $(this).closest('.panel').find('.btn-collapse').find('.glyphicon');
			ico.removeClass('glyphicon-triangle-bottom');
			ico.addClass('glyphicon-triangle-top');
		});

		$('.collapse').on('hidden.bs.collapse', function () {
			var ico = $(this).closest('.panel').find('.btn-collapse').find('.glyphicon');
			ico.removeClass('glyphicon-triangle-top');
			ico.addClass('glyphicon-triangle-bottom');
		})
	},
	_handleAddProduct: function() {
		var self = this,
			panAddProductToOrders = $('#panAddProductToOrders');

		panAddProductToOrders.on('click', '#btnAddProduct', function() {
			var btn = $(this),
				orderId = btn.data('id'),
				txtProduct = panAddProductToOrders.find('#txtProduct'),
				txtPrice = panAddProductToOrders.find('#txtPrice'),
				txtQuantity = panAddProductToOrders.find('#txtQuantity'),
				txtShip = panAddProductToOrders.find('#txtShip'),
				txtNote = panAddProductToOrders.find('#txtProductNote'),
				productId = txtProduct.typeahead('getActive'),
				price = txtPrice.autoNumeric('getNumber'),
				quantity = txtQuantity.autoNumeric('getNumber'),
				ship = txtShip.autoNumeric('getNumber'),
				note = txtNote.val();

			self._clearError(panAddProductToOrders);
			if (productId === undefined || txtProduct.val() == '') {
				self._showFieldError(txtProduct, self.message.required);
			}
			if (price == 0) {
				self._showFieldError(txtPrice, self.message.required);	
			}
			if (quantity == 0) {
				self._showFieldError(txtQuantity, self.message.required);	
			}
			if (productId === undefined || price == 0 || quantity == 0) {
				return false;
			}
			
			panAddProductToOrders.append('<div class="loading"></div>');

			$.ajax({
				url: '/orders/add-product',
				type: 'post',
				dataType: 'json',
				data: {
					'orders_id': orderId,
					'products_id': productId.id,
					'quantity': quantity,
					'price': price,
					'ship': ship,
					'note': note
				},
				error: function(err) {
					panAddProductToOrders.prepend(self._showError('danger', self.message.hasError));
					panAddProductToOrders.find('.loading').remove();
				},
				success: function(data) {
					panAddProductToOrders.find('.loading').remove();
					if (!data.error) {
						$('#panOrderHasProduct').html(data.body);
						$('.pan-share-order-control').removeClass('hidden');
						txtProduct.val('');
						txtProduct.typeahead('destroy');
						txtProduct.typeahead({
						 	source: self.data,
						    autoSelect: true,
						    showHintOnFocus: 'all',
						    fitToElement: true
						});
						txtPrice.val('');
						txtQuantity.val('');
						txtShip.val('');
						txtNote.val('');
					}
				}
			});
		});
	},
	_handleEditProduct: function() {
		var self = this,
			modalEditProduct = $('#modalEditProduct'),
			txtProduct = modalEditProduct.find('#txtAddProduct'),
			txtPrice = modalEditProduct.find('#txtAddPrice'),
			txtQuantity = modalEditProduct.find('#txtAddQuantity'),
			txtShip = modalEditProduct.find('#txtAddShip'),
			txtNote = modalEditProduct.find('#txtAddProductNote');

		modalEditProduct.on('show.bs.modal', function(e) {
			var id = $(e.relatedTarget).data('id'),
				name = $(e.relatedTarget).data('name');

			modalEditProduct.find('.modal-content').append('<div class="loading"></div>');
			txtProduct.val(name);
			txtPrice.val('');
			txtQuantity.val('');
			txtShip.val('');
			txtNote.val('');

			modalEditProduct.find('.btn-ok').data('id', id);

			$.ajax({
				url: '/orders/view-product/' + id,
				method: 'get',
				dataType: 'json',
				success: function(data) {
					if (!data.error) {
						txtPrice.autoNumeric('set', data.product.price);
						txtQuantity.autoNumeric('set', data.product.quantity);
						txtShip.autoNumeric('set', data.product.ship);
						txtNote.val(data.product.note);
					}
					modalEditProduct.find('.loading').remove();
				}
			});
		});

		modalEditProduct.on('click', '.btn-ok', function() {
			var id = $(this).data('id'),
				price = txtPrice.autoNumeric('getNumber'),
				quantity = txtQuantity.autoNumeric('getNumber'),
				ship = txtShip.autoNumeric('getNumber'),
				note = txtNote.val();

			self._clearError(modalEditProduct);
			if (price <= 0) {
				self._showFieldError(txtPrice, self.message.required);	
			}
			if (quantity <= 0) {
				self._showFieldError(txtQuantity, self.message.required);	
			}
			if (price <= 0 || quantity <= 0) {
				return false;
			}

			modalEditProduct.find('.modal-content').append('<div class="loading"></div>');
			$.ajax({
				url: '/orders/edit-product/' + id,
				method: 'post',
				dataType: 'json',
				data: {
					orderId: $('#hidOrderId').val(),
					price: price,
					quantity: quantity,
					ship: ship,
					note: note
				},
				error: function(err) {
					modalEditProduct.find('.modal-body').prepend(self._showError('danger', self.message.hasError));
					modalEditProduct.find('.loading').remove();
				},
				success: function(data) {
					if (!data.error) {
						if (data.body != '') {
							$('#panOrderHasProduct').html(data.body);
						}
						modalEditProduct.find('.modal-body').prepend(self._showError('success', self.message.editSuccess));
						setTimeout(function(){
							modalEditProduct.modal('hide');
						}, 800);
					} else {
						modalEditProduct.find('.modal-body').prepend(self._showError('danger', self.message.hasError));
					}
					modalEditProduct.find('.loading').remove();
				}
			});
		});
	},
	_sendEmail: function() {
		var self = this,
			modalSendEmail = $('#modalSendEmail');

		modalSendEmail.on('click', '.btn-ok', function() {
			var btn = $(this),
				txtToEmail = modalSendEmail.find('#txtToEmail'),
				txtReceverName = modalSendEmail.find('#txtReceverName'),
				txtEmailContent = modalSendEmail.find('#txtEmailContent'),
				orderId = btn.data('id'),
				toEmail = txtToEmail.val(),
				receverName = txtReceverName.val(),
				content = txtEmailContent.val();

			self._clearError(modalSendEmail);
			if (toEmail == '') {
				self._showFieldError(txtToEmail, self.message.required);
				return false;
			}
			if (!self._validateEmail(toEmail)) {
				self._showFieldError(txtToEmail, self.message.emailInvalid);
				return false;
			}

			modalSendEmail.find('.modal-content').append('<div class="loading"></div>');
			$.ajax({
				url: '/email',
				method: 'post',
				dataType: 'json',
				data: {
					type: 'dayOrder',
					orderId: orderId,
					toEmail: toEmail,
					receverName: receverName,
					content: content
				},
				error: function(err) {
					console.log(err);
					modalSendEmail.find('.modal-body').prepend(self._showError('danger', self.message.hasError));
					modalSendEmail.find('.loading').remove();
				},
				success: function(data) {
					console.log(data);
					if (data.error) {
						modalSendEmail.find('.modal-body').prepend(self._showError('danger', self.message.hasError));
					} else {
						modalSendEmail.find('.modal-body').prepend(self._showError('success', self.message.sendEmailSuccess));
						setTimeout(function(){
							modalSendEmail.modal('hide');
						}, 800);
					}
					modalSendEmail.find('.loading').remove();
				}
			});
		});
	},
	_showError: function(type, msg) {
		var html = '<div class="alert alert-' + type + ' alert-dismissible fade in" role="alert">';
		html += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
		html += msg;
		html += '</div>';

		return $(html);
	},
	_showFieldError: function(field, msg) {
		field.closest('.form-group').addClass('has-error');
		var msg = '<p class="help-block">' + msg + '</p>';
		if (field.closest('.input-group').length > 0) {
			field.closest('.input-group').after(msg);
		} else {
			field.after(msg);
		}
	},
	_clearError: function(pan) {
		pan.find('.alert').remove();
		pan.find('.form-group').removeClass('has-error');
		pan.find('.help-block').remove();
	},
	_validateEmail: function(email) {
	    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	    return re.test(email);
	},
	run: function() {
		this.init();
		this.eventHandler();
	}
};

Number.prototype.formatMoney = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};