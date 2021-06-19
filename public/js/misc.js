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

    name: function (elementName) {
        let nodes = document.getElementsByName(elementName);
        return nodes.length > 0 ? nodes[0] : null;
    },

    nameAll: function (elementName) {
        return document.getElementsByName(elementName);
    },
};

let LoadingButton = function (button, ...strings) {
    let buttonElem = typeof button == "string" ? Elem.id(button) : button;
    return {
        _el: buttonElem,

        loadingText: strings[0],
        readyText: strings.length == 1 ? buttonElem.innerHTML : strings[1],
        fallbackText: buttonElem.innerHTML,

        loading: function () {
            this._el.disabled = true;
            this._el.innerHTML = `<i class="fas fa-sync fa-spin"></i> ${this.loadingText}`;
        },

        ready: function () {
            this._el.disabled = false;
            this._el.innerHTML = this.readyText;
        },

        fallback: function () {
            this._el.disabled = false;
            this._el.innerHTML = this.fallbackText;
        }
    };
};

let Utils = {
    _i18n: {
        'fields_cannot_be_empty': 'These fields cannot be empty:',
        'form_is_not_completed': 'Form is not completed',
    },

    i18n: function (strings) {
        this._i18n = {...this._i18n, ...strings};
    },

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

    validate: function (...inputs) {
        let invalid = [];
        inputs.forEach(input => {
            let value = input.value;
            if (!value) {
                input.classList.add('is-invalid');
                invalid[invalid.length] = input.name;
            } else {
                input.classList.remove('is-invalid');
            }
        });
        if (invalid.length != 0) {
            let toastBody = `${this._i18n.fields_cannot_be_empty} ${invalid.join(', ')}`;
            this.toast('bg-warning', 0, this._i18n.form_is_not_completed, toastBody);
            return false;
        }
        return true;
    },

    elementsByName: function (...names) {
        let elements = {}
        names.forEach(name => {
            elements[name] = Elem.name(name);
        });
        return elements;
    }
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
