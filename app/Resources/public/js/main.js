(function($) {
    $(function() {
        $(document).foundation();
        $(document).confirm({
            text: 'Jesteś pewien?',
            label: {
                confirm: 'Tak',
                cancel: 'Anuluj'
            }
        });
    });
})(jQuery);

