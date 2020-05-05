jQuery(document).ready(function($){
    $(window).on('load', function () {
    // https://itchief.ru/lessons/javascript/javascript-clipboard
    // https://clipboardjs.com/
    // https://codepen.io/burnaDLX/pen/GowJpX

    // var clipboard = new ClipboardJS('[data-tooltip-sds-scrivo-highlighter]');
    var clipboard = new Clipboard('[data-tooltip-sds-scrivo-highlighter]');

    clipboard.on('success', function(e) {

        toastr.options.positionClass = "toast-top-center";
        toastr.success('&nbsp; &nbsp; Код скопирован');


    //     console.info('Action:', e.action);
    //     console.info('Text:', e.text);
    //     console.info('Trigger:', e.trigger);

        e.clearSelection();
    });

    clipboard.on('error', function(e) {
        toastr.options.positionClass = "toast-top-center";
        toastr.error('Что-то пошло не так 😥');

    //     console.error('Action:', e.action);
    //     console.error('Trigger:', e.trigger);
    });

    // ====================================

    // var clipboard_code = new ClipboardJS('[class=\"hljs sds-scrivo-highlighter-code\"]');
    var clipboard_code = new Clipboard('[class=\"hljs sds-scrivo-highlighter-code\"]');

    clipboard_code.on('success', function(e) {

        toastr.options.positionClass = "toast-top-center";
        toastr.success('&nbsp; &nbsp; Код скопирован');


    //     console.info('Action:', e.action);
    //     console.info('Text:', e.text);
    //     console.info('Trigger:', e.trigger);

    //     e.clearSelection();
    });

    clipboard_code.on('error', function(e) {
        toastr.options.positionClass = "toast-top-center";
        toastr.error('Что-то пошло не так 😥');

    //     console.error('Action:', e.action);
    //     console.error('Trigger:', e.trigger);
    });

    });
});



