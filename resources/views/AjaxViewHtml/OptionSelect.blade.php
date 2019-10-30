@if (! $OptionSelects->isEmpty())
    @foreach($OptionSelects as $firm)
        <option value="{{$firm->id}}">{{$firm->name}}</option>
    @endforeach
@else
    <option value="0">Нет данных</option>
@endif