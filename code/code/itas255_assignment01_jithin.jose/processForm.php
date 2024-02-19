<?php
function __autoload($class)
{
   require_once $class.'.php';
}
$name= $_POST['Pname'];
$weight=$_POST['weight'];
$hitpoint=$_POST['hitPoint'];
$location=$_POST['location'];
$lat=0;
$long=0;
echo $location;
if($location=="woodgroove")
{
$lat =49.23556056 ;
$long=-124.0510907;

}
else if($location=="viu")
{
    $lat =49.1574665 ;
    $long=-123.9657361 ;
}
else if($location=="north") {
    $lat =49.2437526 ;
    $long=-124.0482331 ;
}
else if($location=="aquaticcentre")
{
    $lat =49.1619054;
    $long=-123.9630757;
}
else if($location=="collerydam")
{
    $lat =49.1499533;
    $long=-123.9645227;
}

else
{
    echo "not in the location";
}
echo "<br>".$lat."<br>".$long;
$train =new Trainer("","","","");
$poke = new $name($weight,$hitpoint,$lat,$long);
$train->add($poke);
$worlds= Worlds::getInstance();
$worlds->load();
$worlds->poke($poke);
echo $worlds->getJSON();


?>