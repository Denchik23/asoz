<?php

namespace App\Http\Controllers;

use App\Models\cartridge;
use App\Models\repair;
use App\Models\spare;
use App\Models\staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class staffContr extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(repair $GetCount, staff $staff, cartridge $cartridge)
    {
        $allstaff = $staff->all();
        $StaffMasters = [];
        $Refueling = [];
        foreach ($allstaff as $item) {
            if ($item->position == 'Мастер') {
                $StaffMasters[] = array('id' => $item->id,
                    'name' => $item->name,
                    'discription' => $item->discription,
                    'position' => $item->position,
                    'avatar' => $item->avatar,
                    'holiday' => $item->holiday,
                    'countEnd' => $GetCount->getRepairCount("Done", "staff_id", $item->id),
                    'countBegin' => $GetCount->getRepairCount("not_done", "staff_id", $item->id),
                    'countNoOut' => $GetCount->getRepairCount("cast", "staff_id", $item->id),
                    'summ' => $GetCount->getRepairsumm("made", "staff_id", $item->id)
                );
            } else {
                $Refueling[] = array('id' => $item->id,
                    'name' => $item->name,
                    'discription' => $item->discription,
                    'position' => $item->position,
                    'avatar' => $item->avatar,
                    'holiday' => $item->holiday,
                    'Cartridgecount' => $cartridge->getCartridgeCount('all', 'staff_id', $item->id),
                    'CartridgecountD' => $cartridge->getCartridgeCount('lastDay', 'staff_id', $item->id),
                    'CartridgeSumm' => $cartridge->getCartridgeSumm('staff_id', $item->id)
                );
            }
        }
        $count = $staff->count();

        return view('staff.staff', ['messages' => $StaffMasters, 'Refueling'=> $Refueling, 'count'=>$count, 'title'=> 'Сотрудники',
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
            'pagetitle' => 'Добавление нового сотрудника',
            'positions' => $positionp=['Мастер', 'Заправщик'] ];
        return view('staff.staffAdd')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, staff $staff)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $rules = ['name' => 'required',
                'avatar' => 'required|max:35000|mimes:jpeg,bmp,png'];

            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                return redirect()->to('staff/add')->withInput()->withErrors($validator);
            }
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = $file->getClientOriginalName();
                $file->move('images', $filename);
                $ValueSave = [
                    'name' => $request->input('name'),
                    'discription' => $request->input('discription'),
                    'position' => $request->input('position'),
                    'avatar' => 'images/' . $file->getClientOriginalName(),
                    'holiday' => 1
                ];

                $staff->create($ValueSave);
                return redirect()->route('staff')->with('status', 'Новый сотрудник успешно создан');
            }

            dd('Что то уж совсем нето с файлом');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $staffEdit = staff::find($id);
        $data= ['title'=> 'Ремонт',
            'pagetitle' => 'редактирование сотрудника '.$staffEdit->name,
            'staffEdit' => $staffEdit,
            'positions' => $positionp=['Мастер', 'Заправщик'] ];
        return view('staff.staffEdit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, staff $staff)
    {
        if ($request->isMethod('post')) {
            $idUpdate = $request->input('id');
            $fileUp = $request->file('avatar');
            $input = ['name' => $request->input('name'),
                'discription' => $request->input('discription'),
                'position' => $request->input('position'),
                'avatar' => $fileUp
            ];
            $rules = ['name' => 'required',
                'avatar' => 'required|max:35000|mimes:jpeg,bmp,png'
            ];
            if (isset($fileUp)) {
                $validator = Validator::make($input, $rules);
                if ($validator->fails()) {
                    return redirect()->route('staff.Edit', ['id' => $idUpdate])->withErrors($validator);
                }
                if ($request->hasFile('avatar')) {
                    $file = $request->file('avatar');
                    $filename = $file->getClientOriginalName();
                    $file->move('images', $filename);
                    $staffUpdate = $staff->find($idUpdate);
                    $staffUpdate->name = $input['name'];
                    $staffUpdate->discription = $input['discription'];
                    $staffUpdate->position = $input['position'];
                    $staffUpdate->avatar = 'images/' . $filename;
                    $staffUpdate->save();
                    return redirect()->route('staff')->with('status', 'Сотрудник: ' . $input['name'] . ' успешно отредактирован');
                }

            } else {
                $validator = Validator::make($input, ['name' => 'required']);
                if ($validator->fails()) {
                    return redirect()->route('staff.Edit', ['id' => $idUpdate])->withErrors($validator);
                }
                $staffUpdate = $staff->find($idUpdate);
                $staffUpdate->name = $input['name'];
                $staffUpdate->discription = $input['discription'];
                $staffUpdate->position = $input['position'];
                $staffUpdate->save();
                return redirect()->route('staff')->with('status', 'Сотрудник: ' . $input['name'] . ' успешно отредактирован');
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
        $del = staff::destroy($id);
        return redirect()->route('staff')->with('status', 'Сотрудник '.$id.' успешно удален');
    }
    // Отправка в отпуск
    public function holiday($id, staff $staff)
    {
        $holidayStaff = $staff->find($id);
        if ($holidayStaff->holiday == 0)
            $holidayStaff->holiday = 1; else $holidayStaff->holiday = 0;
        $holidayStaff->save();
        return redirect()->route('staff')->with('status', 'Сотрудник '.$id.' отпуск');
    }
}
