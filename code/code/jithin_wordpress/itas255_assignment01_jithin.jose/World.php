<?php

// croftd: since we registered an __autoload we shouldn't need to require these
//require_once "Paras.php";
//require_once "Pikachu.php";
//require_once "Bulbasaur.php";
//require_once "Pidgey.php";

/**
 * Main class for our Pokemon program that stores:
 *
 * A List of Wild Pokemon
 * A Single Trainer (who has a list of Pokemons on a Pokedex)
 *
 * Note this is a Singleton and there should only every be one World object.
 */

//
require_once ("Trainer.php");
require_once ("Pokemon.php");
//session_start();
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

class World
{
    static $instance;

    private $trainer ; // Trainer
    private $message = "";
    private $wildPokemon = array(); // Array to store WildPokemon
    private $trainPokemon;


    /**
     * @return World object - this is a Singleton.
     * Note with languages such as PHP that load everything on each request
     * Singleton not as important...
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new World();
        }
        return self::$instance;
    }

    /**
     * Used to reset the World (reset to null), for use with SESSION management (see getPokemon.php)
     */
    public static function reset()
    {
        self::$instance == null;
    }

    private function __construct()
    {
        $this->trainer = new Trainer('Dave', 'trainer.png', 49.159706, -123.907757);
    }

    // Also required for Singleton
    private function __clone()
    {
    }

    /**
     * @return array of the Wild Pokemon in the world.
     */
    public function getWildPokemon() {
        return $this->wildPokemon;
    }

    /**
     * @return array of the Trainer's pokemon
     */
    public function getTrainersPokemon() {
        return $this->trainer->getPokemon();
    }

    /**
     *
     */
    public function removePokemon(Pokemon $pokemon)
    {
        if (($key = array_search($pokemon, $this->wildPokemon)) !== false) {
            unset($this->wildPokemon[$key]);
        }
    }
    public function removeTrainPokemon(Pokemon $pokemon)
    {
        if (($key = array_search($pokemon, $this->getTrainersPokemon())) !== true) {
            unset($this->getTrainersPokemon()[$key]);
        }
    }


    /**
     * Call this method before battle or getJSON to load the wild and trainer pokemon into the World
     */
    public function load()
    {

        $this->wildPokemon = $this->loadPokemon('wildPokemon.txt');

        $this->trainer->setPokemon($this->loadPokemon( 'trainerPokemon.txt'));

        $this->addMessage("Loaded pokemons from files");
    }

    /**
     * When called, this function will find the nearest wild Pokemon, move the Trainer and his Pokemon to this
     * location, and attack. See the image created by @matthewt for the flow chart (in the REW301_code repo)
     */



    public function nearestDistance($trainPoke, $wildPokemon)
    {
        $distance=$this->distance($trainPoke->getLat(),$trainPoke->getLong(),$wildPokemon->getLat(),$trainPoke->getLong());

        return $distance;
    }

    public function nearestPokemon()
    {
        $distance=array();
        foreach($this->wildPokemon as $wild)
        {
            $distance[]=$this->nearestDistance($this->trainer,$wild);

        }
    }
    public function setPosition($lat,$long)
    {
        foreach ($this->getTrainersPokemon() as $poke)
        {
            $poke->setLat($lat+0.01);
            $poke->setLong($long+0.01);
        }

    }


    public function battle()
    {
        //$this->addMessage("Battling");

        // STEP 1 - find the nearest pokemon

        $nearestDistance = 0;
        $nearestWild = null;

        $trainLat = $this->trainer->getLat();
        $trainLong = $this->trainer->getLong();

        foreach ($this->wildPokemon as $wild) {

            $distance = $this->distance($trainLat, $trainLong, $wild->getLat(), $wild->getLong());

            if ($nearestWild == null) {
                $nearestWild = $wild;
                $nearestDistance = $distance;
                continue;
            }
            if ($distance < $nearestDistance) {
                $nearestDistance = $distance;
                $nearestWild = $wild;
                $this->addMessage("<br>found out the nearest wild= " . $nearestWild->getName() . "<br>Nearest Distance=" . $nearestDistance);
                //$this->addMessage("<br>found out the nearest wild= ".$nearestWild->getName()."<br>Distance=".$nearestDistance);
            }
        }


        // END of Step 1 - now we know the nearest pokemon

        // STEP 2
        // Change the trainer and trainers pokemon to have the same lat,long as $nearestWid

            $this->trainer->setLong($nearestWild->getLong());
            $this->trainer->setLat($nearestWild->getLat());
            $this->setPosition($nearestWild->getLat(), $nearestWild->getLong());
            $this->addMessage("<br>Setting the trainers lat to " . $this->trainer->getLat() . "<br>and long=" . $this->trainer->getLong() . "<br>");
        //end of the step 2

        // STEP 3
        // loop through the trainer's pokemon, and let the first one attack $nearestWild
        //foreach ($this->getTrainersPokemon() as $tPoke) {
            //$tPoke->setLat($nearestWild->getLat());
            //$tPoke->setLong($nearestWild->getLong());
        //}
        foreach ($this->getTrainersPokemon() as $tPoke) {
            $tPoke->setLat($nearestWild->getLat());
            $tPoke->setLong($nearestWild->getLong());

            $tPokeALive = true;
            while ($tPokeALive == true) {
                $tPoke->attack($nearestWild);
                //$tPoke->setPosition($nearestWild->getLat(),$nearestWild->getLong());
                if ($nearestWild->getHP() > 0) {
                    $nearestWild->attack($tPoke);


                } else {
                    $this->addMessage($tPoke->getName() . "'s Trainer HP = " . $tPoke->getHP() ." Killed ". $nearestWild->getName() . "'s Wild HP = " . $nearestWild->getHP());

                    $this->removePokemon($nearestWild);
                    return;
                }

                if ($tPoke->getHP() < 0) {
                    $tPokeALive = false;
                    $this->trainer->remove();
                }


               /* if($this->wildPokemon=0)
                {
                    $this->addMessage("!st Battle Won");
                    echo "Loading new Pokemon";
                    $this->wildPokemon = $this->loadPokemon('wildPokemon.txt');
                }*/



            }
        }
    }


            /* foreach ($this->getTrainersPokemon() as $tPoke ) {
                 $tPoke->setLat($nearestWild->getLat());
                 $tPoke->setLong($nearestWild->getLong());
                 $tPoke->attack($nearestWild);
                 if ($nearestWild->getHP() > 0) {
                     $nearestWild->attack($tPoke);
                 }
                 $this->addMessage("Trainer HP" . $tPoke->getHP() . "Wild HP" . $nearestWild->getHP());
                 if($nearestWild->getHP() < 0)
                 {
                     echo "<br>Killed =" . $nearestWild->getName();
                     $tPoke->attack($nearestWild);
     //                $this->removePokemon($nearestWild);
                 }*/
//            while ($tPoke->getHP() > 0) {
//                $tPoke->attack($nearestWild);
//                if($nearestWild->getHP() > 0) {
//                    $nearestWild->attack($tPoke);
//                }







        // if $nearestWild still have (hp > 0), let $nearestWild->attach(trainersFirstPokemon)
        // loop again until either trainers first pokemon is dead, or wild pokemon is dead
        // if trainers first pokemon is dead, loop onto the second trainer's pokemon and let it attack $nearestWild

            //$this->addMessage("Battling started");
            /*echo "<br>Batling Started ";
            $distance = $this->nearestDistance($trainPoke, $wild);
            if($nearestDistance<$distance)
            {
                $nearestDistance=$distance;

            }*/

            /* }
             $sortDistance=sort($distance);
             foreach($sortDistance as $x => $x_value) {
                 echo "Key=" . $x . ", Value=" . $x_value;
                 echo "<br>";
             }*/


            //nearestDistance give the disatnce two pokemon.
            /*$nearestWild = $wild;
            $this->addMessage("Founded the nearest wild =" . $nearestWild->getName());
            echo "<br>Founded the nearest wild =" . $nearestWild->getName();

        foreach ($this->getTrainersPokemon() as $trainPoke) {

                $trainPoke->setLong($nearestWild->getLong());
                $trainPoke->setLat($nearestWild->getLat());
                $trainPoke->attack($nearestWild);
                while ($nearestWild->getHP() > 0) {
                    $trainPoke->attack($nearestWild);
                }
                if ($nearestWild->getHP() <= 0) {
                    echo "<br>Killed =" . $nearestWild->getName();
                    $this->removePokemon($nearestWild);
                }
                if ($trainPoke->getHP() <= 0) {
                    echo "<br>Killed =" . $trainPoke->getName();
                    break;
                }
                //$nearestWild->attack($trainPoke);
                echo "<br>The power of " . $trainPoke->getName() . "=" . $trainPoke->getHP();
                echo "<br>The power of " . $nearestWild->getName() . "=" . $nearestWild->getHP();*/



    /*public function battle()
    {

        $this->addMessage("Battling... ");

        $nearestWild = null;
        $nearestDistance = 0;

        foreach ($this->wildPokemon as $wild) {

            $distance = $this->distance($this->trainer->getLat(), $this->trainer->getLong(),
                $wild->getLat(), $wild->getLong());

            // the first time through, we will assume this distance is the closest one, as we haven't checked the others...
            if ($nearestWild == null) {
                $nearestWild = $wild;
                $nearestDistance = $distance;
                $this->addMessage("Found the next nearest wild pokemon: " . $wild->getName());

                $this->trainer->setLat($nearestWild->getLat());
                echo $nearestWild->getLat();
                $this->trainer->setLong($nearestWild->getLong());
                echo $nearestWild->getLong();
                foreach ($this->trainer->getPokemon() as $tPoke) {
                    // same idea - update the lat/long for each of the trainer's $tPoke
                    $tPoke->setLong($nearestWild->getLong());
                    $tPoke->setLat($nearestWild->getLat());
                    $tPokeAlive = true;
                    if($tPokeAlive = true) {
                        $tPoke->attack($nearestWild);
                        $this->addMessage("TRainer" . $tPoke->getName() . "Attacking");
                        echo "<br>HP power of the".$tPoke->getName()."=".$tPoke->getHP();
                        if ($tPoke->getHP() > 0) {
                            $this->addMessage("TRainer" . $tPoke->getName() . " killed" . $nearestWild->getName());

                        }
                    }



                    //*/

                    /*foreach ($this->trainer->getPokemon() as $tPoke) {
                        // attack the current wild pokemon
                        $tPokeAlive = true;
                        while ($tPokeAlive == true) {
                            $tPoke->attack($nearestWild);
                            $this->addMessage("Trainer_" . $tPoke->getName() . " attacked Wild_" . $nearestWild->getName() . " HP:" . $nearestWild->getHitPoints());

                            // if $nearestWild has getHitPoint() > 0, then let the nearest wild attack $tPoke

                            // etc. etc.. you will have to translate my directions above into working code!*/


                // the next time through, you'll need an else if statement to check if the next $wild's distance is less than $nearestDistance, and if so set this as $nearestWild





    /**
     * Helper function to calculate distance between two points
     *
     * @param $lat1 - first lat coord
     * @param $lon1 - first long coord
     * @param $lat2 - second lat coord
     * @param $lon2 - second long coord
     * @return float - distance in kilometers between the two coords
     */
    function distance($lat1, $lon1, $lat2, $lon2) {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));

        $dist = acos($dist);
        $dist = rad2deg($dist);

        $miles = $dist * 60 * 1.1515;
        //echo "Distance=".$miles *1.609344."<br>"."<br>";

        // return value in kilometers – or maybe we want meters precision?
        return $miles *1.609344;

    }

    /**
     * @param $message - Add a String message to send back with the next call to getJSON()
     */
    public function addMessage($message)
    {
        $this->message = $this->message . " " . $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function clearMessage()
    {
        // reset the messeage that is sent with JSON back to blank
        $this->message = "";
    }

    /**
     * @return string - a valid JSON String containing a list of all the Trainer and Pokemon Google Map markers.
     *
     * The format should look like:
     *
     * <pre>
     *
     *{"markers": [{"lat":  49.159720,"long":  -123.907773,"name": "Paras","image": "paras.jpg" },{"lat":  49.171154,"long":  -123.971443
     * ,"name": "Pidgey","image": "pidgey.jpg" },{"lat":  49.152864,"long":  -123.94873
     * ,"name": "Paras","image": "paras.jpg" },{"lat":  49.1350026,"long":  -123.9220046
     * ,"name": "Paras","image": "paras.jpg" },{"lat":  49.178561,"long":  -123.857631
     * ,"name": "Bulbasaur","image": "bulbasaur.jpg" },{"lat":  49.162736,"long":  -123.892478
     * ,"name": "Bulbasaur","image": "bulbasaur.jpg" },{"lat":  49.1790103,"long":  -123.9199447
     * ,"name": "Pidgey","image": "pidgey.jpg" },{"lat":  49.1675630,"long":  -123.9383125,"name": "Pidgey","image": "pidgey.jpg" } ],
     * "message": "BattleCount[9] Server Messages: Trainer starting with pokemon index"}
     *
     * </pre>
     */
    public function getJSON()
    {

        // croftd: This is just an example to make the initial map and getPokemon.php
        // talk to each other
        // To complete the lab you will have to loop through all the wild pokemon
        // and all the trainer's pokemon and add build a JSON string to return

   //     $jsonToReturn = '{"markers": [{"lat":  49.159720,"long":  -123.907773,"name": "Paras","image": "paras.png" },{"lat":  49.171154,"long":  -123.971443
    //,"name": "Pidgey","image": "pidgey.png" },{"lat":  49.152864,"long":  -123.94873
    //,"name": "Paras","image": "paras.png" },{"lat":  49.1350026,"long":  -123.9220046
   // ,"name": "Paras","image": "paras.png" },{"lat":  49.178561,"long":  -123.857631
   // ,"name": "Bulbasaur","image": "bulbasaur.png" },{"lat":  49.162736,"long":  -123.892478
    //,"name": "Bulbasaur","image": "bulbasaur.png" },{"lat":  49.1790103,"long":  -123.9199447
    //,"name": "Pidgey","image": "pidgey.png" },{"lat":  49.1675630,"long":  -123.9383125,"name": "Pidgey","image": "pidgey.png" } ],
   // "message": "BattleCount[0] <br>Server Messages: This is just test data!"}';

        $newJSON ='{"markers": [';
        $length = count($this->getTrainersPokemon());
        $counter = 0;
        foreach ($this->getWildPokemon() as $poke) {
            $individualJSON = $poke->getJson();
            $newJSON .= $individualJSON . ',';
        }
        foreach ($this->getTrainersPokemon() as $poke) {
            $individualJSON = $poke->getJson();
            $newJSON .= $individualJSON;
            if ($counter < ($length - 1)) {
                $newJSON .= ',';
            }

            //$newJSON .=$indvidualJSON;
            $counter++;
        }

        $newJSON .='], "message": "' . $this->getMessage() . '"}';

        return $newJSON;
    }





   /* public function getJSON()
    {

        // croftd: This is just an example to make the initial map and getPokemon.php
        // talk to each other
        // To complete the lab you will have to loop through all the wild pokemon
        // and all the trainer's pokemon and add build a JSON string to return

        //     $jsonToReturn = '{"markers": [{"lat":  49.159720,"long":  -123.907773,"name": "Paras","image": "paras.png" },{"lat":  49.171154,"long":  -123.971443
        //,"name": "Pidgey","image": "pidgey.png" },{"lat":  49.152864,"long":  -123.94873
        //,"name": "Paras","image": "paras.png" },{"lat":  49.1350026,"long":  -123.9220046
        // ,"name": "Paras","image": "paras.png" },{"lat":  49.178561,"long":  -123.857631
        // ,"name": "Bulbasaur","image": "bulbasaur.png" },{"lat":  49.162736,"long":  -123.892478
        //,"name": "Bulbasaur","image": "bulbasaur.png" },{"lat":  49.1790103,"long":  -123.9199447
        //,"name": "Pidgey","image": "pidgey.png" },{"lat":  49.1675630,"long":  -123.9383125,"name": "Pidgey","image": "pidgey.png" } ],
        // "message": "BattleCount[0] <br>Server Messages: This is just test data!"}';

        $newJSON ='{"markers": [';
        $length = count($this->getWildPokemon());
        $counter = 0;
        foreach ($this->getWildPokemon() as $poke)
        {
            $individualJSON = $poke->getJson();
            $newJSON .= $individualJSON;
            if ($counter < ($length-1)) {
                $newJSON .= ',';
            }

            //$newJSON .=$indvidualJSON;
            $counter++;
        }
        $newJSON .='], "message": "' . $this->getMessage() . '"}';

        return $newJSON;
    }

    public function getJsonTrain()
    {
        $newJSON ='{"markers": [';
        $length = count($this->getTrainersPokemon());
        $counter = 0;
        foreach ($this->getTrainersPokemon() as $poke)
        {
            $individualJSON = $poke->getJson();
            $newJSON .= $individualJSON;
            if ($counter < ($length-1)) {
                $newJSON .= ',';
            }

            //$newJSON .=$indvidualJSON;
            $counter++;
        }
        $newJSON .='], "message": "' . $this->getMessage() . '"}';

        return $newJSON;

    }*/












    /**
     * Function to load Pokemon objects from a csv file
     *
     * @param $filename
     * @return array containing Pokemon objects
     */
    public function loadPokemon($filename)
    {
        $pokes=array();
        //$slash=//
        $pokemons=file("$filename");
        foreach ($pokemons as $poke) {
//            if($poke[0] == '#')
//            {
//                continue;
//            }
            list($name, $hp, $weight, $lat, $long) = explode(",", $poke);
            $pokemon = new $name($weight,$hp,$lat,$long);
            $pokes[] = $pokemon;
            echo "<br>Loaded new pokemon $name";

        }
         return $pokes;
    }
    public function loading()
    {
        $this->wildPokemon = $this->loadPokemon('wildPokemon.txt');
        $this->trainer->setPokemon($this->loadPokemon('user.txt'));
    }








}
