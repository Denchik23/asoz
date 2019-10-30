<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">Просмотр заявки № - <b>{!!$messages->id_repair!!}</b></h4>
</div>
<!-- Основной текст сообщения -->
<div class="modal-body">
<table class="table table-bordered">
    <tbody>
    @if ( count($messages) === 1 && isset($messages))
        <tr>
            <th class="active">Дата начала:</th>
            <th>{!!$messages->date_begin!!}</th>
        </tr>
        <tr>
            <th class="active">Дата Окончания:</th>
            <th>{!!$messages->date_end!!}</th>
        </tr>
        <tr>
            <th class="active">Дата архивирования:</th>
            <th>{!!$messages->created_at!!}</th>
        </tr>
        <tr>
            <th class="active">Имя заказчика:</th>
            <th>{!!$messages->customer!!}</th>
        </tr>
        <tr>
            <th>Телефон заказчика:</th>
            <th>{!!$messages->phone!!}</th>
        </tr>
        <tr>
            <th>Вид техники:</th>
            <th>{!!$messages->equipment!!}</th>
        </tr>
        <tr>
            <th>Фирма:</th>
            <th>{!!$messages->repfirm!!}</th>
        </tr>
        <tr>
            <th>Модель:</th>
            <th>{!!$messages->repmodel!!}</th>
        </tr>
        <tr>
            <th>Серийный номер:</th>
            <th>{!!$messages->serial!!}</th>
        </tr>
        <tr>
            <th>Комплектность:</th>
            <th>{!!$messages->package!!}</th>
        </tr>
        <tr>
            <th>Неисправность:</th>
            <th>{!!$messages->malfunction!!}</th>
        </tr>
        <tr>
            <th>Цена:</th>
            <th>{!!$messages->prices!!}</th>
        </tr>
        <tr>
            <th>Исполнитель:</th>
            <th>{!!$messages->staff!!}</th>
        </tr>
    @else
        <tr>
            <td>Информация о заявке недостуна. Обратитесь к разарботчику</td>
        </tr>
    @endif
    </tbody>
</table>
    </div>