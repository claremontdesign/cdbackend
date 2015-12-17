/**
 * CD Backend
 * @returns void
 */
function cd_backend()
{
	console.log('Hi!');
}

(function($) {
	$.fn.cd_datatableSort = function(options) {

		var that = this;

		// This is the easiest way to have default options.
		var settings = $.extend({
			url: '#'
		}, options);

		that.find('tbody').sortable({
			placeholder: "ui-state-highlight",
			helper: cdbackend_sortable_fixsorting,
			stop: function(event, ui) {
				cdbackend_sortable_renumber_table();
			}
		}).disableSelection();

		/**
		 * Fix Sorting
		 * @param {type} e
		 * @param {type} tr
		 * @returns {unresolved}
		 */
		function cdbackend_sortable_fixsorting(e, tr) {
			var $originals = tr;
			var $helper = tr.clone();
			$helper.width($originals.width());
			return $helper;
		}
		;

		/**
		 *
		 * @returns {undefined}
		 */
		function cdbackend_sortable_renumber_table() {
			that.each(function() {
				count = $(this).parent().children().index($(this)) + 1;
				$(this).find('.sortable-order-num').html(count);
			});
			var sortingId = that.attr('id') + 'saveSorting';
			if (that.find('#' + sortingId).length < 1)
			{
				var tdCount = that.find('tr td').length;
				var newTr = '<tr id="' + sortingId + '" class="highlight"><td colspan="' + tdCount + '" style="text-align:center;">';
				newTr += '<button type="submit" name="' + settings.prefix + '_submitSort" value="1" class="btn btn-success">Save Sorting</button>';
				newTr += '&nbsp; <button type="submit" name="' + settings.prefix + '_submitSortReset" value="1" class="btn btn-danger">Reset</button>';
				newTr += '</td></tr>';
				that.find('thead tr:last').after(newTr);
			}
		}
	};
}(jQuery));

/**
 * Sorting Table Rows
 */

/**
 * Form
 */
(function($) {
	$.fn.cd_form = function(options) {

		var that = this;

		// This is the easiest way to have default options.
		var settings = $.extend({
		}, options);
		that.validate();
		that.find('.form-group.has-error').each(function() {
			var tab = $(this).find('input,select,textarea').attr('data-tab');
			if (tab !== undefined)
			{
				$('#form-nav-tab-' + tab).addClass('nav-tab-has-error');
				$('#formtab_' + tab).addClass('tab-content-has-error');
			}
		});
		if (that.find('.form-nav-tab.has-error').length > 0)
		{
			that.find('.form-nav-tab').removeClass('active');
			that.find('.form-tab-content').removeClass('active');
			that.find('.form-nav-tab.nav-tab-has-error').eq(0).addClass('active');
			that.find('.form-tab-content.tab-content-has-error').eq(0).addClass('active');
		}

	};
}(jQuery));
/**
 * Form
 */

/**
 * jQuery Validation
 */
jQuery.validator.setDefaults({
	errorElement: 'span', //default input error message container
	errorClass: 'help-block help-block-error', // default input error message class
	focusInvalid: false,
	ignore: "",
	meta: "validate",
	invalidHandler: function(event, validator) {},
	highlight: function(element) {
		$(element).closest('.form-group').addClass('has-error');
		var tab = $(element).attr('data-tab');
		if (tab)
		{
			$('#form-nav-tab-' + tab).addClass('nav-tab-has-error');
			$('#formtab_' + tab).addClass('tab-content-has-error');
		}
	},
	unhighlight: function(element) {
		$(element).closest('.form-group').removeClass('has-error');
	},
	success: function(label, element) {
		$(element).closest('.form-group').removeClass('has-error');
	},
	errorPlacement: function(error, element) {
		var type = element.attr('type');
		if (type === 'checkbox') {
			var name = element.attr('name');
			if ($('#' + name + '_checkbox_error').length > 0)
			{
				error.insertAfter($('#' + name + '_checkbox_error'));
				return;
			}
		}
		if (element.closest('.input-icon').size() === 1) {
			error.insertAfter(element.closest('.input-icon'));
		} else {
			error.insertAfter(element);
		}
	}
});
/**
 * jQuery Validation
 */