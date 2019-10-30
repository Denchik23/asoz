<?php

namespace App\Http\Controllers;

use App\Models\cartridge;
use App\Models\repfirm;
use App\Models\repmodel;
use App\Models\staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class cartridgeContr extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(cartridge $cartridge, repfirm $repfirm, Request $request)
    {
        $firm = $repfirm->getrepfirmOrder2(4);
        $ArrayFirm[0] = 'Все фирмы';
        foreach ($firm as $item) {
            $ArrayFirm[$item->id] = $item->name;
        }
        $oldOrderfields = [
            'date_begin' => $request->get('date_begin', ''),
            'repfirm_id' => $request->get('repfirm_id', 0),
            'printmodels_id' => $request->get('printmodels_id', 0),
            'ACModel' => $request->get('ACModel', 'Все модели'),
        ];
        $data = [
            'pagetitle' => 'Все заявки',
            'title'=> 'Картриджи',
            'oldOrderfields' => $oldOrderfields,
            'messages' => $cartridge->getCartridgeAll(),
            'firm' => $ArrayFirm,
            'count' => $cartridge->getCartridgeCount('all')
        ];

        return view('cartridge.cartridge')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(repfirm $repfirm, staff $staff)
    {
        $Staf = $staff->getPrintMasters();
        $holidayStaff = [];
        foreach ($Staf as $item) {
            $holidayStaff[$item->id] = $item->name;
        }
        $data = [
            'title'=> 'Картриджи',
            'pagetitle' => 'Создание новой заявки',
            'firm' => $repfirm->getrepfirmNoKey(),
            'holidayStaff' => $holidayStaff
        ];
        return view('cartridge.cartridgeCreate')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, cartridge $cartridge)
    {
        if ($request->isMethod('post')) {
            //validation

            $validator = validator::make(
                array('prices' => $request->input("prices")),
                array('prices' => 'required')
            );
            if ($validator->fails()) {
                return redirect()->to('cartridge/create')->withInput()->withErrors($validator);
            }
            if ($request->input('printmodels_id') == 0) {
                return redirect()->route('cartridge.create')->with('Errors', 'Такой модели картриджа не существует');
            }
            $work='';
            $i=1;
            if ($request->has('C-refueling')) {
                $work .= ($i++.'. '.$request->input("C-refueling").' : '.$request->input("refueling").'<br>');
            }
            if ($request->has('C-drum')) {
                $work .= ($i++.'. '.$request->input("C-drum").' : '.$request->input("drum").'<br>');
            }
            if ($request->has('C-raquel')) {
                $work .= ($i++.'. '.$request->input("C-raquel").' : '.$request->input("raquel").'<br>');
            }
            if ($request->has('C-rollercharge')) {
                $work .= ($i++.'. '.$request->input("C-rollercharge").' : '.$request->input("rollercharge").'<br>');
            }
            if ($request->has('C-magroller')) {
                $work .= ($i++.'. '.$request->input("C-magroller").' : '.$request->input("magroller").'<br>');
            }
            if ($request->has('C-blade')) {
                $work .= ($i++.'. '.$request->input("C-blade").' : '.$request->input("blade").'<br>');
            }
            if ($request->has('C-chip')) {
                $work .= ($i++.'. '.$request->input("C-chip").' : '.$request->input("chip").'<br>');
            }
            $ValueSave = [
                'date_begin' => $request->input('date_begin'),
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'repfirm_id' => $request->input('repfirm_id'),
                'printmodels_id' => $request->input('printmodels_id'),
                'datacartridge' => $work,
                'staff_id' => $request->input('staff_id'),
                'number' => $request->input('number'),
                'prices' => $request->input('prices')
            ];
            $cartridge->create($ValueSave);
            return redirect()->route('cartridge')->with('status', 'Заявка успешно создана');
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
        $cartridge = cartridge::find($id);
        $data = ['title'=> 'Картриджи',
            'pagetitle' => 'Просмотр заявки',
            'repair' => $cartridge];
        return view('cartridge.cartridgeShow')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //печать
    public function printed($id)
    {
        $cartridge = cartridge::find($id);
        //dd($id);
        $data = ['title'=> 'Картриджи',
            'cartridge' => $cartridge];
        return view('print.cartridgePrinted')->with($data);
    }


    public function edit($id, staff $staff, repfirm $repfirm)
    {
        $cartridge = cartridge::find($id);

        $strdate = $cartridge->date_begin;
        $strdate=strtotime($strdate);
        $strdate = date('Y-m-d', $strdate);

        $Staf = $staff->getPrintMasters();
        $holidayStaff = [];
        foreach ($Staf as $item) {
            $holidayStaff[$item->id] = $item->name;
        }

        //$datacartridge = $cartridge->datacartridge;
        //$strWork = str_replace('<br>', '<br />', $datacartridge);
        //dd($strWork);

        $data = [
            'title'=> 'Картриджи',
            'pagetitle' => 'Редактирование заявки',
            'firm' => $repfirm->getrepfirmNoKey($cartridge->repfirm->id),
            'holidayStaff' => $holidayStaff,
            'strdate' => $strdate,
            'datacartridge' => $cartridge->datacartridge,
            'cartridge' => $cartridge
        ];
        return view('cartridge.cartridgeEdit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cartridge $cartridge)
    {
        if ($request->isMethod('post')) {
            $idUpCartridge = $request->get('id');

            $validator = validator::make(
                array(
                    'printmodels_id '=> $request->input("printmodels_id")
                ),
                array(
                    'printmodels_id' => 'integer|min:1'
                )
            );
            if ($validator->fails()) {
                return redirect()->route('cartridge.edit', ['id'=>$idUpCartridge])->withErrors($validator);
            }

            $cartridgeUp = $cartridge->find($idUpCartridge);
            $cartridgeUp->date_begin = $request->input('date_begin');
            $cartridgeUp->name = $request->input('name');
            $cartridgeUp->phone = $request->input('phone');
            $cartridgeUp->repfirm_id = $request->input('repfirm_id');
            $cartridgeUp->printmodels_id = $request->input('printmodels_id');
            $cartridgeUp->staff_id = $request->input('staff_id');


            if ($request->has('datacartridge'))
            {
                $cartridgeUp->datacartridge = $request->input('datacartridge');
            } else {
                $work='';
                $i=1;
                if ($request->has('C-refueling')) {
                    $work .= ($i++.'. '.$request->input("C-refueling").' : '.$request->input("refueling").'<br>');
                }
                if ($request->has('C-drum')) {
                    $work .= ($i++.'. '.$request->input("C-drum").' : '.$request->input("drum").'<br>');
                }
                if ($request->has('C-raquel')) {
                    $work .= ($i++.'. '.$request->input("C-raquel").' : '.$request->input("raquel").'<br>');
                }
                if ($request->has('C-rollercharge')) {
                    $work .= ($i++.'. '.$request->input("C-rollercharge").' : '.$request->input("rollercharge").'<br>');
                }
                if ($request->has('C-magroller')) {
                    $work .= ($i++.'. '.$request->input("C-magroller").' : '.$request->input("magroller").'<br>');
                }
                if ($request->has('C-blade')) {
                    $work .= ($i++.'. '.$request->input("C-blade").' : '.$request->input("blade").'<br>');
                }
                if ($request->has('C-chip')) {
                    $work .= ($i++.'. '.$request->input("C-chip").' : '.$request->input("chip").'<br>');
                }
                $cartridgeUp->datacartridge = $work;
                $cartridgeUp->number = $request->input('number');
                $cartridgeUp->prices = $request->input('prices');
            }
            $cartridgeUp->save();
            return redirect()->route('cartridge')->with('status', 'Заявка успешно обновлена');

        }
    }

    //Сортировка
    public function order(Request $request, cartridge $cartridge, repfirm $repfirm)
    {
        if ($request->isMethod('get')) {
            $fields = $request->only('date_begin', 'repfirm_id', 'printmodels_id');
            $str = '';
            foreach ($fields as $key => $value) {
                if ($value != 0) {
                    if ($key == 'date_begin') {
                        $strdate = strtotime($value);
                        $strdate = date('Y-m-d', $strdate);
                        $str = ('date_begin >= "'.$strdate.'" and ');
                    } else {
                        $str .= ($key.' = '.$value.' and ');
                    }
                }
            }

            if (empty($str)) {
                $messages = $cartridge->getCartridgeAll();
                $count = $cartridge->getCartridgeCount('all');
            } else {
                $str = substr($str, 0, -5);
                $messages = $cartridge->cartridgeOrder($str, $fields);
                $count = $cartridge->CountcartridgeOrder($str);
            }

            $firm = $repfirm->getrepfirmOrder2(4);
            $ArrayFirm[0] = 'Все фирмы';
            foreach ($firm as $item) {
                $ArrayFirm[$item->id] = $item->name;
            }
            $oldOrderfields = [
                'date_begin' => $request->get('date_begin', ''),
                'repfirm_id' => $request->get('repfirm_id', 0),
                'printmodels_id' => $request->get('printmodels_id', 0),
                'ACModel' => $request->get('ACModel', 'Все модели'),
            ];
            $data = [
                'pagetitle' => 'Сортировака',
                'title'=> 'Картриджи',
                'oldOrderfields' => $oldOrderfields,
                'messages' => $messages,
                'firm' => $ArrayFirm,
                'count' => $count
            ];
            return view('cartridge.cartridge')->with($data);
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
        $del = cartridge::destroy($id);
        return redirect()->route('cartridge')->with('status', 'Заявка с номером '.$id.' успешна удалена');
    }

    //Ajax - обработка
    public function getajax(Request $request, repmodel $repmodel)
    {
        if ($request->ajax()) {
            if ( (isset($_POST['repfirm_id'])) ) {
                $idFirm=$_POST['repfirm_id'];
                $nameModel=$_POST['nameFirm'];
                $ListModels = $repmodel->getOrderAjax($idFirm, $nameModel);
                echo ($ListModels);
            }
        }
    }
    public function Modelajax(Request $request, repmodel $repmodel)
    {
        if ($request->ajax()) {
            if ( (isset($_POST['id'])) ) {
                $id = $_POST['id'];
                $data = [
                    'datacartridge' => $repmodel->find($id),
                ];
                return view('cartridge._formWork')->with($data);
            }
        }
    }
}
