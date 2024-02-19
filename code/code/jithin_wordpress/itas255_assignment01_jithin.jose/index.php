<?php


//exit();

function __autoload($class)
{
    require_once $class.'.php';
}
$world= World::getInstance();
//$world->loadPokemon('wildPokemon.txt');
$world->load();
echo $world->getJSON();


//$jsonTrain=$world->getJsonTrain();
//
//echo "<br>".$jsonTrain;
//echo "<br>";

//$train = new Trainer("jithin","image","43","23");
/*$bulbasaur = new Bulbasaur("12","55","45","35");
echo $bulbasaur;

$bulbasaur2 = new Bulbasaur("53","77","35","55");
$bulbasaur3 = new Bulbasaur("45","44","77","87");
$pikachu = new Pikachu("78","35","45","14");

$paras = new Paras("42","45","64","87");
$paras2 = new Paras("36","57","25","55");
$paras3= new Paras("77","74","75","75");
$train->add($bulbasaur);
$train->add($bulbasaur2);
$train->add($bulbasaur3);
$train->add($pikachu);
$train->add($paras);
$train->add($paras2);
$train->add($paras3);*/
$train->printALL();
$train->attackALL();

echo "THE END";


?>