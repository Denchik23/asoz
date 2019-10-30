<?php

namespace App\Http\Controllers;

use App\Models\cartridge;
use App\Models\repair;
use App\Models\repfirm;
use App\Models\spare;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class mainContr extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(repair $GetCount, spare $spare, cartridge $cartridge)
    {
        $data = ['title' => 'АС обработки заявок',
            'pagetitle' => 'Главная',
            //ремонт
            'count' => $GetCount->getRepairCount("all", "", ""),
            'countEnd' => $GetCount->getRepairCount("Done", "", 0),
            'countBegin' => $GetCount->getRepairCount("not_done", "", 0),
            'countNoOut' => $GetCount->getRepairCount("cast", "", 0),
            'summ' => $GetCount->getRepairsumm("made", "", 0),
            //'summ' => 123,
            //Заправка картриджей
            'Cartridgecount' => $cartridge->getCartridgeCount('all'),
            'CartridgecountM' => $cartridge->getCartridgeCount('lastDay'),
            'CartridgeSumm' => $cartridge->getCartridgeSumm(),
            //Запросы на запчатси
            'SparecountEnd' => $spare->getSpareCount(2),
            'SparecountBegin' => $spare->getSpareCount(3),
            'Sparecount' => $spare->getSpareCount()
        ];
        return view('pages.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function calculator(repfirm $repfirm)
    {
        $data = [
            'title'=> 'Калькулятор',
            'pagetitle' => 'Расчет стоимости заправки',
            'firm' => $repfirm->getrepfirmNoKey(),
        ];
        //dd($data);
        return view('сalculator')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, repair $repair, cartridge $cartridge, spare $spare)
    {
        if ($request->isMethod('post')) {
            $id = $request->get('searchId');
            if (is_numeric($id)) {
                $count = 0;
                $searchRepair = $repair->find($id);
                $searchCart = $cartridge->find($id);
                $searchSpare = $spare->find($id);
                if (isset($searchRepair)) $count++;
                if (isset($searchCart)) $count++;
                if (isset($searchSpare)) $count++;
                $data = [
                    'pagetitle' => 'Все найденные заявки',
                    'title' => 'Поиск по № заявки',
                    'searchRepair' => $searchRepair,
                    'searchCart' => $searchCart,
                    'searchSpare' => $searchSpare,
                    'count' => $count
                ];
                return view('search')->with($data);

            } else {
                dd('Переменная searchId должна быть числом');
            }
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function SpareDestroyAll(spare $spare)
    {
        $countDellSpare = $spare->SpareDestroyAll('2');
        return redirect()->route('main')->with('status', 'Удалено '.$countDellSpare.' запросов');
    }
}
