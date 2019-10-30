<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class cartridge extends Model
{
    public function getCartridgeAll() {
        $out = $this->latest()->paginate(15);
        return $out;
    }
    //Удаление всех по фирмам
    public function DelcartridgeFromFirm($id_firm) {
        $countDel = $this->where('repfirm_id', '=', $id_firm)->delete();
        return $countDel;
    }
    //Удаление всех по моделям
    public function DelcartridgeFromModel($id_firm) {
        $countDel = $this->where('printmodels_id', '=', $id_firm)->delete();
        return $countDel;
    }
    //удаление по ключу
    public function DelcartridgeKey($id)
    {
        $out = $this->find($id);
        $out->delete();
    }
    //Колличество заявок
    public function getCartridgeCount($type, $field = false, $value = false) {
        switch ($type) {
            case 'all':
                if (($field) && ($value)) $cout = $this->where($field, '=', $value)->count();
                else $cout = $this->count();
                return $cout;
            case 'lastDay':
                if (($field) && ($value)) $cout = $this->where($field, '=', $value)->CountD()->count();
                else $cout = $this->CountD()->count();
                return $cout;
        }
    }
    //Сумма по полю "Цена"
    public function getCartridgeSumm($field = false, $value = false) {
        if (($field) && ($value)) {
            $cout = $this->where($field, '=', $value)->CountD()->sum('prices');
            return $cout;
        } else {
            $cout = $this->CountD()->sum('prices');
            return $cout;
        }
    }

    //scopes
    public function scopeCountD($query)
    {
        $query->where('date_begin', '>=', date('Y-m-d'));
    }

    //Сортировка заявок по заправке
    public function cartridgeOrder($sgl, $fieldsOrd) {
        $ord = $this->whereRaw($sgl)->paginate(15)->appends($fieldsOrd);
        return $ord;
    }
    //Колличество отсортированных заявок по заправке
    public function CountcartridgeOrder($sgl) {
        $ord = $this->whereRaw($sgl)->count();
        return $ord;
    }
    //связь с фирмами
    public function repfirm()
    {
        return $this->belongsTo('App\Models\repfirm');
    }
    //связь с моделями
    public function printmodels	()
    {
        return $this->belongsTo('App\Models\repmodel');
    }
    //связь с сотрудниками
    public function staff()
    {
        return $this->belongsTo('App\Models\staff');
    }

    //обработка дат
    public function getDateBeginAttribute($date) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y');
    }
    //Поля разрешенные для массовой записи
    protected $fillable = ['date_begin', 'name', 'phone', 'repfirm_id', 'printmodels_id', 'datacartridge',
        'staff_id', 'number', 'prices'];
}
