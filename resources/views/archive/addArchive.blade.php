@extends('Main')

@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.theme.min.css')}}">
    <link rel="stylesheet" href="{{asset('js/Datepicker/jquery-ui.theme.min.css')}}">
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script src="{{asset('js/scriptRepairCreat.js')}}"></script>
    <script>
        function RemoveAllCheckboxes() {
            $("input:checkbox").removeAttr("checked");
        }
        $(function() {

        });
    </script>
@stop

@section('content')
    <?php $errorsF = Session::get('errorsF'); ?>
    <?php if (isset($errorsF)) { $message = Session::get('message'); $logs = Session::get('logs');} ?>
    @if ( isset($errorsF))
        <div class="alert alert-{{ $errorsF ? 'success' : 'danger' }}">
            <h4>{{$message}}</h4>
            @if ( isset($logs))
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Смотреть логи</a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body">
                            <ul>{!! $logs !!}</ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif
    {!! Form::open(['route'=>'archive.store', 'method' => 'post']) !!}
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-7 panelArchiveLeft">Коллицество потенциальных заявок для добавления в архив  <span class="badge">{{$count}}</span></div>
                <div class="col-md-5 panelArchiveRight">
                    <button id="ButtomArchive" type="submit" class="btn btn-primary">Архивировать</button>
                    <a href="javascript:RemoveAllCheckboxes();" class="btn btn-primary">Снять галочки</a>
                </div>
            </div>
        </div>
    </div>

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
                <td>Отметьте</td>
            </tr>
            </thead>
            <tbody>
            <?php $i = 0; ?>
            @foreach($messages as $message)
                <tr>
                    <th>{!!$message->id!!}</th>
                    <th>{!!$message->date_begin!!}</th>
                    <th>{!!$message->date_end!!}</th>
                    <th>{!!$message->customer!!}</th>
                    <th>{!!$message->repfirm->name!!}</th>
                    <th>{!!$message->repmodel!!}</th>
                    <th><input type="checkbox" name="addArchiveId{!!$i!!}" checked="checked" value="{!!$message->id!!}"></th>
                </tr>
                <?php $i++; ?>
            @endforeach
            @else
                <tr>
                    <td>Нет кондидатов на добавление в архив</td>
                </tr>
            @endif
            </tbody>
    </table>
    <div class="text-center">
        {!!$messages->render()!!}
    </div>
</div>
    {!! Form::Close() !!}
@stop