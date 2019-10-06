<?php
function escape($string)
{
    global $connection;

    $string = mysqli_real_escape_string($connection, trim($string));

    return htmlspecialchars($string);
}

function confirm($result)
{
    global $connection;

    if(!$result)
    {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}
?>