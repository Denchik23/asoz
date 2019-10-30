@extends('Main')

@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.theme.min.css')}}">
    <link rel="stylesheet" href="{{asset('js/Datepicker/jquery-ui.theme.min.css')}}">
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script src="{{asset('js/scriptArchive.js')}}"></script>
    <script src="{{asset('js/Datepicker/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/Datepicker/datepicker.regional.js')}}"></script>
@stop

@section('content')
    <div id="Archive" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content" id="ArchiveBody">
                <!-- Заголовок модального окна -->

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    {!! Form::open(['route'=>'archive.order', 'class'=>'form-inline', 'method' => 'get']) !!}
                    <div class="form-group">
                        <h4>Сортировать по Датe:</h4>
                    </div>
                    <div class="form-group">
                        {!! Form::label('date_begin', 'Датe:', ['class'=>'sr-only']) !!}
                        {!! Form::text('date_begin', $oldOrderfields['date_begin'], ['class'=>'form-control', 'placeholder' => 'С']) !!}
                        {!! Form::label('date_end', 'Дате:', ['class'=>'sr-only']) !!}
                        {!! Form::text('date_end', $oldOrderfields['date_end'], ['class'=>'form-control', 'placeholder' => 'По']) !!}
                    </div>

                    <button id="ButtomOrder" type="submit" class="btn btn-primary">Показать</button>
                    {!! Form::Close() !!}

                    {!! Form::open(['route'=>'archive.faind', 'class'=>'form-inline', 'method' => 'get', 'name' => 'ArchiveSearch']) !!}
                    <div class="form-group">
                        <h4>Поиск  по номеру заявки:  </h4>
                    </div>
                    <div class="form-group">
                        {!! Form::label('ArchiveSearchId', '№ заявки:', ['class'=>'sr-only']) !!}
                        {!! Form::input('text', 'ArchiveSearchId', $oldOrderfields['ArchiveSearchId'], ['class'=>'form-control', 'placeholder'=>'№ заявки']) !!}
                    </div>
                    <button id="ButtomFaindId" type="submit" class="btn btn-primary">Найти</button>
                    {!! Form::Close() !!}
                </div>
            </div>
        </div>
        <div class="col-md-3" id="rightArchive">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Экспорт <span id="tooltip" class="glyphicon glyphicon-info-sign" title="Экспорт зависит от текущей сортировки"></span> </h3>
                    <div class="btn-group btn-group-justified">
                        <a id="ExportXml" class="btn btn-default {{ ($messages->isEmpty()) ? 'disabled':''}}" href="javascript:void(0);" data-container="body" data-placement="top" data-content="Если требуется выгрузка в XML для определенного сервиса."><span class="glyphicon glyphicon-export"></span>  В XML</a>
                        <a class="btn btn-default {{ ($messages->isEmpty()) ? 'disabled':''}}" href="archive/export/excel"><span class="glyphicon glyphicon-export"></span>  В Excel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<p>Коллицество заявок  <span class="badge">{{$count}}</span></p>
    <?php $status = Session::get('status'); ?>
@if ( isset($status))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4>{{$status}}</h4>
    </div>
@endif

<div class="table-responsive">
    <table class="table table-striped">
        @if (! $messages->isEmpty() )
            <thead>
            <tr>
                <td>№</td>
                <td>Дата приемки</td>
                <td>Дата отдачи</td>
                <td>Имя</td>
                <td>Фирма</td>
                <td>Модель</td>
                <td colspan="2">Действия</td>
            </tr>
            </thead>
            <tbody>
            @foreach($messages as $message)
                <tr>
                    <th>{!!$message->id_repair!!}</th>
                    <th>{!!$message->date_begin!!}</th>
                    <th>{!!$message->date_end!!}</th>
                    <th>{!!$message->customer!!}</th>
                    <th>{!!$message->repfirm!!}</th>
                    <th>{!!$message->repmodel!!}</th>
                    <th><a class="btn btn-primary btn-xs" href="javascript:Archive({!!$message->id!!})"><span class="glyphicon glyphicon-fullscreen"></span> Просм</a></th>
                    <th><a class="btn btn-primary btn-xs" href="archive/{!!$message->id!!}/printed"><span class="glyphicon glyphicon-print"></span> Печать</a></th>
                </tr>
            @endforeach
        @else
            <tr>
                <td>Нет данных</td>
            </tr>
        @endif
            </tbody>
    </table>
    <div class="text-center">
        {!!$messages->render()!!}
    </div>
</div>
@stop