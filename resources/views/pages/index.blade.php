@extends('Main')

@section('head')
    <script type="text/javascript">
        function confirmDelete(string_Q) {
            if (confirm(string_Q)) {
                return true;
            } else {
                return false;
            }
        }
    </script>
@stop

@section('content')
    <?php $status = Session::get('status'); ?>
    @if ( isset($status))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4>{{$status}}</h4>
        </div>
    @endif
    <ul class="nav nav-tabs">
        <li class="active"><a href="#repair" data-toggle="tab">Ремонт техники</a></li>
        <li><a href="#Cartridge" data-toggle="tab">Заправка картриджей</a></li>
        <li><a href="#spare" data-toggle="tab">Запросы на запчатси</a></li>
        <li><a href="#messages" data-toggle="tab">Сообщения <span class="badge" style="background: red;">!</span></a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="repair">
            <div class="row">
                <div class="col-md-3">
                    <img src="images/nout3.png" alt="Ноутбук">
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">Информация:</div>
                        <div class="panel-body">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <span class="badge">{{$count}}</span>
                                    Количество всех заявок
                                </li>
                                <li class="list-group-item">
                                    <span class="badge">{{$countEnd}}</span>
                                    Количество завершенных заявок
                                </li>
                                <li class="list-group-item">
                                    <span class="badge">{{$countNoOut}}</span>
                                    Не отданных
                                </li>
                                <li class="list-group-item">
                                    <span class="badge">{{$countBegin}}</span>
                                    Заявок в работе
                                </li>
                                <li class="list-group-item">
                                    <span class="badge">{{$summ}}</span>
                                    Общая сумма выполненых
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <p><a href="repair/create" type="button" class="btn btn-primary btn-md btn-block"><span class="glyphicon glyphicon-plus"></span>  Добавить новую заявку</a></p>
                    <p><a href="#" type="button" class="btn btn-danger btn-md btn-block" onclick="return confirmDelete();"><span class="glyphicon glyphicon-trash"></span> Удалить</a></p>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="Cartridge">
            <div class="row">
                <div class="col-md-3">
                    <img src="images/cartridge.png" alt="Заправка">
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">Информация:</div>
                        <div class="panel-body">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <span class="badge">{{$Cartridgecount}}</span>
                                    Всего заявок
                                </li>
                                <li class="list-group-item">
                                    <span class="badge">{{$CartridgecountM}}</span>
                                    Заявок за день
                                </li>
                                <li class="list-group-item">
                                    <span class="badge">{{$CartridgeSumm}}</span>
                                    Общая сумма за день
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <p><a href="cartridge/create" type="button" class="btn btn-primary btn-md btn-block"><span class="glyphicon glyphicon-plus"></span>  Добавить новую заявку</a></p>
                    <p><a href="#" type="button" class="btn btn-danger btn-md btn-block" onclick="return confirmDelete();"><span class="glyphicon glyphicon-trash"></span> Удалить в старые заявки</a></p>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="spare">
            <div class="row">
                <div class="col-md-3">
                    <img src="images/laptop_parts.jpg" alt="Запросы">
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">Информация:</div>
                        <div class="panel-body">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <span class="badge">{{$SparecountEnd}}</span>
                                    Количество подтвержденнных запросов
                                </li>
                                <li class="list-group-item">
                                    <span class="badge">{{$SparecountBegin}}</span>
                                    Количество отмененных запросов
                                </li>
                                <li class="list-group-item">
                                    <span class="badge">{{$Sparecount}}</span>
                                    Всего запросов
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <p><a href="spare/create" type="button" class="btn btn-primary btn-md btn-block"><span class="glyphicon glyphicon-plus"></span>  Добавить новый запрос</a></p>
                    <p><a href="SpareDestroyAll" type="button" class="btn btn-danger btn-md btn-block" onclick="return confirmDelete('Будут удалены все отмененные заявки. Вы уверены?');"><span class="glyphicon glyphicon-trash"></span> Удалить все отмененные<br>запросы</a></p>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="messages">
            <p>Web - приложение обновлено, текщая версия 1.1.2 (работает кнопка "Удалить все отменнные запрсы"), так же добалнленна сортировака по статусу.</p>
        </div>
    </div>
@stop