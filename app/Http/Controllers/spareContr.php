<?php

namespace App\Http\Controllers;

use App\Models\equipment;
use App\Models\spare;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class spareContr extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(spare $spare, Request $request)
    {

        $equipment = equipment::all();
        $ArrayEqu[0] = 'Вся техника';
        foreach ($equipment as $item) {
            $ArrayEqu[$item->id] = $item->name;
        }
        $messages = $spare->getSpareAll();
        foreach ($messages as $item) {
            $item->discription = $this->truncation($item->discription, 30);
        }
        $oldOrderfields = [
            'date_begin' => $request->get('date_begin', ''),
            'date_end' => $request->get('date_end', ''),
            'equipment_id' => $request->get('equipment_id', 0),
            'repfirm_id' => $request->get('repfirm_id', 0),
            'ACFirm' => $request->get('ACFirm', 'Фирма производитель'),
            'status' => $request->get('status', 0)
        ];
        $data = [
            'pagetitle' => 'Все заявки',
            'title'=> 'Запросы на запчасти',
            'oldOrderfields' => $oldOrderfields,
            'messages' => $messages,
            'equipment' => $ArrayEqu,
            'count' => $spare->count()
        ];

        return view('spare.spare')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title'=> 'Запросы на запчасти',
            'pagetitle' => 'Создание нового запроса',
            'equipment' => equipment::all()
        ];
        return view('spare.spareCreate')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, spare $spare)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $rules= ['name' => 'required',
                'phone' => 'required',
                'repmodel' => 'required',
                'sparepart' => 'required'
            ];
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                return redirect()->to('spare/create')->withInput()->withErrors($validator);
            }
            $spare->create($request->only('date_begin', 'name', 'phone', 'equipment_id', 'repfirm_id', 'repmodel',
                'sparepart', 'replacement', 'discription', 'prices', 'status'));
            return redirect()->route('spare')->with('status', 'Новая заявка успешна создана');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $spare = spare::find($id);
        $data = ['title'=> 'Запросы на запчасти',
            'pagetitle' => 'Просмотр запроса',
            'repair' => $spare];
        return view('spare.spareShow')->with($data);
    }

    //Печать
    public function printed($id)
    {
        $spare = spare::find($id);
        $data = ['title'=> 'Запросы на запчасти',
            'spare' => $spare];
        return view('print.sparePrinted')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(equipment $equipment, $id)
    {
        $spareEdit = spare::find($id);
        $strdate = $spareEdit->date_begin;
        $strdate=strtotime($strdate);
        $strdate = date('Y-m-d', $strdate);

        $data = [
            'title'=> 'Запросы на запчасти',
            'pagetitle' => 'Редактирование запроса',
            'repair' => $spareEdit,
            'strdate' => $strdate,
            'equipment' => $equipment->getEquipmentBesides($spareEdit->equipment->id)
        ];

        return view('spare.spareEdit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->isMethod('post')) {

            $input = $request->all();
            $rules= ['name' => 'required',
                'phone' => 'required',
                'repmodel' => 'required',
                'sparepart' => 'required'
            ];
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                return redirect()->route('spare.edit', ['id'=>$id])->withErrors($validator);
            }

            $id = $_POST['id'];
            $update = spare::find($id);
            $update->date_begin = $_POST['date_begin'];
            $update->name = $_POST['name'];
            $update->phone = $_POST['phone'];
            $update->equipment_id = $_POST['equipment_id'];
            $update->repfirm_id = $_POST['repfirm_id'];
            $update->repmodel = $_POST['repmodel'];
            $update->sparepart = $_POST['sparepart'];
            $update->replacement = $_POST['replacement'];
            $update->discription = $_POST['discription'];
            $update->prices = $_POST['prices'];

            $update->status = $request->input('status');

            $update->save();
            return redirect()->route('spare')->with('status', 'Запрос с номером '.$id.' успешно обновлен');
        }
    }

    //Сортировка
    public function order(Request $request, spare $spare)
    {
        if ($request->isMethod('get')) {
            $fields = $request->only('date_begin', 'date_end', 'equipment_id', 'repfirm_id', 'status');
            $str = '';
            foreach ($fields as $key => $value) {
                if ($value != 0) {
                    switch ($key) {
                        case 'date_begin':
                            $strdate = strtotime($value);
                            $strdate = date('Y-m-d', $strdate);
                            $str = ('date_begin >= "'.$strdate.'" and ');
                            break;
                        case 'date_end':
                            $strdate = strtotime($value);
                            $strdate = date('Y-m-d', $strdate);
                            $str .= ('date_begin <= "'.$strdate.'" and ');
                            break;
                        default:
                            $str .= ($key . ' = ' . $value . ' and ');
                    }
                }
            }
            if (empty($str)) {
                $messages = $spare->getSpareAll();
                $count = $spare->count();
            } else {
                $str = substr($str, 0, -5);
                $messages = $spare->spareOrder($str, $fields);
                $count = $spare->CountspareOrder($str);
            }

            $equipment = equipment::all();
            $ArrayEqu[0] = 'Вся техника';
            foreach ($equipment as $item) {
                $ArrayEqu[$item->id] = $item->name;
            }
            $oldOrderfields = [
                'date_begin' => $request->get('date_begin', ''),
                'date_end' => $request->get('date_end', ''),
                'equipment_id' => $request->get('equipment_id', 0),
                'repfirm_id' => $request->get('repfirm_id', 0),
                'ACFirm' => $request->get('ACFirm', 'Фирма производитель'),
                'status' => $request->get('status', 0)
            ];
            $data = [
                'pagetitle' => 'Сортировка',
                'title'=> 'Запросы на запчасти',
                'oldOrderfields' => $oldOrderfields,
                'messages' => $messages,
                'equipment' => $ArrayEqu,
                'count' => $count
            ];

            return view('spare.spare')->with($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(spare $spare, $id)
    {
        $del = $spare->DelSpareKeyl('', $id, true);
        return redirect()->route('spare')->with('status', 'Запрос с номером '.$id.' успешно удален');
    }

    //обрезка строки для коментариев
    public function truncation($str, $length)
    {
        if (strlen($str) > $length) {
        $str=substr($str, 0, $length);        //Обрезаем до заданной длины
        $words=explode(" ", $str);            //Разбиваем по словам
        $last = array_pop($words);                //Получаем последнее слово
        for ($i = 1; $i < strlen($last); $i++) {
            //Ищем и удаляем в конце последнего слова все кроме букв и цифр
            if (preg_match('/\W$/', substr($last, -1, 1))) $last = substr($last, 0, strlen($last) - 1);
            else break;
        }
        return implode(" ", $words).'...';
        } else return $str;
    }
}
