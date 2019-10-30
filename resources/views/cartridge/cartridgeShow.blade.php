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
                            <th>Фирма:</th>
                            <th>{!!$repair->repfirm->name!!}</th>
                        </tr>
                        <tr>
                            <th>Модель:</th>
                            <th>{!!$repair->printmodels->name!!}</th>
                        </tr>
                        <tr>
                            <th>Колличество:</th>
                            <th>{!!$repair->number!!}</th>
                        </tr>
                        <tr>
                            <th>Выполненые работы:</th>
                            <th>{!!$repair->datacartridge!!}</th>
                        </tr>
                        <tr>
                            <th>Цена:</th>
                            <th>{!!$repair->prices!!}</th>
                        </tr>
                        <tr>
                            <th>Исполнитель:</th>
                            <th>@if (isset($repair->staff->name)){!!$repair->staff->name!!}
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
            <img src="images/print.png" alt="Принтер">
            <div class="btn-group">
                <a class="btn btn-default" href="cartridge/{!!$repair->id!!}/edit"><span class="glyphicon glyphicon-pencil"> Редактировать</span></a>
                <a class="btn btn-default" href="cartridge/{!!$repair->id!!}/printed"><span class="glyphicon glyphicon-print"></span> Печать</a>
                <a class="btn btn-default" href="cartridge/{!!$repair->id!!}/del"><span class="glyphicon glyphicon-trash"> Удалить</span></a>
            </div>
            <p>
                {!! link_to_route('cartridge', 'Назад к списку заявок', null, ['class'=>'btn btn-default']) !!}
            </p>
        </div>
    </div>
    </div>
</div>

@stop