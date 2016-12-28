(function($) {
    $(function() {
        var $document = $(document);

        $document.foundation();

        $document.confirm({
            text: 'Jesteś pewien?',
            label: {
                confirm: 'Tak',
                cancel: 'Anuluj'
            }
        });

        $document.clearFilters();

        $document.on('change', 'input[type=file]', function() {
            var fileNameParts = $(this).val().split('\\');
            $(this).siblings('.selected-file-name').text(fileNameParts[fileNameParts.length -1]);
        });
    });
})(jQuery);

