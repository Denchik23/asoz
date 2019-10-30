@extends('Main')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Номер заказа № {{$repair->id}}</h3>
    </div>
    <div class="panel-body">
    <div class="row">
        <div class="col-md-7">
            <table id="tablePrint" class="table table-bordered">
                <tbody>
                    @if ( count($repair) === 1 && isset($repair))
                        <tr>
                            <th class="active">Дата начала:</th>
                            <th>{!!$repair->date_begin!!}</th>
                        </tr>
                            <tr>
                                <th class="active">Дата Окончания:</th>
                                @if ($repair->date_end == '30.11.-0001')
                                    <th class="danger">Еще в работе</th>
                                @else
                                    <th>{!!$repair->date_end!!}</th>
                                @endif
                            </tr>
                        <tr>
                            <th class="active">Имя заказчика:</th>
                            <th>{!!$repair->customer!!}</th>
                        </tr>
                        <tr>
                            <th>Телефон заказчика:</th>
                            <th>{!!$repair->phone!!}</th>
                        </tr>
                        <tr>
                            <th>Вид техники:</th>
                            <th>{!!$repair->equipment->name!!}</th>
                        </tr>
                        <tr>
                            <th>Фирма:</th>
                            <th>{!!$repair->repfirm->name!!}</th>
                        </tr>
                        <tr>
                            <th>Модель:</th>
                            <th>{!!$repair->repmodel!!}</th>
                        </tr>
                        <tr>
                            <th>Серийный номер:</th>
                            <th>{!!$repair->serial!!}</th>
                        </tr>
                        <tr>
                            <th>Комплектность:</th>
                            <th>{!!$repair->package!!}</th>
                        </tr>
                        <tr>
                            <th>Неисправность:</th>
                            <th>{!!$repair->malfunction!!}</th>
                        </tr>
                        <tr>
                            <th>Цена:</th>
                            <th>{!!$repair->prices!!}</th>
                        </tr>
                        <tr>
                            <th>Готовность заказа:</th>
                            <th>
                                @if ($repair->status == 1)
                                    Принят
                                @elseif($repair->status == 2)
                                    В процессе ремонта
                                @elseif($repair->status == 3)
                                    Ожидает запчастей
                                @elseif($repair->status == 4)
                                    Завершен
                                @elseif($repair->status == 5)
                                    Отдан
                                @endif
                            </th>
                        </tr>
                        <tr>
                            <th>Исполнитель:</th>
                            <th>@if (!isset($repair->staff->name)){!!$repair->staff->name!!}
                            @else Уволен @endif</th>
                        </tr>
                    @else
                        <tr>
                            <td>Информация о заявке недостуна. Обратитесь к разарботчику</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="col-md-5 ImgEquiment">
            <img src="{{$repair->equipment->picture}}" alt="Принтер">
            <div class="btn-group">
                <a class="btn btn-default" href="repair/{!!$repair->id!!}/edit"><span class="glyphicon glyphicon-pencil"> Редактировать</span></a>
                <a class="btn btn-default" href="repair/{!!$repair->id!!}/printed"><span class="glyphicon glyphicon-print"></span> Печать</a>
                <a class="btn btn-default" href="repair/{!!$repair->id!!}/del"><span class="glyphicon glyphicon-trash"> Удалить</span></a>
            </div>
            <p style="margin-top: 10px;">
                {!! link_to_route('repair', 'Назад к списку заявок', null, ['class'=>'btn btn-default']) !!}
            </p>
        </div>
    </div>
    </div>
</div>

@stop