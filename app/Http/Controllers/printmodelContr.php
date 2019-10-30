<?php

namespace App\Http\Controllers;

use App\Models\cartridge;
use App\Models\repfirm;
use App\Models\repmodel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class printmodelContr extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(repfirm $repfirm, repmodel $repmodel)
    {

        $data = ['title'=> 'Картриджи',
            'pagetitle' => 'Модели Картриджей',
            'repfirm' => $repfirm->getrepfirmNoKey(),
            'repfirm_id' => '',
            'count' => $repfirm->getrepfirCount(4),
            'messages' => $repmodel->getrepmodel()
        ];
        return view('cartridge.models')->with($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, repmodel $repmodel)
    {
        if ($request->isMethod('post')) {
            $input = [
                'name' => $request->get('name'),
                'repfirm_id' => $request->get('repfirm_id'),
                'cartridgeprices' => $request->get('cartridgeprices'),
                'refueling' => $request->get('refueling'),
                'drum' => $request->get('drum'),
                'raquel' => $request->get('raquel'),
                'rollercharge' => $request->get('rollercharge'),
                'magroller' => $request->get('magroller'),
                'blade' => $request->get('blade'),
                'chip' => $request->get('chip'),
                'resourceprint' => $request->get('resourceprint'),
                'toner' => $request->get('toner')
            ];
            $rules = ['name' => 'required',
                'repfirm_id' => 'required|integer|min:1',
                'cartridgeprices' => 'required|integer|min:1',
                'refueling' => 'required|integer|min:1',
                'drum' => 'required|integer|min:1',
                'raquel' => 'required|integer|min:1',
                'rollercharge' => 'required|integer|min:1',
                'magroller' => 'required|integer|min:1',
                'blade' => 'required|integer|min:1',
                'chip' => 'required|integer|min:1',
                'resourceprint' => 'required|integer|min:1',
                'toner' => 'required|integer|min:1'
            ];
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                return redirect()->to('cartridge/models')->withInput()->withErrors($validator);
            }
            //dd($input);
            $repmodel->firstOrCreate($input);
            return redirect()->route('cartridge.models')->with('status', 'Новая модель ' . $input["name"] . ' добавлена');
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
        $printModelKey = repmodel::find($id);
        $data = ['title'=> 'Картриджи',
            'pagetitle' => 'Редактирование модели картриджа',
            'repfirm' => $repfirm->getrepfirmNoKey($printModelKey->repfirm->id),
            'messages' => $printModelKey
        ];

        return view('cartridge.modelsEdit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, repmodel $repmodel)
    {
        if ($request->isMethod('post')) {
            $idUpdateModel = $request->get('id');
            $input = $request->all();
            $rules= ['name' => 'required',
                'repfirm_id' => 'required|integer|min:1',
                'cartridgeprices' => 'required|integer|min:1',
                'refueling' => 'required|integer|min:1',
                'drum' => 'required|integer|min:1',
                'raquel' => 'required|integer|min:1',
                'rollercharge' => 'required|integer|min:1',
                'magroller' => 'required|integer|min:1',
                'blade' => 'required|integer|min:1',
                'chip' => 'required|integer|min:1',
                'resourceprint' => 'required|integer|min:1',
                'toner' => 'required|integer|min:1'
            ];
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                return redirect()->route('cartridge.modelsEdit', ['id'=>$idUpdateModel])->withErrors($validator);
            }
            $UpdateModel = $repmodel->find($idUpdateModel);
            $UpdateModel->name = $input["name"];
            $UpdateModel->repfirm_id = $input["repfirm_id"];
            $UpdateModel->cartridgeprices = $input["cartridgeprices"];
            $UpdateModel->refueling = $input["refueling"];
            $UpdateModel->drum = $input["drum"];
            $UpdateModel->raquel = $input["raquel"];
            $UpdateModel->rollercharge = $input["rollercharge"];
            $UpdateModel->magroller = $input["magroller"];
            $UpdateModel->blade = $input["blade"];
            $UpdateModel->chip = $input["chip"];
            $UpdateModel->resourceprint = $input["resourceprint"];
            $UpdateModel->toner = $input["toner"];
            $UpdateModel->save();
            return redirect()->route('cartridge.models')->with('status', 'Модель '.$input["name"].' отредактированна');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, repmodel $repmodel, cartridge $cartridge, Request $request)
    {
        if ($request->isMethod('get')) {
            $countDelcartridge = $cartridge->DelcartridgeFromModel($id);
            $repmodel->DelrepmodelKey($id);
            return redirect()->route('cartridge.models')->with('status', 'Модель: '.$id.' успешно удалена. Также удалено: '.$countDelcartridge.' заявок');
        }
    }
    //сортировка
    public function order(Request $request, repfirm $repfirm, repmodel $repmodel)
    {
        if ($request->isMethod('get')) {
            $repfirm_id = $request->get('repfirm_id');
            if ($repfirm_id == 0) {
                return redirect()->route('cartridge.models');
            }
            $data = ['title' => 'Картриджи',
                'pagetitle' => 'Фирмы картриджей',
                'repfirm_id' => $repfirm_id,
                'repfirm' => $repfirm->getrepfirmOrder2(4),
                'count' => $repmodel->getrepmodelCount($repfirm_id),
                'messages' => $repmodel->getrepmodelOrd($repfirm_id)
            ];

            return view('cartridge.models')->with($data);
        }
    }
}
