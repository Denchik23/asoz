<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\repair;
use App\Models\archive;
use Excel;

class ArchiveContr extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(archive $archive, Request $request)
    {
        $oldOrderfields = [
            'date_begin' => $request->get('date_begin', ''),
            'date_end' => $request->get('date_end', ''),
            'ArchiveSearchId' => $request->get('ArchiveSearchId', '')
        ];
        $data = [
            'pagetitle' => 'Весь архив',
            'title' => 'Архив',
            'oldOrderfields' => $oldOrderfields,
            'count' => $archive->count(),
            'messages' => $archive->getArchiveaAll()
        ];
        //dd($data);
        $this->DelSession($request, 'date_begin');
        $this->DelSession($request, 'date_end');
        $this->DelSession($request, 'ArchiveSearchId');

        return view('archive.archive')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(repair $repair)
    {

        $data = [
            'title'=> 'Архив',
            'pagetitle' => 'Добавление заявок в архив',
            'count' => $repair->getArchiveCount(),
            'messages' => $repair->repairArchive()
        ];
        return view('archive.addArchive')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     * перенос заявок в архив и удалении их же из таблици repairs
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, repair $repair, archive $archive)
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $arrayid = array();
            for ($i = 0; $i<=49; $i++) { //i должна быть равна погинациив  в функции repairArchive
                if (isset($input['addArchiveId'.$i.''])) {
                    if (is_numeric($input['addArchiveId'.$i.''])) {
                        $arrayid[] = $input['addArchiveId'.$i.''];
                    }
                }
            }
            if (!empty($arrayid)) {
                $repairAr = $repair->getArchiveArray($arrayid);
                if ($repairAr->count() === count($arrayid)) { // проверка второго уровня
                    $arrayfileds = array();
                    $errorsA = array('logs' => '', 'errorsF' => true);
                    $countAddCur = 0;
                    foreach ($repairAr as $item) {
                        $arrayfileds['id_repair'] = $item->id;
                        $arrayfileds['date_begin'] = $this->dateConver($item->date_begin);
                        $arrayfileds['date_end'] = $this->dateConver($item->date_end);
                        $arrayfileds['customer'] = $item->customer;
                        $arrayfileds['phone'] = $item->phone;
                        $arrayfileds['equipment'] = $item->equipment->name;
                        $arrayfileds['repfirm'] = $item->repfirm->name;
                        $arrayfileds['repmodel'] = $item->repmodel;
                        $arrayfileds['serial'] = $item->serial;
                        $arrayfileds['package'] = $item->package;
                        $arrayfileds['malfunction'] = $item->malfunction;
                        $arrayfileds['prices'] = $item->prices;
                        $arrayfileds['staff'] = $item->staff->name;
                        if (!$archive->create($arrayfileds)) {
                            $errorsA['logs'] = '<li>Запись с № ' . $item->id . ' не добавлена</li>';
                            $errorsA['errorsF'] = false;
                        } else {
                            $errorsA['logs'] .= '<li>Запись с № ' . $item->id . ' успешно добавлена в архив</li>';
                            $delArc = $repair->find($item->id);
                            if ($delArc->delete()) {
                                $errorsA['logs'] .= '<li>Запись с № ' . $item->id . ' успешно удалена из базы</li>';
                            }
                        }
                        $countAddCur++;
                    }
                } else $errorsA['errorsF'] = false;

                if ($errorsA['errorsF'] != false) {
                    $errorsA['message'] = 'Все отмеченные '.$repairAr->count().' заявок перенесены успешно';
                } else {
                    $errorsA['message'] = 'Ошибка смотрите в логах';
                }
            } else {
                $errorsA['errorsF'] = false;
                $errorsA['message'] = 'Отметьте хотябы одну заявку!';
            }
            return redirect()->route('archive.create')->with($errorsA);
        }
    }

    //Сортировка
    public function order(Request $request, archive $archive)
    {
        if ($request->isMethod('get')) {
            $fields = $request->only('date_begin', 'date_end');
            //dd($fields);
            $str = '';
            foreach ($fields as $key => $value) {
                if ($value != 0) {
                    switch ($key) {
                        case 'date_begin':
                            $strdate = $this->dateConver($value);
                            $str = ('date_begin >= "' . $strdate . '" and ');
                            $request->session()->put($key, $strdate);
                            break;
                        case 'date_end':
                            $strdate = $this->dateConver($value);
                            $str .= ('date_begin <= "' . $strdate . '" and ');
                            $request->session()->put($key, $strdate);
                            break;
                    }
                } else {
                    if ($request->session()->has($key)) $request->session()->forget($key);
                }
            }
            if (empty($str)) {
                $messages = $archive->getArchiveaAll();
                $count = $archive->count();
            } else {
                $str = substr($str, 0, -5);
                $messages = $archive->ArchiveaOrder($str, $fields);
                //dd($messages->total());
                $count = $messages->total();
                $this->DelSession($request, 'ArchiveSearchId');
            }

            $oldOrderfields = [
                'date_begin' => $request->get('date_begin', ''),
                'date_end' => $request->get('date_end', ''),
                'ArchiveSearchId' => $request->get('ArchiveSearchId', '')
            ];
            $data = [
                'pagetitle' => 'Сортировка',
                'title' => 'Архив',
                'oldOrderfields' => $oldOrderfields,
                //'messages' => repair::latest()->paginate(30), //Аналог::orderBy('created_at', 'desc')->get()
                'messages' => $messages,
                'count' => $count
            ];

            return view('archive.archive')->with($data);
        }
    }

    /**
     * поиск по номеру заявки
     * Потом проверить на SQL инекции
     */
    public function faind(Request $request, archive $archive) {
        if ($request->isMethod('get')) {
            $ArchiveSearchId = $request->get('ArchiveSearchId');
            $oldOrderfields = [
                'date_begin' => $request->get('date_begin', ''),
                'date_end' => $request->get('date_end', ''),
                'ArchiveSearchId' => $request->get('ArchiveSearchId', '')
            ];
            if ($ArchiveSearchId != '') {
                if ($message = $archive->getArchiveaId_repair($ArchiveSearchId)) $count = $message->count();
                else $count = 0;
                $request->session()->put('ArchiveSearchId', $ArchiveSearchId);
                $data = [
                    'pagetitle' => 'Весь архив',
                    'title' => 'Архив',
                    'oldOrderfields' => $oldOrderfields,
                    'count' => $count,
                    'messages' => $message
                ];
                //dd($data);
                return view('archive.archive')->with($data);
            } else dd('Вы не указали номер заявки для поиска');
        }
    }


    /**
     * Печать архивной заявки
     * @param $id
     * @param archive $archive
     */
    public function printed(archive $archive, $id)
    {
        $repair = $archive->getArchiveaId($id);
        $repair->equipment = (object) array('name' => $repair->equipment);
        $repair->repfirm = (object) array('name' => $repair->repfirm);
        //dd($repair->equipment->name);
        $data = ['title'=> 'Ремонт',
            'repair' => $repair];
        return view('print.repairPrinted')->with($data);
    }

    /**
     * Экспотр в Excel
     */
    public function exportExcel(Request $request, archive $archive)
    {

        $StrSql = $this->getSessionCheck($request);
        if ($StrSql) $Export = $archive->ArchiveaOrderExport($StrSql);
        else $Export = $archive->getArchiveaAllExport();

        $ExportData = array();
        foreach ($Export as $key => $value) {
            $ExportData[] = [
                '№' => $value->id_repair,
                'Дата начала' => $value->date_begin,
                'Дата окончания' => $value->date_begin,
                'Дата архивирования' => $value->created_at,
                'Имя' => $value->customer,
                'Телефон' => $value->phone,
                'Вид техники' => $value->equipment,
                'Фирма' => $value->repfirm,
                'Модель' => $value->repmodel,
                'Серийный номер' => $value->serial,
                'Комплектность' => $value->package,
                'Неисправность' => $value->malfunction,
                'Цена' => $value->prices,
                'Исполнитель' => $value->staff
            ];
        }
        if (!empty($ExportData)) {

            Excel::create('Архив ' . date("d-m-Y") . '', function ($excel) use ($ExportData) {
                // Set the title
                $excel->setTitle('Our new awesome title');
                // Chain the setters
                $excel->setCreator('Maatwebsite')
                    ->setCompany('Maatwebsite');
                // Call them separately
                $excel->setDescription('A demonstration to change the file properties');

                // первый лист
                $excel->sheet('Архив', function ($sheet) use ($ExportData) {

                    $sheet->fromArray($ExportData);

                });
            })->download('xls');
        } else dd('Экспорт неудался обратитесь к разработчику');

    }


    public function exportXml() {
        $base = '<?xml version="1.0" encoding="UTF-8"?>
            <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
            </urlset>';
        $tatlocal = 'запись по крону - '.date("d-m-Y H:i:s");
        //$xmlbase = new \SimpleXMLElement($base);
        dd($tatlocal);
    }

    /**
     * Конвертирование даты
     * @param $data
     */
    public function dateConver($data)
    {
        $strdate = strtotime($data);
        $strdate = date('Y-m-d', $strdate);
        return $strdate;
    }

    /**
     * Экспорт учитывает данные из сессии, функция обрабатывает эти данные
     * @param $request - обьект для рабоы с сесиями
     */
    public function getSessionCheck($request) {
        $sql = '';
        if ($request->session()->has('ArchiveSearchId'))  {
            $sql = ('id_repair = '.$request->session()->get('ArchiveSearchId'));
        } else {
            if ($request->session()->has('date_begin'))
                $sql = ('date_begin >= "' . $request->session()->get('date_begin') . '" and ');
            if ($request->session()->has('date_end'))
                $sql.= ('date_begin <= "' . $request->session()->get('date_end') . '" and ');
            if (!empty($sql)) $sql = substr($sql, 0, -5);
        }
        if (empty($sql)) return false; else return $sql;
    }


    /**
     * Удаляем сесси для адекватной сортировки
     * @param $request - обьект для работы с сисиями
     * @param $dataSession - имя сессии
     */
    public function DelSession($request, $dataSession) {
        if ($request->session()->has($dataSession))  {
            $request->session()->forget($dataSession);
            return true;
        } else return false;
    }


    //Ajax - обработка
    public function ShowArchiveAjax(Request $request, archive $archive)
    {
        if ($request->ajax()) {
            if ( (isset($_POST['idArchiveShow'])) ) {
                $idEquipment = $_POST['idArchiveShow'];
                if ($showRecArc = $archive->getArchiveaId($idEquipment)) {
                    $data = [
                        'messages' => $showRecArc,
                    ];
                    return view('archive._showArchive')->with($data);
                }
            }
        }
    }

}
