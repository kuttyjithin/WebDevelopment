<?php
/**
 * Created by PhpStorm.
 * User: Jithin Jose
 * Date: 2019-10-02
 * Time: 8:14 PM
 */
public function battle()
{
    $this->addMessage("Battling");

    $nearestDistance=0;
    $nearestWild= null;
    $distance = array();

    foreach ($this->getTrainersPokemon() as $trainPoke)
    {
        foreach ($this->wildPokemon as $wild) {

            if ($trainPoke->getHP() > 0) {
                $this->addMessage("Battling started");
                $distance = $this->distance($trainPoke->getLat(), $trainPoke->getLong(),
                    $wild->getLat(), $wild->getLong());
                $nearestWild = $wild;
                $this->addMessage("Founded the nearest wild");
                $trainPoke->setLong($nearestWild->getLong());
                $trainPoke->setLat($nearestWild->getLat());
                $trainPoke->attack($nearestWild);
                echo "The power of " . $trainPoke->getName() . "=" . $trainPoke->getHP();
            }
        }
    }
}

            /*$trainlive=true;
            if($trainlive = true)
            {
                $trainlive=false;
                $trainPoke->attack($nearestWild);
                $this->addMessage("Trainer ".$trainPoke->getName()."  killed=".$nearestWild->getName());
                echo "<br>Power of wild pokemon= ".$nearestWild->getHP()."<br>";
                echo "Power of wild pokemon= ".$trainPoke->getHP()."<br>";
                if($nearestWild->getHP()>=0)
                {

                }
            }*/








$name= $_POST['Pname'];
$weight=$_POST['weight'];
$hitpoint=$_POST['hitPoint'];
$location=$_POST['location'];
$lat=0;
$long=0;

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
    null;
}