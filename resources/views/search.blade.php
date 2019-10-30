@extends('Main')

@section('head')

@stop

@section('content')
<?php $status = Session::get('status'); ?>
@if ( isset($status))
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4>{{$status}}</h4>
</div>
@endif
@if($count != 0)
<div class="alert alert-info">
    Коллицество найденых заявок <span class="badge">{{$count}}</span>
</div>
@else
<div class="alert alert-danger">
    По переданному № заявок нет
</div>
@endif
<div class="panel panel-default">
    <div class="panel-heading">Заявки по ремонту</div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped">
                @if (! $searchRepair == null )
                    <thead>
                    <tr>
                        <td>№</td>
                        <td>Дата</td>
                        <td>Имя</td>
                        <td>Телефон</td>
                        <td>Статус</td>
                        <td colspan="4" class="Actions">Действия</td>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>{!!$searchRepair->id!!}</th>
                            <th>{!!$searchRepair->date_begin!!}</th>
                            <th>{!!$searchRepair->customer!!}</th>
                            <th>
                                @unless(empty($searchRepair->phone))
                                    {{$searchRepair->phone}}
                                    @else Цена не заолнина
                                    @endunless
                            </th>
                            @if ($searchRepair->status == 0)
                                <th>Принят</th>
                            @elseif($searchRepair->status == 1)
                                <th class="danger">В процессе ремонта</th>
                            @elseif($searchRepair->status == 2)
                                <th class="info">Ожидает запчастей</th>
                            @elseif($searchRepair->status == 3)
                                <th class="success">Завершен</th>
                            @elseif($searchRepair->status == 4)
                                <th class="warning">Отдан</th>
                            @endif
                            <th><a class="btn btn-primary btn-xs" href="repair/{!!$searchRepair->id!!}/show"><span class="glyphicon glyphicon-fullscreen"></span> Просм</a></th>
                            <th><a class="btn btn-primary btn-xs" href="repair/{!!$searchRepair->id!!}/printed"><span class="glyphicon glyphicon-print"></span> Печать</a></th>
                            <th><a class="btn btn-primary btn-xs" href="repair/{!!$searchRepair->id!!}/edit"><span class="glyphicon glyphicon-pencil"></span>  Ред</a></th>
                            <th><a class="btn btn-primary btn-xs" href="repair/{!!$searchRepair->id!!}/del"><span class="glyphicon glyphicon-trash"></span> Удл</a></th>
                        </tr>
                    @else
                        <tr>
                            <td>СОобщений нет</td>
                        </tr>
                    @endif
                    </tbody>
            </table>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Заявки по заправке картриджей</div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped">
                @if (! $searchCart == null )
                    <thead>
                    <tr>
                        <td>№</td>
                        <td>Дата</td>
                        <td>Имя</td>
                        <td>Телефон</td>
                        <td>Фирма</td>
                        <td>Модель</td>
                        <td colspan="4" class="Actions">Действия</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>{!!$searchCart->id!!}</th>
                        <th>{!!$searchCart->date_begin!!}</th>
                        <th>{!!$searchCart->name!!}</th>
                        <th>{{$searchCart->phone}}</th>
                        <th>{{$searchCart->repfirm->name}}</th>
                        <th>{{$searchCart->printmodels->name}}</th>

                        <th><a class="btn btn-primary btn-xs" href="cartridge/{!!$searchCart->id!!}/show"><span class="glyphicon glyphicon-fullscreen"></span> Просм</a></th>
                        <th><a class="btn btn-primary btn-xs" href="cartridge/{!!$searchCart->id!!}/printed"><span class="glyphicon glyphicon-print"></span> Печать</a></th>
                        <th><a class="btn btn-primary btn-xs" href="cartridge/{!!$searchCart->id!!}/edit"><span class="glyphicon glyphicon-pencil"></span>  Ред</a></th>
                        <th><a class="btn btn-primary btn-xs" href="cartridge/{!!$searchCart->id!!}/del"><span class="glyphicon glyphicon-trash"></span> Удл</a></th>
                    </tr>
                    @else
                        <tr>
                            <td>СОобщений нет</td>
                        </tr>
                    @endif
                    </tbody>
            </table>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Запросы по запчастям</div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped">
                @if (! $searchSpare == null )
                    <thead>
                    <tr>
                        <td>№</td>
                        <td>Дата</td>
                        <td>Имя</td>
                        <td>Телефон</td>
                        <td>Статус</td>
                        <td colspan="4" class="Actions">Действия</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>{!!$searchSpare->id!!}</th>
                        <th>{!!$searchSpare->date_begin!!}</th>
                        <th>{!!$searchSpare->name!!}</th>
                        <th>{{$searchSpare->phone}}</th>
                        @if ($searchSpare->status == 0)
                            <th>Запрос</th>
                        @elseif($searchSpare->status == 1)
                            <th class="danger">Подтвержден</th>
                        @elseif($searchSpare->status == 2)
                            <th class="info">Отменен</th>
                        @endif
                        <th><a class="btn btn-primary btn-xs" href="spare/{!!$searchSpare->id!!}/show"><span class="glyphicon glyphicon-fullscreen"></span> Просм</a></th>
                        <th><a class="btn btn-primary btn-xs" href="spare/{!!$searchSpare->id!!}/printed"><span class="glyphicon glyphicon-print"></span> Печать</a></th>
                        <th><a class="btn btn-primary btn-xs" href="spare/{!!$searchSpare->id!!}/edit"><span class="glyphicon glyphicon-pencil"></span>  Ред</a></th>
                        <th><a class="btn btn-primary btn-xs" href="spare/{!!$searchSpare->id!!}/del"><span class="glyphicon glyphicon-trash"></span> Удл</a></th>
                    </tr>
                    @else
                        <tr>
                            <td>СОобщений нет</td>
                        </tr>
                    @endif
                    </tbody>
            </table>
        </div>
    </div>
</div>
@stop