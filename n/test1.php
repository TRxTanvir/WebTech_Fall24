<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    srGFsRGfsG
<?php
 
//orecle connection
$conn=oci_connect('system', 'scott', '//localhost/XE');
 
$query= 'select * from AC';
$stid = oci_parse($conn, $query);
 
oci_execute($stid);
$result=oci_fetch_assoc($stid);
print_r($result);
 
if($result){
    echo "success";
}
else{
    echo "fail";
}