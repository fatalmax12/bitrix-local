window.BXDEBUG = true;

const validateEmail = (email) => {
    const symbol = email.indexOf("@");

    const emailParams = {
        symbol: symbol,
        symbolCount: [...email].filter(el => el === '@').length,
        dot: symbol !== -1 ? email.indexOf(".", symbol) : symbol,
    };

    if (
        //кол-во "@" должно быть равно одному
        emailParams.symbolCount !== 1
        //Должна быть точка поле "@"
        || emailParams.dot === -1
        //email не менее 5-х символов "e@e.e"
        || email.length < 5
        //Точка не должна быть последней
        || emailParams.dot === email.length - 1
        //Точка не должна стоять после символа "@"
        || (emailParams.symbol + 1) === emailParams.dot
    ) return false;

    return true;
};

BX.ready(function () {
    let browserStorage = window.localStorage;

    document.querySelector('#main-form input[name="email"]').addEventListener('change', (e) => {
        if (validateEmail(e.currentTarget.value)) {
            alert(BX.message("CORRECT_EMAIL"));
            e.currentTarget.setAttribute("aria-invalid", "false");
            e.currentTarget.style.outline = 'none';
        } else {
            alert(BX.message("INCORRECT_EMAIL"));
            e.currentTarget.setAttribute("aria-invalid", "true");
            e.currentTarget.style.outline = '2px solid red';
        }
    });

    let modalWindow = new BX.PopupWindow('call_feedback', window.body, {
        autoHide: true,
        offsetTop: 1,
        offsetLeft: 0,
        lightShadow: true,
        closeIcon: false,
        closeByEsc: true,
        draggable: {restrict: false},
        // closeIcon: {right: "20px", top: "10px" },
        overlay: {
            backgroundColor: 'red', opacity: '80'
        },
        titleBar: {content: BX.create("span", {html: '<b>Modal name</b>', 'props': {'className': 'access-title-bar'}})},
        buttons: [
            new BX.PopupWindowButton({
                text: "Push",
                className: "popup-window-button-accept",
                events: {
                    click: function () {
                        BX.PreventDefault();

                        BX.localStorage.set("form-name", document.querySelector('#main-form input[name="name"]').value, 60);
                        BX.localStorage.set("form-secondname", document.querySelector('#main-form input[name="secondname"]').value, 60);

                        browserStorage.setItem("form-name", document.querySelector('#main-form input[name="name"]').value);
                        browserStorage.setItem("form-secondname", document.querySelector('#main-form input[name="secondname"]').value);

                        // BX.ajax.submit(BX("main-form"), function(data){
                        //     BX('ajax-add-answer').innerHTML = data;
                        // });

                        let fields = BX.findChild(BX('main-form'), {class: 'person-field'}, true, true);

                        BX.ajax({
                            url: '/localhost',
                            data: {
                                sessid: BX.bitrix_sessid(),
                                name: fields[0].value,
                                secondname: fields[1].value,
                                email: fields[2].value,
                            },
                            method: 'POST',
                            dataType: 'json',
                            timeout: 30,
                            async: true,
                            processData: true,
                            scriptsRunFirst: true,
                            emulateOnload: true,
                            start: true,
                            cache: false,
                            onsuccess: function (data) {
                                if (parseInt(data.ID) > 0) {
                                    BX('ajax-add-answer').append(data);
                                } else {
                                    console.log(data.ID);
                                }
                            },
                            onfailure: function () {
                                //---
                            }
                        });
                    }
                }
            }),

            new BX.PopupWindowButton({
                text: "Close",
                className: "webform-button-link-cancel",
                events: {
                    click: function () {
                        this.popupWindow.close();
                    }
                }
            })
        ]

    });
    //Добавляем верстку контента в модальное окно по id.
    modalWindow.setContent(BX('hideBlock'));

    // BX.bindDelegate(
    //     document.body,
    //     'click',
    //     { className: 'css_popup' },
    //     BX.proxy(function (e) {
    //         if (!e)
    //             e = window.event;
    //         modalWindow.show();
    //         return BX.PreventDefault(e);
    //     }, modalWindow)
    // );

    const showModalWindow = function (e) {
        modalWindow.show();
        return BX.PreventDefault(e);
    }

    BX.bind(
        BX('css_popup'),
        'click',
        showModalWindow
    )
});