function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

$(function() {
    var dates = $( "#date_begin, #date_end" ).datepicker({
        changeMonth: true,
        changeYear: true,
        onSelect: function( selectedDate ) {
            var option = this.id == "date_begin" ? "minDate" : "maxDate",
                instance = $( this ).data( "datepicker" ),
                date = $.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    $.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings );
            dates.not( this ).datepicker( "option", option, date );
        }
    });

    //Клик по экспорту в xml контент информера в ссылке в атрибуте data-content
    $("#ExportXml").popover({title: 'Обратитесь к разработчику'});

    //подсказка для экспорта
    $('#tooltip').tooltip({ placement: 'top'});

    //Клик по поискку по id - заявки
    $("#ButtomFaindId").click(function () {
        var searchId = $("input[name='ArchiveSearchId']").val();
        if ((Math.sign(+searchId) <= 0) || (!$.isNumeric(searchId))) {
            alert("Номер заявки неверен");
            return false;
        }
        $('form[name="ArchiveSearch"]').submit();
    });

});
function Archive(idArchiveShow) {
    if (!isNumeric(idArchiveShow)) { alert('Внимание попытка SQL - инъекции'); return; }
    //ajax
    $("#ArchiveBody").empty();
    var varAjax = document.location.origin+'/archive/ajax';
    $.ajax({
        type        : "POST",
        url         : varAjax,
        data        : { idArchiveShow: idArchiveShow },
        cache: false,
        beforeSend: function(request) {  // нужно для защиты от CSRF
            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        },
        success     : function(html) { $('#ArchiveBody').append(html);}
    });

    //$('#ACFirm').val('');
    $('#Archive').modal('show');

};