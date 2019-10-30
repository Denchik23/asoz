@extends('Main')

@section('head')
    <script src="{{asset('js/repairFirms.js')}}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="panel panel-default">
                <div class="panel-body">
                    {!! Form::open(['route'=>'cartridge.modelsOrder', 'class'=>'form-inline', 'method' => 'get']) !!}
                    <div class="form-group">
                        <h4>Сортировать по: </h4>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="repfirm_id">Email</label>
                        <select class="form-control" name="repfirm_id">
                            <option value="0">Все фирмы</option>
                            @foreach($repfirm as $firm)
                                @if ($firm->id == $repfirm_id)
                                    <option value="{{$firm->id}}" selected>{{$firm->name}}</option>
                                @else
                                    <option value="{{$firm->id}}">{{$firm->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <button id="ButtomOrder" type="submit" class="btn btn-primary">Показать</button>
                    {!! Form::Close() !!}
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Колицество моделей  <span class="badge">{{$count}}</span></div>
                <div class="panel-body">
                    <?php $status = Session::get('status'); ?>
                    @if ( isset($status))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4>{{$status}}</h4>
                        </div>
                    @endif
                    <table class="table table-striped">
                        @if (! $messages->isEmpty() )
                            <thead>
                            <tr>
                                <td>№</td>
                                <td>Название модели</td>
                                <td>Фирма</td>
                                <td colspan="2">Действия</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($messages as $message)
                                <tr>
                                    <th>{!!$message->id!!}</th>
                                    <th>{!!$message->name!!}</th>
                                    <th>{!!$message->repfirm->name!!}</th>
                                    <th><a class="btn btn-primary btn-xs" href="cartridge/{!!$message->id!!}/modelsEdit"><span class="glyphicon glyphicon-pencil"></span>  Редактировать</a></th>
                                    <th><a class="btn btn-primary btn-xs" href="cartridge/{!!$message->id!!}/modelsdel" onclick="return confirmDelete();"><span class="glyphicon glyphicon-trash"></span> Удалить</a></th>
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
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel panel-primary">
                <div class="panel-heading">Добавить новую модель</div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <h4>Предупреждение!</h4>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    @include('cartridge._formModels')
                </div>
            </div>
        </div>
    </div>
@stop