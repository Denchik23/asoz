@extends('Main')
@section('head')
    <script type="text/javascript">
        function confirmDelete() {
            if (confirm("Будут удалены так же все заявки по этому виду техники. Вы подтверждаете удаление?")) {
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
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Всего сотрудников: <span class="label label-default">{{$count}}</span></h4>
                </div>
                <div class="col-md-6 addNewEquipment">
                    <a href="staff/add" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-plus"></span> Добавить нового</a>
                </div>
            </div>
        </div>
    </div>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#masters" data-toggle="tab">Мастера</a></li>
        <li><a href="#Refueling" data-toggle="tab">Заправщики</a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="masters">
            @if ( isset($messages) )
                @foreach($messages as $message)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{$message['name']}}
                                @if ($message['holiday'] == 0) <span class="label label-warning"> В отпуске</span> @endif
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="{{$message['avatar']}}" alt="{{$message['name']}}">
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span class="badge">{{$message['countEnd']}}</span>
                                            Колличество выполненых заявок
                                        </li>
                                        <li class="list-group-item">
                                            <span class="badge">{{$message['countNoOut']}}</span>
                                            Не отданных
                                        </li>
                                        <li class="list-group-item">
                                            <span class="badge">{{$message['countBegin']}}</span>
                                            Заявок в работе
                                        </li>
                                        <li class="list-group-item">
                                            <span class="badge">{{$message['summ']}}</span>
                                            Общая сумма выполненых
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <p><a href="staff/{!!$message['id']!!}/edit" type="button" class="btn btn-primary btn-md btn-block"><span class="glyphicon glyphicon-pencil"></span>  Редактировать</a></p>
                                    <p><a href="staff/{!!$message['id']!!}/del" type="button" class="btn btn-danger btn-md btn-block" onclick="return confirmDelete();"><span class="glyphicon glyphicon-trash"></span> Удалить</a></p>
                                    <p>
                                        @if ($message['holiday'] == 1)
                                            <a href="staff/{!!$message['id']!!}/holiday" type="button" class="btn btn-warning btn-md btn-block">  Отпуск</a>
                                        @else
                                            <a href="staff/{!!$message['id']!!}/holiday" type="button" class="btn btn-warning btn-md btn-block">  На работу</a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Нет данных</p>
            @endif
        </div>
        <div class="tab-pane" id="Refueling">
            @if ( isset($Refueling) )
                @foreach($Refueling as $message)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{$message['name']}}
                                @if ($message['holiday'] == 0) <span class="label label-warning"> В отпуске</span> @endif
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="{{$message['avatar']}}" alt="{{$message['name']}}">
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span class="badge">{{$message['Cartridgecount']}}</span>
                                            Всего заявок
                                        </li>
                                        <li class="list-group-item">
                                            <span class="badge">{{$message['CartridgecountD']}}</span>
                                            Заявок за день
                                        </li>
                                        <li class="list-group-item">
                                            <span class="badge">{{$message['CartridgeSumm']}}</span>
                                            Общая сумма за день
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3">
                                    <p><a href="staff/{!!$message['id']!!}/edit" type="button" class="btn btn-primary btn-md btn-block"><span class="glyphicon glyphicon-pencil"></span>  Редактировать</a></p>
                                    <p><a href="staff/{!!$message['id']!!}/del" type="button" class="btn btn-danger btn-md btn-block" onclick="return confirmDelete();"><span class="glyphicon glyphicon-trash"></span> Удалить</a></p>
                                    <p>
                                        @if ($message['holiday'] == 1)
                                            <a href="staff/{!!$message['id']!!}/holiday" type="button" class="btn btn-warning btn-md btn-block">  Отпуск</a>
                                        @else
                                            <a href="staff/{!!$message['id']!!}/holiday" type="button" class="btn btn-warning btn-md btn-block">  На работу</a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Нет данных</p>
            @endif
        </div>
    </div>
@stop