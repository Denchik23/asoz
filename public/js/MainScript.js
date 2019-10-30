/**
 * Появление модального окна с настройками из базы
 * @constructor
 */
function SetingModal() {

    //ajax
    $("#Seating div.modal-body").empty();
    var varAjax = document.location.origin+'/setting/ajax';
    $.ajax({
        type        : "GET",
        url         : varAjax,
        cache: false,
        beforeSend: function(request) {  // нужно для защиты от CSRF
            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        },
        success     : function(html) { $('#Seating div.modal-body').append(html);}
    });
    //появление формы
    $('#Seating').modal('show');
};


$(document).ready(function() {
    //Клик по поиску в шапке (валидация)
    $("#search").click(function () {
        var searchId = $("input[name='searchId']").val();
        if ((Math.sign(+searchId) <= 0) || (!$.isNumeric(searchId))) {
            alert("Номер заявки неверен");
            return false;
        }
        $('form[name="search"]').submit();
    });

    //Сохранение настроек
    $(document).on('submit', '.setForm', function(){
        $("#AjaxReturn").empty();
        var buttton = $(this).find("button[type='submit']");
        buttton.button('loading');
        var postForm = $(this).serialize();
        var varAjax = document.location.origin+'/setting/update';

        $.ajax({
            type        : "POST",
            url         : varAjax,
            data        : postForm,
            cache: false,
            beforeSend: function(request) {  // нужно для защиты от CSRF
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success     : function(html) { $('#AjaxReturn').append(html);}
        }).always(function () {
            buttton.button('reset');
        });

        event.preventDefault();
    });
});