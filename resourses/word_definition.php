<?php
$data = json_decode(file_get_contents('php://input'), true);
if ($data["word"] === "Смысл") {
    echo json_encode(array("definition" => "<p>Смысл может быть у выражения или действия - некоторое невидимое и за</p>"));
} else if ($data["word"] === "Истина") {
    echo json_encode(array("definition" => "<p>Степень соотв
ествия действительности, утверждает что любое выражение истино, но 
    занимает различное место в иерархии истины</p>"));

} else if ($data["word"] === "Система") {
    echo json_encode(array("definition" => "<p>Совокупность связаных елементов, обладающая свойством эмерджентности</p>"));
}


