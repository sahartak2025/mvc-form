<?php

?>


<!DOCTYPE html>
<html lang="">
<head>
    <title>Fill the data</title>
</head>
<body>

<div style="display: flex;justify-content: center;align-items: center;width: 100%;height: 100%">
    <form action="/save" method="post" style="display: flex;flex-direction: column">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <label for="">
            Input text
        </label>
        <textarea name="text" id="" cols="30" rows="10"></textarea>
        <input type="submit" value="Save">
    </form>
</div>

</body>
</html>
