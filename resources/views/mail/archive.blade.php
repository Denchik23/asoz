<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>
<h2>Сервисный центр "@-Service"</h2>
<p style="margin-bottom: 25px;">Рекомедуется архивировать старые заявки.</p>
<table border="1" cellpadding="5">
    <tr>
        <td>Всего заявок</td>
        <td>Кондитатов на архивирование</td>
        <td>Дата</td>
    </tr>
    <tr>
        <td>{{ (! $countRepair) ? 'Ошибка запроса':$countRepair}}</td>
        <td>{{ (! $countArcive) ? 'Ошибка запроса':$countArcive}}</td>
        <td>{{$timeMessage}}</td>
    </tr>
</table>
<p>--------------------------------------</p>
<p>Сообщение сгенирированно автоматически, отвечать на него НЕНУЖНО !</p>
</body>
</html>