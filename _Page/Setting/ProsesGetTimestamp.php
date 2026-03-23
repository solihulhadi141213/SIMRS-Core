<?php
    $dt = new DateTime(null, new DateTimeZone("UTC"));
    $timestamp = $dt->getTimestamp();
    echo "$timestamp";
?>