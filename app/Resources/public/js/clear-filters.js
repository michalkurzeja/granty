(function($) {
    $.fn.extend({
        clearFilters: function() {
            function clear($form) {
                $form.find('input, select').val('');
            }

            return this.each(function() {
                $(this).on('click', 'button[data-clear-filters]', function() {
                    var $form = $(this).closest('form');

                    clear($form);
                    $form.submit();
                });
            });
        }
    });
})(jQuery);
