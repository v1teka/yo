<?php

header('Content-Type: application/json');

if($_GET['number']=="304")
    $data =[
        "comp1" => ["id" => 0, "ip" =>"192.168.1.58", "active" => 0, "locationX" => 3, "locationY" => 1, "inventoryNumber" => "101 040 010 390", "cpu" => "Intel Core 2 Quad Q6700"],
        "comp2" => ["id" => 1, "ip" =>"192.168.1.53", "active" => 0, "locationX" => 5, "locationY" => 1, "inventoryNumber" => "101 040 010 391", "cpu" => "Intel Core 2 Quad Q6700"],
        "comp3" => ["id" => 2, "ip" =>"192.168.1.69", "active" => 0, "locationX" => 1, "locationY" => 6, "inventoryNumber" => "101 040 010 392", "cpu" => "Intel Core 2 Quad Q6700"],
        "comp4" => ["id" => 3, "ip" =>"127.0.0.1", "active" => 0, "locationX" => 1, "locationY" => 8, "inventoryNumber" => "101 040 010 393", "cpu" => "Intel Core 2 Quad Q6700"]
    ];
else
$data = [
    "comp1" => ["id" => 0, "active" => 1, "locationX" => 2, "locationY" => 2, "inventoryNumber" => "101 040 010 390", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp2" => ["id" => 1, "active" => 1, "locationX" => 2, "locationY" => 3, "inventoryNumber" => "101 040 010 391", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp3" => ["id" => 2, "active" => 1, "locationX" => 3, "locationY" => 3, "inventoryNumber" => "101 040 010 392", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp4" => ["id" => 3, "active" => 0, "locationX" => 2, "locationY" => 5, "inventoryNumber" => "101 040 010 393", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp5" => ["id" => 4, "active" => 1, "locationX" => 3, "locationY" => 5, "inventoryNumber" => "101 040 010 394", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp6" => ["id" => 5, "active" => 1, "locationX" => 2, "locationY" => 7, "inventoryNumber" => "101 040 010 395", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp7" => ["id" => 6, "active" => 1, "locationX" => 3, "locationY" => 7, "inventoryNumber" => "101 040 010 400", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp8" => ["id" => 7, "active" => 0, "locationX" => 2, "locationY" => 9, "inventoryNumber" => "101 040 010 399", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp9" => ["id" => 8, "active" => 1, "locationX" => 3, "locationY" => 9, "inventoryNumber" => "101 040 010 398", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp10" => ["id" => 9, "active" => 1, "locationX" => 2, "locationY" => 11, "inventoryNumber" => "101 040 010 397", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp11" => ["id" => 10, "active" => 1, "locationX" => 3, "locationY" => 11, "inventoryNumber" => "101 040 010 401", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp12" => ["id" => 11, "active" => 0, "locationX" => 5, "locationY" => 3, "inventoryNumber" => "101 040 010 402", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp13" => ["id" => 12, "active" => 1, "locationX" => 6, "locationY" => 3, "inventoryNumber" => "101 040 010 404", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp14" => ["id" => 13, "active" => 1, "locationX" => 5, "locationY" => 5, "inventoryNumber" => "101 040 010 413", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp15" => ["id" => 14, "active" => 1, "locationX" => 6, "locationY" => 5, "inventoryNumber" => "101 040 010 405", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp16" => ["id" => 15, "active" => 0, "locationX" => 5, "locationY" => 7, "inventoryNumber" => "101 040 010 406", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp17" => ["id" => 16, "active" => 1, "locationX" => 6, "locationY" => 7, "inventoryNumber" => "101 040 010 407", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp18" => ["id" => 17, "active" => 1, "locationX" => 5, "locationY" => 9, "inventoryNumber" => "101 040 010 408", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp19" => ["id" => 18, "active" => 1, "locationX" => 6, "locationY" => 9, "inventoryNumber" => "101 040 010 409", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp20" => ["id" => 19, "active" => 0, "locationX" => 5, "locationY" => 11, "inventoryNumber" => "101 040 010 410", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp21" => ["id" => 20, "active" => 1, "locationX" => 6, "locationY" => 11, "inventoryNumber" => "101 040 010 411", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp22" => ["id" => 21, "active" => 1, "locationX" => 5, "locationY" => 13, "inventoryNumber" => "101 040 010 412", "cpu" => "Intel Core 2 Quad Q6700"],
    "comp23" => ["id" => 22, "active" => 1, "locationX" => 6, "locationY" => 13, "inventoryNumber" => "101 040 010 396", "cpu" => "Intel Core 2 Quad Q6700"]
];

echo json_encode($data);

?>