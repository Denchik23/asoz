<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class repair extends Model
{
    public function getRepairAll() {
        $repair = $this->latest()->paginate(15);
        return $repair;
    }
    //Удаление всех по фирмам
    public function DelRepairFromFirm($id_firm) {
        $countDel = $this->where('repfirm_id', '=', $id_firm)->delete();
        return $countDel;
    }
    //Колличество заявок
    public function getRepairCount($type = "0", $field, $id) {
        switch ($type) {
            case '0':
                return false;
            case 'all':
                $cout = $this->count();
                return $cout;
            case 'Done':
                if ($id != 0) {
                    $cout = $this->CountStatusIn('>=')->where($field, '=', $id)->count();
                    return $cout;
                } else {
                    $cout = $this->CountStatusIn('>=')->count();
                    return $cout;
                }
            case 'not_done':
                if ($id != 0) {
                    $cout = $this->CountStatusIn('<')->where($field, '=', $id)->count();
                    return $cout;
                } else {
                    $cout = $this->CountStatusIn('<')->count();
                    return $cout;
                }
            case 'cast':
                if ($id != 0) {
                    $cout = $this->CountStatus(4)->where($field, '=', $id)->count();
                    return $cout;
                } else {
                    $cout = $this->CountStatus(4)->count();
                    return $cout;
                }
        }
    }
    //Сумма по полю "Цена ремонта"
    public function getRepairsumm($type = "0", $field, $id) {
        switch ($type) {
            case '0':
                return false;
            case 'all':
                $cout = $this->sum('prices');
                return $cout;
            case 'made':
                if ($id != 0) {
                    $cout = $this->where($field, '=', $id)->CountStatusIn('>=')->CountM()->sum('prices');
                    return $cout;
                } else {
                    $cout = $this->CountStatusIn('>=')->CountM()->sum('prices');
                    return $cout;
                }
            case 'Unsatisfied':
                if ($id != 0) {
                    $cout = $this->where($field, '=', $id)->CountStatusIn('>')->sum('prices');
                    return $cout;
                } else {
                    $cout = $this->CountStatusIn('>')->sum('prices');
                    return $cout;
                }
        }
    }
    //Сортировка заявок по ремонту
    public function repairOrder($sgl, $fieldsOrd) {
        $ord = $this->whereRaw($sgl)->paginate(15)->appends($fieldsOrd);
        return $ord;
    }
    //Колличество отсортированных заявок по ремонту
    public function CountrepairOrder($sgl) {
        $ord = $this->whereRaw($sgl)->count();
        return $ord;
    }
    //запрос для добавленя в архив (только завершенные 3 менсяца назад)
    public function repairArchive() {
        $Arc = $this->CountStatus(5)->ArchiveM()->latest()->paginate(50);
        return $Arc;
    }
    public function getArchiveCount() {
        $cout = $this->CountStatus(5)->ArchiveM()->count();
        return $cout;
    }
    public function getArchiveArray($idArray = array()) {
        $out = $this->whereIn('id', $idArray)->get();
        return $out;
    }


    //scope для статуса заявок
    public function scopeCountStatusIn($query, $status)
    {
        $query->where('status', $status, 4);
    }
    public function scopeCountStatus($query, $status)
    {
        $query->where('status', '=', $status);
    }
    public function scopeCountM($query)
    {
        $datelast = strtotime(date("Y-m-t", strtotime("-1 month")));

        $datelastM = date('Y-m-d', $datelast);
        //dd($datelastM);
        $query->where('date_end', '>', $datelastM);
    }
    public function scopeArchiveM($query)
    {
        $datelast3 = strtotime(date("Y-m-d", strtotime("-3 month")));

        $datelastA = date('Y-m-d', $datelast3);
        //dd($datelastA);
        $query->where('date_end', '<', $datelastA);
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
    //связь с сотрудниками
    public function staff()
    {
        return $this->belongsTo('App\Models\staff');
    }


    //обработка дат
    public function getDateBeginAttribute($date) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y');
    }
    public function getDateEndAttribute($date) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y');
    }


    //Поля разрешенные для массовой записи
    protected $fillable = ['date_begin', 'customer', 'phone', 'equipment_id', 'repfirm_id', 'repmodel',
'serial', 'package', 'malfunction', 'prices', 'status', 'staff_id'];

}
