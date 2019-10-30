<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class repfirm extends Model
{
    //Сортировка в фирмах
    public function getrepfirmOrder($id)
    {
        if (!empty($id)) {
            $out = $this->where('equipment_id', '=', $id)->latest()->paginate(15)->appends(['equipment_id' => $id]);
            return $out;
        } else {
            $out = $this->with('equipment')->latest()->paginate(15);
            return $out;
        }
    }
    //Сортировка в моделях ОТКАЗАТЬСЯ В ПОСЛЕДСТИВИИ
    public function getrepfirmOrder2($id)
    {
        if (!empty($id)) {
            $out = $this->where('equipment_id', '=', $id)->get();
            return $out;
        } else {
            $out = $this->select('id', 'name')->get();
            return $out;
        }
    }
    //Получение фирм кроме текущей
    public function getrepfirmNoKey($id = false)
    {
        if ($id) {
            $out = $this->Cartridge()->where('id', '!=', $id)->get();
            return $out;
        } else {
            $out = $this->Cartridge()->get();
            return $out;
        }
    }

    //Подсчет колличества для разных целей моделях
    public  function getrepfirCount($id)
    {
        if (!empty($id)) {
            $out = $this->where('equipment_id', '=', $id)->count();
            return $out;
        } else {
            $out = $this->select('id', 'name')->get();
            return $out;
        }
    }
    //удаление по ключу
    public function DelrepfirmKey($id)
    {
        $out = $this->find($id);
        $out->delete();
    }
    //scope фирм картриджей
    public function scopeCartridge($query)
    {
        $query->where('equipment_id', '=', 4);
    }
    //связь с вид техники
    public function equipment()
    {
        return $this->belongsTo('App\Models\equipment');
    }
    //Поля разрешенные для массовой записи
    protected $fillable = ['equipment_id', 'name'];
}
