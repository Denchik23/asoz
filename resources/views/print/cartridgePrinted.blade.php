@extends('MainPrint')
@section('head')

@stop
@section('content')
    <table class="printRepair">
        <rt>
            <td width="15%"><img src="images/logoSobaka2.jpg" alt=""></td>
            <td>
                <h4 class="page-header">Сервисный центр "@-Service"</h4>
                <p>Адрес:  Анапа, ул. Астраханская, 69 “А” оф. 11, (2 этаж), Тел.: +7 918-489-80-87 E-mail: Anapa-sobaka@yandex.ru, сайт: sobaka-service.ru</p>
            </td>
        </rt>
    </table>
    <h4 style="text-align: center;">Квитанция о приеме №{!!$cartridge->id!!} от {!!date("d.m.y")!!}</h4>
    <table class="table table-bordered">
        <tbody>
        <tr>
            <td width="25%">Ф.И.О. Клиента</td>
            <td>{!!$cartridge->name!!}</td>
        </tr>
        <tr>
            <td>Телефон</td>
            <td>{!!$cartridge->phone!!}</td>
        </tr>
        <tr>
            <td>Картридж</td>
            <td>{!!$cartridge->repfirm->name!!} - {!!$cartridge->printmodels->name!!}</td>
        </tr>
        <tr>
            <td>Дата приема</td>
            <td>{!!$cartridge->date_begin!!}</td>
        </tr>
        <tr>
            <td>Количество картриджей</td>
            <td>{!!$cartridge->number!!}</td>
        </tr>
        <tr>
            <td>Выполнение работы</td>
            <td>{!!$cartridge->datacartridge!!}</td>
        </tr>
        <tr>
            <td>Стоимость работ</td>
            <td>{!!$cartridge->prices!!}</td>
        </tr>
        <tr style="height: 50px;">
            <td>Примечания:</td>
            <td></td>
        </tr>
        </tbody>
    </table>
    <h4 class="TermsHead">Условия оказания услуг</h4>
    <ul class="TermsRepair">
        <li>Печатающая техника снимается с гарантийного срока при использовании заправленных картриджей.</li>
        <li>Не гарантируется количество отпечатанных страниц, так как тонер может высыпаться, при изношенных деталях часть тонера скапливается в бункере с отработкой.</li>
        <li>Мы не несем ответственность за неисправности возникшие из за заправленного картриджа. Рекомендуем использовать новые картриджи. Вы понимаете риск использования заправленных картриджей и используете услугу по заправке на свой страх и риск.</li>
        <li>Клиент сам принимает решение о целесообразности заправки, проверяет степень износа, возможность засыхания чернил.</li>
        <li>Гарантия на оказанную услугу по заправке не распространяется.</li>
    </ul>
    <p class="FoterPrint">С условиями согласен и ознакомлен ФИО, подпись клиента</p>
	<p class="lineKlient">М.П.</p>
@stop