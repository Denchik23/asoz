<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class archive extends Model
{
    public $ItemPagination = 50; //колличество записей на странице


    public function getArchiveaAll() {
        $out = $this->latest()->paginate($this->ItemPagination);
        return $out;
    }

    /**
     * Выборка всех записей для экспорта
     */
    public function getArchiveaAllExport() {
        $out = $this->latest()->get();
        return $out;
    }
    //показа по ключу
    public function getArchiveaId($id) {
        if ($out = $this->find($id))
            return $out;
        else return false;
    }
    //сортировка
    public function ArchiveaOrder($sgl, $fieldsOrd) {
        $ord = $this->whereRaw($sgl)->paginate($this->ItemPagination)->appends($fieldsOrd);
        return $ord;
    }
    //сортировка для экспорта
    public function ArchiveaOrderExport($sgl) {
        if ($ord = $this->whereRaw($sgl)->get()) return $ord; else return false;
    }
    //показа по номеру заявки
    public function getArchiveaId_repair($id) {
        if ($out = $this->where('id_repair', '=', $id)->paginate(5))
            return $out;
        else return false;
    }


    //Поля разрешенные для массовой записи
    protected $fillable = ['id_repair', 'date_begin', 'date_end', 'customer', 'phone', 'equipment', 'repfirm', 'repmodel',
        'serial', 'package', 'malfunction', 'prices', 'staff'];

    //обработка дат
    public function getDateBeginAttribute($date) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y');
    }
    public function getDateEndAttribute($date) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y');
    }
    public function getCreatedAtAttribute($date) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y H:i:s');
    }
}
