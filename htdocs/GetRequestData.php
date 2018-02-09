<?php

function GetRequestData() {
    parse_str(file_get_contents('php://input'), $data);
    return $data;
}

?>
