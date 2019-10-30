<?php

namespace App\Http\Controllers;

use App\Models\cartridge;
use App\Models\equipment;
use App\Models\repair;
use App\Models\repfirm;
use App\Models\repmodel;
use App\Models\spare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;

class repfirmContr extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(repfirm $repfirm)
    {
        $equipment = equipment::all();
        $ArrayEqu[0] = 'Вся техника';
        foreach ($equipment as $item) {
            $ArrayEqu[$item->id] = $item->name;
        }
        $data = ['title'=> 'Ремонт',
            'pagetitle' => 'Фирмы техники',
            'equipment_id' => 0,
            'count' => $repfirm->count(),
            'messages' => $repfirm->getrepfirmOrder(''),
            'equipmentAll' =>  $ArrayEqu
        ];
        //dd($data);
        return view('pages.repfirm')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, repfirm $repfirm)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $rules = ['name' => 'required',
                'equipment_id' => 'required|integer|min:1'];
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                return redirect()->to('repair/repfirm')->withInput()->withErrors($validator);
            }
            $ValueSave = [
                'name' => $request->get('name'),
                'equipment_id' => $request->get('equipment_id')
            ];
            $repfirm->firstOrCreate($ValueSave);
            return redirect()->route('repair.repfirm')->with('status', 'Новая фирма ' . $ValueSave["name"] . ' добавлена');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id, repfirm $repfirm)
    {
        $repfirmKey = $repfirm->find($id);
        $data = ['title'=> 'Ремонт',
            'pagetitle' => 'Фирмы техники',
            'messages' => $repfirmKey,
            'equipmentAll' =>  equipment::where('id', '!=', $repfirmKey->equipment->id)->get()
        ];
        return view('pages.repfirmEdit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, repfirm $repfirm)
    {
        if ($request->isMethod('post')) {
            $idUpdateFirm = $request->get('id');
            $input = $request->all();
            $rules = ['name' => 'required',
                'equipment_id' => 'required|integer|min:1'];
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                return redirect()->route('repair.repfirmEdit', ['id' => $idUpdateFirm])->withErrors($validator);
            }
            $ValueSave = [
                'name' => $request->get('name'),
                'equipment_id' => $request->get('equipment_id')
            ];
            //dd($ValueSave["name"]);
            $UpdateFirm = $repfirm->find($idUpdateFirm);
            $UpdateFirm->name = $ValueSave["name"];
            $UpdateFirm->equipment_id = $ValueSave["equipment_id"];
            $UpdateFirm->save();
            return redirect()->route('repair.repfirm')->with('status', 'Фирма ' . $ValueSave["name"] . ' отредактирована');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, repfirm $repfirm, repair $repair, cartridge $cartridge, repmodel $repmodel, spare $spare)
    {
        $countDelrepair = $repair->DelRepairFromFirm($id);
        $countpSpare = $spare->DelSpareKeyl('repfirm_id', $id);
        $repfirm->DelrepfirmKey($id);
        if ($countDelrepair == 0) {
            $countDelcartridge = $cartridge->DelcartridgeFromFirm($id);
            $countpPintModels = $repmodel->DelmodelsFromFirm($id);
            return redirect()->route('repair.repfirm')->with('status', 'Фирма: '.$id.' успешно удалена. Также удалено: '.$countpPintModels.' моделей и '
                .$countDelcartridge.' заявок');
        } else {
            return redirect()->route('repair.repfirm')->with('status', 'Фирма: '.$id.' успешно удалена. Также удалено: '.$countDelrepair.' заявок');
        }

    }

    public function order(Request $request, repfirm $repfirm)
    {
        if ($request->isMethod('get')) {
            $equipment_id = $request->input('equipment_id' , 0);
            if ($equipment_id == 0) {
                return redirect()->route('repair.repfirm');
            }
            $equipment = equipment::all();
            $ArrayEqu[0] = 'Вся техника';
            foreach ($equipment as $item) {
                $ArrayEqu[$item->id] = $item->name;
            }
            //$oldOrderfield = ;
            $data = ['title' => 'Ремонт',
                'pagetitle' => 'Фирмы техники',
                'equipment_id' => $equipment_id,
                'count' => $repfirm->getrepfirCount($equipment_id),
                'messages' => $repfirm->getrepfirmOrder($equipment_id),
                'equipmentAll' => $ArrayEqu
            ];
            return view('pages.repfirm')->with($data);
        }
    }

}
