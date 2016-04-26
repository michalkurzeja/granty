(function($) {
    $.fn.extend({
        confirm: function(options) {
            if (options == null) {
                options = {};
            }

            var pluginSettings = resolvePluginSettings(options);

            var confirm = function($element) {
                var settings = resolveSettings(pluginSettings, getDataSettings($element));

                var $modal = buildModal(settings);

                $modal.find('button').click(function() {
                    $modal.foundation('close');
                });

                $modal.find('button[data-button-confirm=1]').click(function() {
                    if ($element.is('a')) {
                        return $element.removeAttr('data-confirm')[0].click();
                    }

                    return $element.closest('form').removeAttr('data-confirm').submit();
                });

                $modal.foundation('open');

                return false;
            };

            function buildModal(settings) {
                var $modal = $('' +
                    '<div id="modal-confirm" class="reveal" data-reveal>' +
                        '<button class="close-button" data-close aria-label="Close modal" type="button">' +
                            '<span aria-hidden="true">&times;</span>' +
                        '</button>' +
                        '<div class="row">' +
                            '<div class="column">' +
                                '<p>' + settings.text + '</p>' +
                                '<hr>' +
                            '</div>' +
                        '</div>' +
                        '<div class="row">' +
                            '<div class="column">' +
                                '<button class="button warning" data-button-confirm="1">' + settings.label.confirm + '</button>' +
                                '<button class="button" data-button-confirm="0">' + settings.label.cancel + '</button>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '');

                $('body').append($modal);
                $modal.foundation();

                return $modal;
            }

            var handler = function() {
                return confirm($(this));
            };

            function getDataSettings($element) {
                var options = {};

                options['text'] = $element.data('confirm-text');

                return options;
            }

            function resolvePluginSettings(pluginSettings) {
                return resolveSettings({
                    text: 'Are you sure?',
                    label: {
                        confirm: 'Confirm',
                        cancel: 'Cancel'
                    }
                }, pluginSettings);
            }

            function resolveSettings(pluginSettings, dataSettings) {
                return $.extend(pluginSettings, dataSettings);
            }

            return this.each(function() {
                $(this).on('click', 'a[data-confirm], :input[data-confirm]', handler);
                $(this).on('submit', 'form[data-confirm]', handler);
            });
        }
    });
})(jQuery);