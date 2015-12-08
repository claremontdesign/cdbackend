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