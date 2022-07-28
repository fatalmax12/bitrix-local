<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("PopUp ajax");
CUtil::InitJSCore( array('ajax' , 'popup', 'ls' ));
?>

    <div id="hideBlock" style="display:none;">
        <form id="main-form" method="post" action="http://localhost/">
            <input name="name" type="text" placeholder="name" />
            <input name="secondname" type="text" placeholder="secondname" />
            <input  name="email" type="text" placeholder="email" />
        </form>
    </div>


    <script>
        let browserStorage = window.localStorage;
        const validateEmail = (email) => {
            return String(email)
                .toLowerCase()
                .match(
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                );
        };

        document.querySelector('#main-form input[name="email"]').addEventListener('change', (e) => {
            if (validateEmail(e.currentTarget.value)) {
                alert('correct email');
                e.currentTarget.setAttribute("aria-invalid", "false");
                e.currentTarget.style.outline = 'none';
            } else {
                alert('incorrect email');
                e.currentTarget.setAttribute("aria-invalid", "true");
                e.currentTarget.style.outline = '2px solid red';
            }
        });

        window.BXDEBUG = true;


        BX.ready(function(){
            let oPopup = new BX.PopupWindow('call_feedback', window.body, {
                autoHide : true,
                offsetTop : 1,
                offsetLeft : 0,
                lightShadow : true,
                closeIcon : false,
                closeByEsc : true,
                draggable: {restrict: false},
                // closeIcon: {right: "20px", top: "10px" },
                overlay: {
                    backgroundColor: 'red', opacity: '80'
                },
                titleBar: {content: BX.create("span", {html: '<b>Modal name</b>', 'props': {'className': 'access-title-bar'}})},
                buttons: [
                    new BX.PopupWindowButton({
                        text: "Push" ,
                        className: "popup-window-button-accept" ,
                        events: {
                            click: function(){
                                BX.PreventDefault();

                                BX.localStorage.set("form-name", document.querySelector('#main-form input[name="name"]').value, 60);
                                BX.localStorage.set("form-secondname", document.querySelector('#main-form input[name="secondname"]').value, 60);

                                browserStorage.setItem("form-name", document.querySelector('#main-form input[name="name"]').value);
                                browserStorage.setItem("form-secondname", document.querySelector('#main-form input[name="secondname"]').value);

                                BX.ajax.submit(BX("main-form"), function(data){
                                    BX('ajax-add-answer').innerHTML = data;
                                });
                            }
                        }
                    }),
                    new BX.PopupWindowButton({
                        text: "Close" ,
                        className: "webform-button-link-cancel" ,
                        events: {click: function(){
                                this.popupWindow.close();
                            }}
                    })
                ]

            });
            //ƒобавл€ем верстку контента в модальное окно по id.
            oPopup.setContent(BX('hideBlock'));
            
            BX.bindDelegate(
                document.body, 'click', {className: 'css_popup' },
                BX.proxy(function(e){
                    if(!e)
                        e = window.event;
                    oPopup.show();
                    return BX.PreventDefault(e);
                }, oPopup)
            );
        });
    </script>
    <div id="ajax-add-answer"></div>
    <button class="css_popup">Open PopUp</button>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>