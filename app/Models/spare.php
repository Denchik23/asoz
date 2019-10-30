<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class spare extends Model
{
    public function getSpareAll() {
        $repair = $this->latest()->paginate(10);
        return $repair;
    }

    public function getSpareCount($status = false) {
        if ($status) {
            $out = $this->where('status', '=', $status)->count();
            return $out;
        } else {
            $out = $this->count();
            return $out;
        }
    }

    //Удаление всех по ключам
    public function DelSpareKeyl($field, $value, $key=false) {
        if (!$key) {
            $out = $this->where($field, '=', $value)->delete();
            return $out;
        } else {
            $out = $this->find($value);
            $out->delete();
            return $out;
        }
    }
    //Удаление всех по статусу
    public function SpareDestroyAll($status) {
        $out = $this->where('status', '=', $status)->delete();
        return $out;
    }
    //Сортировка заявок по запросам
    public function spareOrder($sgl, $fieldsOrd) {
        $ord = $this->whereRaw($sgl)->paginate(10)->appends($fieldsOrd);
        return $ord;
    }
    //Колличество отсортированных заявок по запросам
    public function CountspareOrder($sgl) {
        $ord = $this->whereRaw($sgl)->count();
        return $ord;
    }

    //связь с вид техники
    public function equipment()
    {
        return $this->belongsTo('App\Models\equipment');
    }
    //связь с фирмами
    public function repfirm()
    {
        return $this->belongsTo('App\Models\repfirm');
    }

    //обработка дат
    public function getDateBeginAttribute($date) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y');
    }
    //Поля разрешенные для массовой записи
    protected $fillable = ['date_begin', 'name', 'phone', 'equipment_id', 'repfirm_id', 'repmodel',
        'sparepart', 'replacement', 'discription', 'prices', 'status'];
}
