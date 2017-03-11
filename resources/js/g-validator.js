/**
 * Created by PHUCNGUYEN on 04/08/2015.
 */
/*
 $(<selector>).gValidator({
    position: 'left | right | top | bottom',
    success: function(data) {
        // your code here
    },
    error: function() {
        // your code here
    }
 });
*/

(function ( $ ) {

    var GValidator = {
        selector: null,
        elements: null,
        data: {},
        position: 'left',
        message: {
            required: 'Please input for required field.',
            email_incorrect: 'Please input the correct email.',
            max_length: 'Max length allowed is %length% characters.',
            min_length: 'Min length allowed is %length% characters.',
            equal: 'The value must be equal %equal% value.'
        },
        settings: null,
        init: function(option, selector) {
            var self = this;
            self.selector = selector;
            self.settings = option;
            if (option.position !== undefined) this.position = option.position;
            if (option.message !== undefined) {
                $.each(option.message, function(key, value) {
                    self.message[key] = value;
                });
            }
            // get all form element
            self.elements = this.selector.find('input, select, textarea');

            // init help text
            self._initHelpText();
            // set hover effect
            self._setHoverEffect();
            // set focus effect
            self._setFocusEffect();
            // set blur effect
            self._setBlurEffect();
            // check element has submit method
            if (self.selector.prop('tagName').toLowerCase() == 'form') {
                self._handleSubmit(self.selector);
            }
        },
        eventHandle: function() {
            // handle for password filed
            this._onEnterPassword();
            this._onPastePassword();
        },
        success: function() {
            var self = this;
            if (typeof self.settings.success != 'function') return false;

            self.settings.success(self.data);
        },
        error: function() {
            var self = this;
            if (typeof self.settings.error != 'function') return false;

            self.settings.error(self.data);
        },
        _initHelpText: function() {
            var  self = this;
            self.elements.each(function() {
                var element = $(this),
                    hasHelpText = element.data('help');

                if (element.attr('type') == 'password' && element.attr('role') == 'password') {
                    var progressBar = '<div class="progress" style="height: 5px;">',
                        helpText = '<p>Use at least 8 characters. Don’t use a password from another site, or something too obvious like your pet’s name.</p>';

                    progressBar += '<div id="password_strength" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">';
                    progressBar += '</div>';
                    progressBar += '</div>';
                    element.popover({
                        html: true,
                        title: '<strong>Password strength:</strong> <span id="lbl_password_strength">Empty</span>',
                        content: progressBar + helpText,
                        container: 'body',
                        trigger: 'manual',
                        placement: self.position
                    });
                } else if (hasHelpText !== undefined) {
                    element.popover({
                        content: hasHelpText,
                        container: 'body',
                        trigger: 'manual',
                        placement: self.position
                    });
                }
            });
        },
        _setHoverEffect: function() {
            var self = this;
            self.elements.hover(function() {
                $(this).css('boxShadow', 'inset 0 1px 3px rgba(0,0,0,.2)');
            }, function() {
                $(this).css('boxShadow', 'inset 0 1px 1px rgba(0,0,0,.075)');
            });
        },
        _setFocusEffect: function() {
            var self = this;
            self.selector.on('focus', 'input, select, textarea', function() {
                var element = $(this),
                    hasHelpText = element.data('help');

                // remove error
                self._removeError(element);
                // show help text
                if (hasHelpText !== undefined || (element.attr('type') == 'password' && element.attr('role') == 'password')) {
                    element.popover('show');
                }
                if (element.attr('type') == 'password' && element.attr('role') == 'password') {
                    self._checkPasswordStrong(element);
                }
            });
        },
        _setBlurEffect: function() {
            var self = this;
            self.selector.on('blur', 'input, select, textarea', function() {
                self._validate($(this));
            });
        },
        _handleSubmit: function(form) {
            var self = this;
            form.submit(function(e) {
                form.find('input, select, textarea').each(function() {
                    self._validate($(this));
                });
                if (self.selector.find('.err-message').length > 0) {
                    e.preventDefault();
                    return false;
                }
            });
        },
        _onEnterPassword: function() {
            var self = this;
            self.selector.on('keyup', 'input[type="password"]', function() {
                var element = $(this);
                if (element.attr('role') == 'password') {
                    self._checkPasswordStrong($(this));
                }
            });
        },
        _onPastePassword: function() {
            var self = this;
            self.selector.on('paste', 'input[type="password"]', function() {
                var element = $(this);
                if (element.attr('role') == 'password') {
                    setTimeout(function() {
                        self._checkPasswordStrong(element);
                    }, 300);
                }
            });
        },
        _checkPasswordStrong: function(txtPassword) {
            var self = this;
            var password = txtPassword.val(),
                body = $('body'),
                passwordStrength = body.find('#password_strength'),
                lblPasswordStrength = body.find('#lbl_password_strength');

            if (password.length <= 0) {
                lblPasswordStrength.text('Empty');
                passwordStrength.css('width', '0%').removeClass('progress-bar-success').removeClass('progress-bar-warning').addClass('progress-bar-danger');
                return false;
            }

            if (password.length <= 6) {
                lblPasswordStrength.text('Too short');
                passwordStrength.css('width', '20%').removeClass('progress-bar-warning').removeClass('progress-bar-success').addClass('progress-bar-danger');
            } else if (password.length <= 12) {
                if (password.search(/[a-zA-z]/g) !== -1 && password.search( /[^a-zA-Z]/g) !== -1) {
                    lblPasswordStrength.text('Good');
                    passwordStrength.css('width', '75%').removeClass('progress-bar-danger').removeClass('progress-bar-warning').addClass('progress-bar-success');
                } else {
                    lblPasswordStrength.text('Normal');
                    passwordStrength.css('width', '45%').removeClass('progress-bar-danger').removeClass('progress-bar-success').addClass('progress-bar-warning');
                }
            } else {
                if (password.search(/[a-zA-z]/g) !== -1 && password.search( /[^a-zA-Z]/g) !== -1) {
                    lblPasswordStrength.text('Strong');
                    passwordStrength.css('width', '100%').removeClass('progress-bar-danger').removeClass('progress-bar-warning').addClass('progress-bar-success');
                } else {
                    lblPasswordStrength.text('Long');
                    passwordStrength.css('width', '80%').removeClass('progress-bar-danger').removeClass('progress-bar-warning').addClass('progress-bar-success');
                }
            }
        },
        _checkEmail: function(email) {
            var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            return re.test(email);
        },
        _setError: function(element, msg) {
            var box = element.closest('.form-group');
            if (box.find('.err-message').length > 0) return false;
            box.addClass('has-error');
            element.after('<p class="help-block err-message">' + msg + '</p>');
        },
        _removeError: function(element) {
            var box = element.closest('.form-group');
            box.find('.err-message').remove();
            box.removeClass('has-error');
        },
        _validate: function(element) {
            var self = this,
                value = element.val(),
                rule = element.data('rule'),
                hasHelpText = element.data('help');

            if (rule !== undefined) {
                rule = rule.split('|');
                var tmp = [],
                    currRule;

                for (var i = 0; i < rule.length; i++) {
                    currRule = rule[i].split(':');
                    if (currRule.length > 1) {
                        tmp[currRule[0]] = currRule[1];
                    } else {
                        tmp[rule[i]] = rule[i];
                    }

                }
                rule = tmp;
            } else {
                rule = [];
            }

            // remove help text
            if (hasHelpText !== undefined || (element.attr('type') == 'password' && element.attr('role') == 'password')) {
                element.popover('hide');
            }

            // check email
            if (element.attr('type') == 'email') {
                if (rule['required'] !== undefined && value.length <= 0) {
                    self._setError(element, self.message.required);
                } else if (value.length > 0 && !self._checkEmail(value)) {
                    self._setError(element, self.message.email_incorrect);
                }
            }

            // check type different email
            if (element.attr('type') != 'email'){
                // check required
                if (rule['required'] !== undefined && value.length <= 0) {
                    self._setError(element, self.message.required);
                }
                // check min length
                if (rule['minLength'] != undefined && value.length < parseInt(rule['minLength'])) {
                    self._setError(element, self.message.min_length.replace('%length%', rule['minLength']));
                }
                // check max length
                if (rule['maxLength'] != undefined && value.length > parseInt(rule['maxLength'])) {
                    self._setError(element, self.message.max_length.replace('%length%', rule['maxLength']));
                }
                // check equal
                if (rule['equal'] != undefined && value != $(rule['equal']).val()) {
                    self._setError(element, self.message.equal.replace('%equal%', $(rule['equal']).attr('placeholder')));
                }
            }


            // call back function
            if (self.selector.find('.err-message').length > 0) {
                self.error();
            } else {
                self.success();
            }
        },
        run: function(option, selector) {
            this.init(option, selector);
            this.eventHandle();
        }
    };

    $.fn.gValidator = function( options ) {

        // This is the easiest way to have default options.
        var settings = $.extend({
            // These are the defaults.

        }, options );

        GValidator.run(settings, this);

        return this;
    };

}( jQuery ));