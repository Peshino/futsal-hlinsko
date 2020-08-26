$(document).ready(() => {
    if (Cookies.get('gdpr_cookie_bar') === '1') {
        $('#cookie-bar')
            .addClass('d-none')
            .removeClass('d-flex');
    } else {
        $('#cookie-bar')
            .addClass('d-flex')
            .removeClass('d-none');
    }

    $('[data-toggle="tooltip"]').tooltip();

    $('.toast').toast('show');

    $('#cookie-bar-button').click(() => {
        Cookies.set('gdpr_cookie_bar', '1', {
            expires: 365
        });
        $('#cookie-bar')
            .addClass('d-none')
            .removeClass('d-flex');
    });

    // $('.navbar-nav .nav-link').click(() => {
    //     $('.navbar-nav .nav-link').removeClass('active');
    //     $(this).addClass('active');
    // });

    setTimeout(() => {
        $('.alert').fadeOut(500);
    }, 7500);

    if ($('body textarea').length) {
        const textareaId = $('body textarea').attr('id');
        const $textarea = $('#' + textareaId);
        const $div = $textarea.closest('div');

        if (localStorage.getItem(textareaId) !== null) {
            $textarea.val(localStorage.getItem(textareaId));

            if ($textarea.val().length > 0) {
                $div.addClass('has-value');
            } else {
                $div.removeClass('has-value');
            }
        }

        $textarea.on('input', event => {
            localStorage.setItem(textareaId, $textarea.val());
        });

        $('body form').submit(event => {
            const $inputs = $('body form textarea');
            $inputs.each(item => {
                localStorage.removeItem($inputs[item].id);
            });
        });
    }

    var actualUrl = window.location.href;
    $('.navbar-nav .nav-item > a[href="' + actualUrl + '"]').parent().addClass('active');

    $('footer a#created-by').on('click mouseover', (event) => {
        event.preventDefault();

        var $title = $('footer #created-by').attr('data-original-title'),
            newTitle = $title.replace(' at ', '@');

        $('footer #created-by').attr('data-original-title', newTitle);
    });

    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

    $('.floating-label .custom-select, .floating-label .form-control').floatinglabel();

    // Date Range Picker
    $('input[name="datefilter"]').daterangepicker({
        autoUpdateInput: false,
        autoApply: true,
        drops: 'auto',
        locale: {
            applyLabel: 'Potvrdit',
            cancelLabel: 'Zrušit',
            fromLabel: 'od',
            toLabel: 'do',
            customRangeLabel: 'vlastní',
            weekLabel: 'W',
            daysOfWeek: [
                'Ne',
                'Po',
                'Út',
                'St',
                'Čt',
                'Pá',
                'So'
            ],
            monthNames: [
                'Leden',
                'Únor',
                'Březen',
                'Duben',
                'Květen',
                'Červen',
                'Červenec',
                'Srpen',
                'Září',
                'Říjen',
                'Listopad',
                'Prosinec'
            ],
            firstDay: 1
        },
    });

    $('input[name="datefilter"]').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('D. M. YYYY') + ' - ' + picker.endDate.format('D. M. YYYY'));
        checkForInput(this);
    });

    $('input[name="datefilter"]').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
        checkForInput(this);
    });

    function checkForInput(element) {
        const $div = $(element).closest('div');

        if ($(element).val().length > 0) {
            $div.addClass('has-value');
        } else {
            $div.removeClass('has-value');
        }
    }

    if ($('.email-replace').length > 0) {
        var emailReplace = $('.email-replace').html().replace(' at ', '@');
        $('.email-replace').html(emailReplace);
    }

    $('.toast').toast('show');
});
