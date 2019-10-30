<?php

namespace App\Http\Controllers;

use App\Models\equipment;
use App\Models\repair;
use App\Models\repfirm;
use App\Models\spare;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Http\Requests;

class equipmentCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(repair $GetCount)
    {
        $allequipment = equipment::all();
        $messages = [];
        foreach ($allequipment as $item) {
            $messages[]= array('id' => $item->id,
                'name' => $item->name,
                'picture' => $item->picture,
                'countEnd' => $GetCount->getRepairCount("Done", "equipment_id", $item->id),
                'countBegin' => $GetCount->getRepairCount("not_done", "equipment_id", $item->id),
                'countNoOut' => $GetCount->getRepairCount("cast", "equipment_id", $item->id),
                'summ' => $GetCount->getRepairsumm("made", "equipment_id", $item->id)
            );
        }
        $count = equipment::count();

        return view('pages.equipment', ['messages' => $messages, 'count'=>$count, 'title'=> 'Ремонт',
            'pagetitle' => 'виды техники']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data= ['title'=> 'Ремонт',
            'pagetitle' => 'Добавление нового вида техники'];
        return view('pages.equipmentAdd')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(equipment $equipment, Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $rules= ['name' => 'required',
                'image' => 'required|max:35000|mimes:jpeg,bmp,png'];

            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                return redirect()->to('repair/equipment/add')->withInput()->withErrors($validator);
            }
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $file->move('images', $filename);
                $ValueSave = [
                    'name'=> $request->get('name'),
                    'picture'=> 'images/'.$file->getClientOriginalName()
                ];

                $equipment->firstOrCreate($ValueSave);
                return redirect()->route('repair.equipment')->with('status', 'Новый вид деятельности успешно создан');
            }

            dd('Что то уж совсем нето с файлом');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $UpEuipment = equipment::find($id);
        return view('pages.equipmentAdd', ['update'=>'Обновл', 'UpEuipment'=>$UpEuipment]);
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
            $idUpdate = $request->input('id');
            $fileUp = $request->file('image');
            $input = ['name' => $request->input('name'),
                'image' => $fileUp];
            $rules = ['name' => 'required',
                'image' => 'required|max:35000|mimes:jpeg,bmp,png'];
            if (isset($fileUp)) {
                $validator = Validator::make($input, $rules);
                if ($validator->fails()) {
                    return redirect()->route('repair.equipmentEdit', ['id' => $idUpdate])->withErrors($validator);
                }
                $equipmentUpdate = equipment::find($idUpdate);
                $equipmentUpdate->name = $request->input('name');
                $equipmentUpdate->picture = 'images/' . $fileUp->getClientOriginalName();
                $equipmentUpdate->save();
                return redirect()->route('repair.equipment')->with('status', 'Bид деятельности: ' . $input['name'] . ' успешно отредактирован');
            } else {
                $validator = Validator::make($input, ['name' => 'required']);
                if ($validator->fails()) {
                    return redirect()->route('repair.equipmentEdit', ['id' => $idUpdate])->withErrors($validator);
                }
                $equipmentUpdate = equipment::find($idUpdate);
                $equipmentUpdate->name = $request->input('name');
                $equipmentUpdate->save();
                return redirect()->route('repair.equipment')->with('status', 'Bид деятельности: ' . $input['name'] . ' успешно отредактирован');
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, spare $spare)
    {
        $countDelrepair = repair::where('equipment_id', '=', $id)->delete();
        $countDelrepfirm = repfirm::where('equipment_id', '=', $id)->delete();
        $countDelspare = $spare->DelSpareKeyl('equipment_id', $id);
        $equipmentDel = equipment::find($id);
        $equipmentDel->delete();
        return redirect()->route('repair.equipment')->with('status', 'Bид деятельности: '.$id.' успешно удален.
         Также удалено: '.$countDelrepair.' заявок, '.$countDelrepfirm.' фирм');
    }
}
