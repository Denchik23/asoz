////Клик по удалению
function confirmDelete() {
    if (confirm("Будут удалены так же все заявки по данной фирме. Вы подтверждаете удаление?")) {
        return true;
    } else {
        return false;
    }
}
$(document).ready(function() {
    //Клик по добавлению фирм
    $("#ButtonNewFirm").click(function () {
        var name = $('input[name="name"]').val();
        if ($('.equipmentAll').val() == '0') {
            alert("Укажите вид техники");
            return false;
        }
        if (name == '') {
            alert("У фирмы должно быть название");
            $('input[name="name"]').val('').focus();
            return false;
        }
        $('form[name="ButtonNewFirm"]').submit();
    });

    //Клик по добавлению модели
    $("#BtnModelsCreat").click(function () {
        var boolean = true;
        var nameModel = $('input[name="name"]').val();
        if ($('#repfirm').val() == '0') {
            alert("Укажите фирму картриджа");
            return false;
        }
        if (nameModel == '') {
            alert("У картриджа должно быть название");
            $('input[name="name"]').val('').focus();
            return false;
        }
        $('input[type="number"]').each(function (i,elem) {
            if ($(this).val() == '') {
                $(this).focus();
                boolean = false;
            }
        });
        if (boolean == false) {
            alert("Поле цена должно быть заполнено.");
            return false;
        }

        $('form[name="ModelsCreat"]').submit();
    });

});