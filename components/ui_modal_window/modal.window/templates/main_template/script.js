document.addEventListener('DOMContentLoaded', function () {
    let openPanelButton = document.querySelector('.show_panel');
    openPanelButton.addEventListener('click', function () {
        //alert("open side-panel");
        BX.SidePanel.Instance.open(
            //'https://www.yandex.ru'
            "/crm/deal/novaya-stranitsa.php"
            , {
            requestMethod: "post",
            width: 500,
            cacheable: true,
            mobileFriendly: true,
            allowChangeHistory: false,
            label: {
                text: "Закрыть панель",
                color: "#FFFFFF",
                bgColor: "#E2AE00",
                opacity: 80
            },
            // contentCallback: function(slider) {
            //     let promise = new BX.Promise();
            //     return promise;
            // },
        });

    });
});
