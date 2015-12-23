/**
 * Utilities
 */
function dd(v)
{
	console.log(v);
}
function cd_backend()
{
	console.log('Hi!');
}
function cd_prefix()
{
	return 'cdbase';
}
/**
 * Send a toasted message
 * @param obj object
 * @returns void
 */
function _toast(obj)
{
	toastr.options = {
		"closeButton": true,
		"debug": false,
		"positionClass": "toast-top-right",
		"onclick": null,
		"showDuration": "1000",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	};
	toastr[obj.type](obj.msg, obj.title);
}
/**
 * show loader on the target block
 * @param target string  target selector
 * @returns void
 */
function _loader(target)
{
	// App.startPageLoading('Please wait...');
	App.blockUI({
		target: target,
		overlayColor: 'none',
		boxed: false,
		message: 'Processing...'
	});
}
/**
 * Toggle loader
 * @param target string The target selector
 * @returns void
 */
function _unloader(target)
{
	// App.stopPageLoading();
	App.unblockUI(target);
}
/**
 * Manipulate DOM
 * @param {type} obj
 * @returns {undefined}
 */
function _dom(obj)
{
	var selector = obj.selector !== undefined ? obj.selector : false;
	var method = obj.method !== undefined ? obj.method : false;
	var html = obj.html !== undefined ? obj.html : false;
	if (selector !== false && method !== false && html !== false)
	{
		if (method === 'replace')
		{
			$(selector).replaceWith(html);
		}
	}
}
function _script(obj)
{
	var selector = obj.selector !== undefined ? obj.selector : false;
	var method = obj.method !== undefined ? obj.method : false;
	var html = obj.html !== undefined ? obj.html : false;
	if (selector !== false && method !== false && html !== false)
	{
		if (method === 'replace')
		{
			if ($(selector).length > 0)
			{
				$(selector).replaceWith(html);
			} else {
				$('body').append(html);
			}
		}
	}
}
/**
 * Revert an elements's value/content to original content/value,
 *	selector should have "data-originalvalue" attribute
 * @param selector string The selector
 * @returns void
 */
function cd_revertTextToOriginal(selector)
{
	jQuery(selector).text(jQuery(selector).attr('data-originalvalue'));
}
function cd_revertValueToOriginal(selector)
{
	jQuery(selector).val(jQuery(selector).attr('data-originalvalue'));
}
function in_array(needle, haystack, argStrict) {
	var key = '',
			strict = !!argStrict;
	if (strict) {
		for (key in haystack) {
			if (haystack[key] === needle) {
				return true;
			}
		}
	} else {
		for (key in haystack) {
			if (haystack[key] == needle) {
				return true;
			}
		}
	}

	return false;
}
/**
 * Utilities
 */
(function($) {
	$.fn.cd_datatable = function(options) {

		var that = this;

		// This is the easiest way to have default options.
		var settings = $.extend({
			url: '#',
			sortable: false,
			ajaxSupport: false,
			prefix: null,
			nested: false,
			labelPlural: 'Items',
			labelSingular: 'Item',
			categories: [],
			currentSorting: []
		}, options);
		if (settings.sortable)
		{
			that.find('tbody').sortable({
				placeholder: "ui-state-highlight",
				helper: sortable_fixsorting,
				stop: function(event, ui) {
					sortable_renumber_table();
				}
			}).disableSelection();
		}

		if (settings.ajaxSupport)
		{
			// submit filters
			that.find('.btn-filter').off('click').click(function(e) {
				e.preventDefault();
				filterable(false);
			});
			// Reset Filters
			that.find('.btn-filter-reset').off('click').click(function(e) {
				e.preventDefault();
				that.find('.filter-input').val('');
				filterable(true);
			});
			// Sorting
			that.find('.column-sortable a').off('click').click(function(e) {
				e.preventDefault();
				var sortIndex = $(this).attr('data-sortindex');
				var sort = sortIndex + '-asc';
				if (in_array(sortIndex + '-asc', settings.currentSorting))
				{
					sort = sortIndex + '-desc';
				} else {
					sort = sortIndex + '-asc';
				}
				var formData = getCurrentFilters() + '&sort=' + sort;
				$.ajax({
					type: 'POST',
					url: settings.url,
					dataType: 'json',
					data: formData,
					beforeSend: function() {
						_loader(that.closest('.widget-wrapper'));
					},
					complete: function() {
						_unloader(that.closest('.widget-wrapper'));
					}
				});
			});
			// Pagination
			that.find('ul.pagination').not('.pagination-perpage').find('a').off('click').click(function(e) {
				e.preventDefault();
				var rel = null;
				var currentPage = getCurrentPage();
				var page = parseInt($(this).text());
				if ($(this).attr('rel') !== undefined)
				{
					rel = $(this).attr('rel');
				}
				if (rel === 'next')
				{
					page = currentPage + 1;
				}
				if (rel === 'prev')
				{
					page = currentPage - 1;
				}
				var formData = getCurrentFilters() + '&page=' + page + '&sort=' + getCurrentSorting();
				$.ajax({
					type: 'POST',
					url: settings.url,
					data: formData,
					dataType: 'json',
					beforeSend: function() {
						_loader(that.closest('.widget-wrapper'));
					},
					complete: function() {
						_unloader(that.closest('.widget-wrapper'));
					}
				});
			});
			// Pagination - PerPage
			that.find('ul.pagination-perpage').find('a').off('click').click(function(e) {
				e.preventDefault();
				var formData = getCurrentFilters() + '&pp=' + $(this).attr('data-perpage') + '&sort=' + getCurrentSorting();
				$.ajax({
					type: 'POST',
					url: settings.url,
					data: formData,
					dataType: 'json',
					beforeSend: function() {
						_loader(that.closest('.widget-wrapper'));
					},
					complete: function() {
						_unloader(that.closest('.widget-wrapper'));
					}
				});
			});

			// Position
			that.find('input[data-positioning]').off('change').change(function() {
				if ($(this).val() !== $(this).attr('data-originalvalue'))
				{
					$(this).addClass('valueModified');
				} else {
					$(this).removeClass('valueModified');
				}
				var sortingId = that.attr('id') + 'savePositioning';
				if (that.find('#' + sortingId).length < 1)
				{
					var tdCount = that.find('tr td').length;
					var newTr = '<tr id="' + sortingId + '" class="highlight row-highlight"><td colspan="' + tdCount + '" style="text-align:center;">';
					newTr += '<button id="' + settings.prefix + '_submitNested" type="submit" name="' + settings.prefix + '_submitSort" value="1" class="btn btn-success">Save Positions</button>';
					newTr += '&nbsp; <button id="' + settings.prefix + '_submitNestedReset" type="submit" name="' + settings.prefix + '_submitSortReset" value="1" class="btn btn-danger">Reset</button>';
					newTr += '</td></tr>';
					that.find('thead tr:last').after(newTr);
					$('#' + settings.prefix + '_submitNested').off('click').click(function(e) {
						e.preventDefault();
						var formData = that.find('input[name="' + settings.prefix + '_datatable_rowid[]"], input[name="' + settings.prefix + 'Position[]"], input[name="' + settings.prefix + '_pivotItemId[]"], input[name="' + settings.prefix + '_pivotCategoryId[]"]').serialize();
						$.ajax({
							type: 'POST',
							url: settings.url,
							data: formData + '&' + settings.prefix + '_submitNestedPositions=1',
							dataType: 'json',
							beforeSend: function() {
								_loader(that.closest('.widget-wrapper'));
							},
							complete: function() {
								_unloader(that.closest('.widget-wrapper'));
							},
							success: function() {
								$('#' + sortingId).remove();
							},
							error: function() {
							}
						});
					});
					$('#' + settings.prefix + '_submitNestedReset').off('click').click(function(e) {
						e.preventDefault();
						that.find('input[data-positioning].valueModified').each(function() {
							cd_revertValueToOriginal(this);
						});
						$('#' + sortingId).remove();
					});
				}
			});


			if (settings.nested)
			{
				// Add Items btn
				if ($('#' + settings.prefix + '_add_items').length < 1)
				{
					var addItemBtn = '<button type="button" class="btn btn-cancel btn-default" id="' + settings.prefix + '_add_items" role="button">Add/Remove ' + settings.labelPlural + '</button><hr />';
					that.before(addItemBtn);
					$('#' + settings.prefix + '_add_items').off('click').click(function(e) {
						e.preventDefault();
						nestedAllItems();
					});
				}
				if (isAllItems())
				{
					that.find('.column-data-position').each(function() {
						var itemId = $(this).find('input[name="' + settings.prefix + '_pivotItemId[]"]').val();
						var addbtn = '<button id="' + settings.prefix + '_add_item_' + itemId + '" data-id="' + itemId + '" type="button" class="btn btn-success ' + settings.prefix + '_nestedbtn_item_' + itemId + '" role="button">Add</button>';
						var rembtn = '<button id="' + settings.prefix + '_remove_item_' + itemId + '"data-id="' + itemId + '" type="button" class="btn btn-danger ' + settings.prefix + '_nestedbtn_item_' + itemId + '" role="button">Remove</button>';
						if (in_array(itemId, settings.nestedItems))
						{
							$(this).html(rembtn);
							$('#' + settings.prefix + '_remove_item_' + itemId).click(function() {
								nestedRemoveItem(itemId);
							});
						} else {
							$(this).html(addbtn);
							$('#' + settings.prefix + '_add_item_' + itemId).click(function() {
								nestedAddItem(itemId);
							});
						}
						that.find('.column-tdfilter-position').text('');
						that.find('.column-sortable-position').text('');
					});
				}
			}
			/**
			 * Add item to category
			 * @param itemId integer
			 */
			function nestedAddItem(itemId)
			{
				// console.log('Add: ' + itemId);
				$.ajax({
					type: 'POST',
					url: settings.url,
					data: settings.prefix + '_nestedAddItem=1&' + settings.prefix + '_itemId=' + itemId + '&' + settings.prefix + '_norender=1',
					dataType: 'json',
					beforeSend: function() {
						_loader(that.closest('.widget-wrapper'));
					},
					complete: function() {
						_unloader(that.closest('.widget-wrapper'));
					},
					success: function() {
						$('.' + settings.prefix + '_nestedbtn_item_' + itemId).removeClass('btn-success').addClass('btn-danger').text('Remove');
						$('.' + settings.prefix + '_nestedbtn_item_' + itemId).off('click').click(function() {
							nestedRemoveItem(itemId);
						});
					},
					error: function() {
					}
				});
			}

			/**
			 * Remove Item from category
			 * @param itemId integer
			 */
			function nestedRemoveItem(itemId)
			{
				// console.log('Remove: ' + itemId);
				$.ajax({
					type: 'POST',
					url: settings.url,
					data: settings.prefix + '_nestedRemoveItem=1&' + settings.prefix + '_itemId=' + itemId + '&' + settings.prefix + '_norender=1',
					dataType: 'json',
					beforeSend: function() {
						_loader(that.closest('.widget-wrapper'));
					},
					complete: function() {
						_unloader(that.closest('.widget-wrapper'));
					},
					success: function() {
						$('.' + settings.prefix + '_nestedbtn_item_' + itemId).removeClass('btn-danger').addClass('btn-success').text('Add');
						$('.' + settings.prefix + '_nestedbtn_item_' + itemId).off('click').click(function() {
							nestedAddItem(itemId);
						});
					},
					error: function() {
					}
				});
			}

			/**
			 * Check if we are loading all items
			 * @returns {Boolean}
			 */
			function isAllItems()
			{
				if ($('.' + settings.prefix + '_notin').length > 0)
				{
					return true;
				}
				return false;
			}

			function nestedAllItems()
			{
				$.ajax({
					type: 'POST',
					url: settings.url,
					data: settings.prefix + '_notin=1',
					dataType: 'json',
					beforeSend: function() {
						_loader(that.closest('.widget-wrapper'));
					},
					complete: function() {
						_unloader(that.closest('.widget-wrapper'));
					},
					success: function() {
						$('#' + settings.prefix + '_add_items').text('Done Adding/Removing ' + settings.labelPlural).addClass('btn-success ' + settings.prefix + '_notin');
						$('#' + settings.prefix + '_add_items').off('click').click(function(e) {
							e.preventDefault();
							nestedItems();
						});
					},
					error: function() {
					}
				});
			}

			function nestedItems()
			{
				$.ajax({
					type: 'POST',
					url: settings.url,
					data: {},
					dataType: 'json',
					beforeSend: function() {
						_loader(that.closest('.widget-wrapper'));
					},
					complete: function() {
						_unloader(that.closest('.widget-wrapper'));
					},
					success: function() {
						$('#' + settings.prefix + '_add_items').text('Add ' + settings.labelPlural).removeClass('btn-success').removeClass(settings.prefix + '_notin');
						$('#' + settings.prefix + '_add_items').off('click').click(function(e) {
							e.preventDefault();
							nestedAllItems();
						});
					},
					error: function() {
					}
				});
			}
		}


		/**
		 * Return the current sorting
		 * @returns {String}
		 */
		function getCurrentSorting()
		{
			if (that.find('.column-sortable-active').length > 0)
			{
				return that.find('.column-sortable-active').attr('data-sortindex') + '-' + that.find('.column-sortable-active').attr('data-sortdir');
			}
		}

		/**
		 * Return the current page
		 * @returns {unresolved}
		 */
		function getCurrentPage()
		{
			return parseInt(that.find('.paginator').attr('data-currentpage'));
		}

		/**
		 * REtur current filters
		 * @returns {unresolved}
		 */
		function getCurrentFilters()
		{
			return that.find('.filter-input').serialize() + '&' + settings.prefix + '_filter=1' + (isAllItems() ? '&' + settings.prefix + '_notin=1' : '');
			;
		}

		/**
		 *
		 * @param {type} reset boolean If to reset
		 */
		function filterable(reset)
		{
			var formData = getCurrentFilters();
			if (reset === true)
			{
				formData += '&' + settings.prefix + '_filterReset=1';
			} else {
				formData += '&' + settings.prefix + '_filter=1';
			}
			$.ajax({
				type: 'POST',
				url: settings.url,
				dataType: 'json',
				data: formData,
				beforeSend: function() {
					_loader(that.closest('.widget-wrapper'));
				},
				complete: function() {
					_unloader(that.closest('.widget-wrapper'));
				}
			});
		}

		/**
		 * Sorting
		 */
		/**
		 * Fix Sorting
		 * @param {type} e
		 * @param {type} tr
		 * @returns {unresolved}
		 */
		function sortable_fixsorting(e, tr) {
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
		function sortable_renumber_table() {
			that.each(function() {
				count = $(this).parent().children().index($(this)) + 1;
				$(this).find('.sortable-order-num').html(count);
			});
			var sortingId = that.attr('id') + 'saveSorting';
			if (that.find('#' + sortingId).length < 1)
			{
				var tdCount = that.find('tr td').length;
				var newTr = '<tr id="' + sortingId + '" class="highlight row-highlight"><td colspan="' + tdCount + '" style="text-align:center;">';
				newTr += '<button type="submit" name="' + settings.prefix + '_submitSort" value="1" class="btn btn-success">Save Positions</button>';
				newTr += '&nbsp; <button type="submit" name="' + settings.prefix + '_submitSortReset" value="1" class="btn btn-danger">Reset</button>';
				newTr += '</td></tr>';
				that.find('thead tr:last').after(newTr);
			}
		}
		/**
		 * Sorting
		 */
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
	invalidHandler: function(event, validator) {
	},
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
/**
 * Saving State
 */
/**
 * Defer load widgets
 * @param target Target WidgetDiv
 * @returns void
 */
function _deferLoadWidget(target)
{
	if ($(target).hasClass('form-tab-content-nosubmit'))
	{
		$(target).closest('form').find('.form-actions').hide();
	} else {
		$(target).closest('form').find('.form-actions').show();
	}
	$(target).find('div[data-defer="1"]').each(function() {
		$.ajax({
			type: 'POST',
			url: $(this).attr('data-url'),
			dataType: 'json',
			data: {defer: 1},
			beforeSend: function() {
				_loader($(target));
			},
			complete: function() {
				_unloader($(target));
			}
		});
	});
}
$(document).ready(function() {
	$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
		$.cookie(cd_prefix() + 'last_tab', $(e.target).attr('href'));
		_deferLoadWidget($(e.target).attr('href'));

	});
	var lastTab = $.cookie(cd_prefix() + 'last_tab');
	if (lastTab && $('a[href=' + lastTab + ']').length > 0) {
		$('ul.nav-tabs').children().removeClass('active');
		$('a[href=' + lastTab + ']').parents('li:first').addClass('active');
		$('div.tab-content').children().removeClass('active');
		$(lastTab).addClass('active');
		_deferLoadWidget(lastTab);
	}
});
/**
 * Saving State
 */
/**
 * AJAX
 */
$.ajaxSetup({
	headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
});
/**
 * Process a JSON Object
 * @param json object The JSON Object
 * @returns void
 */
function jsonObject(json)
{
	// update token
	if (json._token !== undefined)
	{
		$('meta[name=_token]').attr('content', json._token);
	}
	if (json.messages !== undefined)
	{
		if (json.messages.toasts !== undefined)
		{
			$.each(json.messages.toasts, function() {
				_toast(this);
			});
		}
	}
	if (json.htmls !== undefined)
	{
		$.each(json.htmls, function() {
			_dom(this);
		});
	}
	if (json.scripts !== undefined)
	{
		$.each(json.scripts, function() {
			_script(this);
		});
	}
}
$(document).ajaxComplete(function(event, request, settings) {
	jsonObject(request.responseJSON);
});
$(document).ajaxError(function(event, request, settings) {
	_toast({type: 'error', msg: 'There was an error. Kindly try again later.', title: 'ERROR!'});
});
$(document).ajaxSend(function(event, request, settings) {
});
$(document).ajaxStart(function() {
});
$(document).ajaxStop(function() {
});
$(document).ajaxSuccess(function(event, request, settings) {
});
/**
 * AJAX
 */