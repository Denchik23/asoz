<?php

namespace App\Http\Controllers;

use App\Models\equipment;
use App\Models\repfirm;
use App\Models\staff;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\repair;
use Illuminate\Support\Facades\Validator;

class repairContr extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(repair $repair, Request $request)
    {
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
            'pagetitle' => 'Все заявки',
            'title' => 'Ремонт',
            'oldOrderfields' => $oldOrderfields,
            //'messages' => repair::latest()->paginate(30), //Аналог::orderBy('created_at', 'desc')->get()
            'messages' => $repair->getRepairAll(),
            'equipment' => $ArrayEqu,
            'count' => $repair->getRepairCount("all", "", "")
        ];
        return view('pages.repair')->with($data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(staff $staff, equipment $equipment)
    {
        $Staf = $staff->getStaffMasters();
        $holidayStaff = [];
        foreach ($Staf as $item) {
            $holidayStaff[$item->id] = $item->name;
        }
        $data = [
            'title'=> 'Ремонт',
            'pagetitle' => 'Создание новой заявки',
            'equipment' => $equipment->getEquipmentBesides(4),
            'holidayStaff' => $holidayStaff
        ];
        return view('pages.repairCreate')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(repair $repair, Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $rules = ['customer' => 'required',
                'package' => 'required|min:3',
                'malfunction' => 'required'
            ];
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                return redirect()->to('repair/create')->withInput()->withErrors($validator);
            }
            $repair->create($request->only('date_begin', 'customer', 'phone', 'equipment_id', 'repfirm_id', 'repmodel',
                'serial', 'package', 'malfunction', 'prices', 'status', 'staff_id'));
            return redirect()->route('repair')->with('status', 'Новая заявка успешна создана');
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
        $repair = repair::find($id);
        //dd($repair);
        $data = ['title'=> 'Ремонт',
            'pagetitle' => 'Просмотр заявки',
            'repair' => $repair];
        return view('pages.repairShow')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function printed($id)
    {
        $repair = repair::find($id);
        //dd($repair);
        $data = ['title'=> 'Ремонт',
            'repair' => $repair];
        return view('print.repairPrinted')->with($data);
    }

    public function edit(staff $staff, equipment $equipment, $id)
    {
        $repairEdit = repair::find($id);
        $strdate = $repairEdit->date_begin;
        $strdate = strtotime($strdate);
        $strdate = date('Y-m-d', $strdate);

        $Staf = $staff->getStaffMasters();
        $holidayStaff = [];
        foreach ($Staf as $item) {
            $holidayStaff[$item->id] = $item->name;
        }

        $data = [
            'title' => 'Ремонт',
            'pagetitle' => 'Редактирование заявки',
            'repair' => $repairEdit,
            'strdate' => $strdate,
            'holidayStaff' => $holidayStaff,
            'equipment' => $equipment->getEquipmentBesides($repairEdit->equipment->id)
            //'firms' => repfirm::where('id', '!=', $repairEdit->repfirm->id)->where('equipment_id', '=', $repairEdit->equipment->id)->get()
        ];

        return view('pages.repairEdit')->with($data);
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
        if (isset($_POST)) {
            //dd($_POST['date_begin']);
            $id = $_POST['id'];

            $update = repair::find($id);
            $update->date_begin = $_POST['date_begin'];
            $update->customer = $_POST['customer'];
            $update->phone = $_POST['phone'];
            $update->equipment_id = $_POST['equipment_id'];
            $update->repfirm_id = $_POST['repfirm_id'];
            $update->repmodel = $_POST['repmodel'];
            $update->serial = $_POST['serial'];
            $update->package = $_POST['package'];
            $update->malfunction = $_POST['malfunction'];
            $update->prices = $_POST['prices'];
            $update->staff_id = $_POST['staff_id'];
            if ($request->input('status') >= 3) {
                $update->status = $request->input('status');
                $update->date_end = date('Y-m-d');
            } else {
                $update->status = $request->input('status');
                $update->date_end = "0000-00-00 00:00:00";
            }
            $update->save();
            return redirect()->route('repair')->with('status', 'Заявка с номером '.$id.' успешна обновлена');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del = repair::destroy($id);
        return redirect()->route('repair')->with('status', 'Заявка с номером '.$id.' успешна удалена');
    }

    //Сортировка
    public function order(Request $request, repair $repair)
    {
        if ($request->isMethod('get')) {
            $fields = $request->only('date_begin', 'date_end', 'equipment_id', 'repfirm_id', 'status');
            //dd($fields);
            $str = '';
            foreach ($fields as $key => $value) {
                if ($value != 0) {
                    switch ($key) {
                        case 'date_begin':
                            $strdate = strtotime($value);
                            $strdate = date('Y-m-d', $strdate);
                            $str = ('date_begin >= "' . $strdate . '" and ');
                            break;
                        case 'date_end':
                            $strdate = strtotime($value);
                            $strdate = date('Y-m-d', $strdate);
                            $str .= ('date_begin <= "' . $strdate . '" and ');
                            break;
                        default:
                            $str .= ($key . ' = ' . $value . ' and ');
                    }
                }
            }
            if (empty($str)) {
                $messages = $repair->getRepairAll();
                $count = $repair->getRepairCount("all", "", "");
            } else {
                $str = substr($str, 0, -5);
                $messages = $repair->repairOrder($str, $fields);
                //dd($fields);
                $count = $repair->CountrepairOrder($str);
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
                'status' => $request->get('status', 0),

            ];
            $data = [
                'pagetitle' => 'Сортировка',
                'title' => 'Ремонт',
                'oldOrderfields' => $oldOrderfields,
                //'messages' => repair::latest()->paginate(30), //Аналог::orderBy('created_at', 'desc')->get()
                'messages' => $messages,
                'equipment' => $ArrayEqu,
                'count' => $count
            ];

            return view('pages.repair')->with($data);
        }
    }

    //Ajax - обработка
    public function getAjax(Request $request)
    {
        if ($request->ajax()) {
            if ( (isset($_POST['equipment_id'])) && (!isset($_POST['repfirm_id'])) ) {
                $idEquipment=$_POST['equipment_id'];
                $nameFirm=$_POST['nameFirm'];
                $ListFirms = repfirm::where('equipment_id', '=', $idEquipment)->where('name', 'LIKE', '%'.$nameFirm.'%')->get()->toJson();
                echo ($ListFirms);
            }
        }
    }

    //Бастрое добавление фирм
    public function Fastaddajax(Request $request, repfirm $repfirm)
    {
        if ($request->ajax()) {
            if ((isset($_POST['QAddFirm_id'])) && (isset($_POST['QAddFirm']))) {
                $ValueSave = [
                    'name'=> $request->get('QAddFirm'),
                    'equipment_id'=> $request->get('QAddFirm_id')
                ];
                $repfirm->firstOrCreate($ValueSave);
                $oupt='<div class="alert alert-success">
<button data-dismiss="alert" class="close" type="button">×
</button>
<strong>Успешно!</strong> добавлена новая фирма '.$ValueSave["name"].'
</div>';
                return $oupt;
            }
        }
    }
}
