<?php

?>


<!DOCTYPE html>
<html lang="">
<head>
    <title>Fill the data</title>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>

    <div style="display: flex;justify-content: center;align-items: center;width: 100%;height: 100%">
        <table>
            <thead>
                <tr>
                    <td><b>Id</b></td>
                    <td><b>Text</b></td>
                    <td><b>Mail sent</b></td>
                    <td><b>Sms sent</b></td>
                </tr>
            </thead>
            <?php foreach ($list as $item): ?>
                <tr>
                    <td><?= $item->id ?></td>
                    <td><?= $item->text ?></td>
                    <td><?= $item->mail_sent ? 'Yes' : 'No' ?></td>
                    <td><?= $item->sms_sent ? 'Yes' : 'No' ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</body>
</html>
