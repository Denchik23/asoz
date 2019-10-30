$(document).ready(function() {

    //Событие по выбору фирмы картриджа
    $("#cartridgfirm").change(function() {
        if ($("#cartridgfirm").val() == 0) {
            $("#ACModel").prop("disabled", true);
            $('#ACModel').val('Модель картриджа');
        } else {
            $("#ACModel").prop("disabled", false);
            $('#ACModel').val('');
        }
    });

    //Ajax запрос по моделям картриджей
    $("#ACModel").autocomplete({
        source: function(request, response) {
            var term = request.term;
            var repfirm_id = $("#cartridgfirm").val();
            var results2;
            var varAjax = document.location.origin+'/cartridge/ajax'; // url запроса
            $.ajax({
                url:   varAjax,
                cache: false,
                dataType: 'json',
                data: {
                    maxRows: 30, // показать первые 12 результатов
                    nameFirm: term, // поисковая фраза
                    repfirm_id: repfirm_id // id фида картриджа
                },
                type: "POST", // устанавливаем типа запроса POST
                beforeSend: function(request) {  // нужно для защиты от CSRF
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function(data){
                    results2 = $.map(data, function(item){
                        return {
                            plink: item.id,
                            label: item.name
                        }
                    });
                    response(results2);
                }
            })
        },
        select: function(event, ui) {

            $('#printmodels_id').val(ui.item.plink);
            $('#ACModel').val(ui.item.label);
            //Ajax блока работ
            var printmodels_id = ui.item.plink;
            var varAjax2 = document.location.origin+'/cartridge/Modelajax'; // url запроса
            $.ajax({
                type        : "POST",
                url         : varAjax2,
                data        : {id: printmodels_id},
                cache: false,
                beforeSend: function(request) {  // нужно для защиты от CSRF
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success     : function(html) {
                    $('#DivDatacartridge').empty();
                    $('#DivDatacartridge').append(html);
                }
            });
            return false;
        },
        minLength: 2
    });

    //клик по кнопке расчета стоимости
    $(document).on('click', '#BtnCalculate', function(){
        var number = $('#number').val();
        var nameCh;
        var namePr;
        var SummaW=0;
        $('input:checked').each(function (index, domEle) {
            nameCh = $(this).attr("name");
            namePr = $("input[name='"+nameCh.substr(2)+"']").val();
            SummaW = (SummaW + parseInt(namePr, 10));
        });
        SummaW = SummaW*number;
        $('#prices').val(SummaW);
    });

    //клик по input checkbox
    $(document).on('click', 'input[type="checkbox"]', function(){
        $("input[name='prices']").val('');
    });
    //изменение по input number
    $(document).on('change', 'input[type="number"]', function(){
        $("input[name='prices']").val('');
    });

    //Клик по кнопке сохранить заявку
    $("#BtnCartridgeCreat").click(function () {

        if ($("#cartridgfirm").val() == '0') {
            alert("Выбирете фирму производителя");
            $("#ACModel").focus();
            return false;
        }
        if ($("#ACModel").val() == '') {
            alert("Введите модель картриджа");
            $("#ACModel").focus();
            return false;
        }
        if ($("#prices").val() == '') {
            alert("Не расчитана стоимость заявки");
            $("input[name='prices']").focus();
            return false;
        }
        $('form[name="cartridgeCreat"]').submit();
    })

    //Клик по кнопке сохранить Calculator
    $("#Calculator").click(function () {

        alert("Финкционал этой кнопки находится в стадии разработки");
        return false;

        $('form[name="Calculator"]').submit();
    })


});