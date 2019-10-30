$(document).ready(function() {
    $("#BtnAddFirm").click(function () {
        var equipment = $('#equipment option:selected').text();
        var equipment_id = $('#equipment option:selected').val();
        $(".textModal").text(equipment);
        $("#QAddFirm_id").val(equipment_id);
        $("#QAddFirm").val($("#ACFirm").val());
        if (equipment_id == 0) alert('Сначала укажите вид техники');
            else $("#addFirm").modal('show');
    });

    $("#BtnRepairCreat").click(function () {
        var equipment = $('#equipment').val();
        var repfirm_id = $('#repfirm_id').val();
        var ACFirm = $('#ACFirm').val();
        var repmodel = $('#repmodel').val();
        var name = $('#customer').val();
        var phone = $('#phone').val();
        var package = $('#package').val();
        var malfunction = $('#malfunction').val();
        var sparepart = $('#sparepart').val();
        if (name == '') {
            alert("Укажите имя клиента");
            $('#customer').val('').focus();
            return false;
        }
        if (phone == '') {
            alert("Укажите телефон клиента");
            $('#phone').val('').focus();
            return false;
        }
        if ((/[=!№#$%&?<>{}^*@\.;":'a-zA-Zа-яА-Я]/).test(phone) == true) {
            alert('Телефонный номер должен соотоять из цифр');
            $('#phone').val('').focus();
            return false;
        }
        if (equipment == '0') {
            alert("Укажите вид техники");
            return false;
        }
        if ( (repfirm_id == '0') || (ACFirm == '') ) {
            alert("Укажите фирму производителя");
            return false;
        }
        if (repmodel == '') {
            alert("Укажите модель устройства");
            $('#repmodel').val('').focus();
            return false;
        }
        if (package == '') {
            alert("Не забудте о комплектности");
            $('#package').val('').focus();
            return false;
        }
        if (malfunction == '') {
            alert("Неисправность устройства");
            $('#malfunction').val('').focus();
            return false;
        }
        if (sparepart == '') {
            alert("Укажите запчасть");
            $('#sparepart').val('').focus();
            return false;
        }

        $('form[name="RepairCreat"]').submit();
    });

    //Событие по выбору вида техники
    $("#equipment").change(function() {
        if ($("#equipment").val() == 0) {
            $("#ACFirm").prop("disabled", true);
            $('#ACFirm').val('Фирма производитель');
        } else {
            $("#ACFirm").prop("disabled", false);
            $('#ACFirm').val('');
        }
    });

    //Ajax запрос по фирмам
    $("#ACFirm").autocomplete({
        source: function(request, response) {
            var term = request.term;
            var equipment_id = $("#equipment").val();
            var results;
            var varAjax = document.location.origin+'/repair/ajax';
            $.ajax({
                url: varAjax, // url запроса
                cache: false,
                dataType: 'json',
                data: {
                    maxRows: 30, // показать первые 12 результатов
                    nameFirm: term, // поисковая фраза
                    equipment_id: equipment_id // id фида техники
                },
                type: "POST", // устанавливаем типа запроса POST
                beforeSend: function(request) {  // нужно для защиты от CSRF
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function(data){
                results = $.map(data, function(item){
                    return {
                        plink: item.id,
                        label: item.name
                    }
                });
                    response(results);
            }
            })
        },
        select: function(event, ui) {

            $('#repfirm_id').val(ui.item.plink);
            $('#ACFirm').val(ui.item.label);
            return false;
        },
        minLength: 2
    });

    //Ajax добавление фирм
    $("#QFormForm").submit(function(event) {
        var postForm = $(this).serialize(); //собераем все данные из формы
        var varAjax = document.location.origin+'/repair/Fastadd/ajax';
        $.ajax({
            type        : "POST",
            url         : varAjax,
            data        : postForm,
            cache: false,
            beforeSend: function(request) {  // нужно для защиты от CSRF
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success     : function(html) { $('#form-feedback').append(html);}
        });
        event.preventDefault();
        $('#ACFirm').val('');
        $('#addFirm').modal('hide');

    });

});