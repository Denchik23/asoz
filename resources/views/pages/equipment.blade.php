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
                    <h4>Всего видов деятельности: <span class="label label-default">{{$count}}</span></h4>
                </div>
                <div class="col-md-6 addNewEquipment">
                    <a href="repair/equipment/add" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-plus"></span> Добавить новый</a>
                </div>
            </div>
        </div>
    </div>
    @if ( isset($messages) )
        @foreach($messages as $message)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$message['name']}}</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{$message['picture']}}" alt="{{$message['name']}}">
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <span class="badge">{{$message['countEnd']}}</span>
                                    Колличество завершенных заявок
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
                            <p><a href="repair/equipment/{!!$message['id']!!}/edit" type="button" class="btn btn-primary btn-md btn-block"><span class="glyphicon glyphicon-pencil"></span>  Редактировать</a></p>
                            <p><a href="repair/equipment/{!!$message['id']!!}/del" type="button" class="btn btn-danger btn-md btn-block @if($message['id'] == 4)disabled @endif" onclick="return confirmDelete();"><span class="glyphicon glyphicon-trash"></span> Удалить</a></p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>Нет данных</p>
    @endif
@stop