let Elem = {
    id: function (elementId) {
        return document.getElementById(elementId);
    },

    cls: function (className) {
        return document.getElementsByClassName(className);
    },

    tag: function (tagName) {
        return document.getElementsByTagName(tagName);
    },

    q: function (selector) {
        return document.querySelector(selector);
    },

    qAll: function (selector) {
        return document.querySelectorAll(selector);
    },
};

let LoadingButton = function (button, ...strings) {
    let buttonElem = typeof button == "string" ? Elem.id(button) : button;
    return {
        _el: buttonElem,

        loadingText: strings[0],
        readyText: strings.length == 1 ? buttonElem.innerHTML : strings[1],

        loading: function () {
            this._el.disabled = true;
            this._el.innerHTML = `<i class="fas fa-sync fa-spin"></i> ${this.loadingText}`;
        },

        ready: function () {
            this._el.disabled = false;
            this._el.innerHTML = this.readyText;
        },
    };
};

let Utils = {
    timerPicker: function (elementId) {
        $('#' + elementId).datetimepicker({
            icons: { time: 'far fa-clock' },
            format: 'DD.MM.YYYY HH:mm',
            minDate: moment(),
            defaultDate: moment(),
        });
    },

    toast: function (style, timeout, title, body) {
        return $(document).Toasts('create', {
            class: style,
            title: title,
            body: body,
            autohide: timeout > 0,
            delay: timeout,
        });
    },
};

let Request = {
    internal: function (url, request, doneCallback, failCallback, alwaysCallback) {
        $.post(url, request)
            .done(function (data) {
                if (data.ok) {
                    doneCallback(data);
                } else {
                    failCallback(data);
                }
            })
            .fail(function (response) {
                let data = {
                    ok: false,
                    error: response.responseJSON.message ? response.responseJSON.message : 'Internal server error.',
                }
                failCallback(data);
            }).always(alwaysCallback);
    },
};


$(function () {
    $('.nav-treeview .nav-link, .nav-link').each(function () {
        var location2 = window.location.protocol + '//' + window.location.host + window.location.pathname;
        var link = this.href;
        if (link == location2) {
            $(this).addClass('active');
            $(this).parent().parent().parent().addClass('menu-is-opening menu-open');

        }
    });

    $('.btn-delete').on('click', function () {
        return confirm();
    });
})
