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
                            <th class="active">Имя заказчика:</th>
                            <th>{!!$repair->name!!}</th>
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
                            <th>Запчасть:</th>
                            <th>{!!$repair->sparepart!!}</th>
                        </tr>
                        <tr>
                            <th>Цена запчасти:</th>
                            <th>{!!$repair->prices!!}</th>
                        </tr>
                        <tr>
                            <th>Стоимость замены:</th>
                            <th>{!!$repair->replacement!!}</th>
                        </tr>
                        <tr>
                            <th>Готовность заказа:</th>
                            <th>
                                @if ($repair->status == 1)
                                    Запрос
                                @elseif($repair->status == 2)
                                    Подтвержден
                                @elseif($repair->status == 3)
                                    Отменен
                                @endif
                            </th>
                        </tr>
                        <tr>
                            <th>Коментарий:</th>
                            <th>{!!$repair->discription!!}</th>
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
            <img src="images/laptop_parts.jpg" alt="Деталь">
            <div class="btn-group">
                <a class="btn btn-default" href="spare/{!!$repair->id!!}/edit"><span class="glyphicon glyphicon-pencil"> Редактировать</span></a>
                <a class="btn btn-default" href="spare/{!!$repair->id!!}/printed"><span class="glyphicon glyphicon-print"></span> Печать</a>
                <a class="btn btn-default" href="spare/{!!$repair->id!!}/del"><span class="glyphicon glyphicon-trash"> Удалить</span></a>
            </div>
            <p style="margin-top: 10px;">
                {!! link_to_route('spare', 'Назад к списку запросов', null, ['class'=>'btn btn-default']) !!}
            </p>
        </div>
    </div>
    </div>
</div>

@stop