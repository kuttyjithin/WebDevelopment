<?php
?>

<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>A play with form</title>
    <meta name="Form" content="width=device-width, initial-scale=1">

    <style>
        #wrapper
        {
            border: 2px solid black;
        }
        form
        {
            background-color:rgb(173, 216, 230);
            font-family: Arial, sans-serif; padding: 10px;
        }
        label
        {
            float: left;
            width: 100px; clear: left; text-align: right;
            padding-right: 10px; margin-top: 10px;
        }
        input, textarea
        {
            display: inline;
            margin-top: 10px;
        }
        #mySubmit
        {
            margin-left: 110px;
        }
        .redS
        {
            color: red;
        }

    </style>
</head>
<body>

<h1>Make your PokeMon</h1>

<div id="wrapper">
    <form method="POST" action="mapuser.php">
        <label for="Pname" ><span class="redS">*</span>Pokemon Name:</label>
        <br><select id="Pname" name="Pname">

            <option value="Pidgey"> Pidgey</option>
            <option value="Paras"> Paras</option>
            <option value="Pikachu">Pikachu</option>
            <option value="Bulbasaur"> Bulbasaur</option>
        </select> <br><br>
        <label for="Weight"><span class="redS">*</span>Weight:</label>
        <input type="text"  required name="weight" id="weight"><br><br>
        <label ><span class="redS">*</span>Hit point:</label>
        <input type="text"  required name="hitPoint" id="hitPoint"><br><br>
        <label for="location"><span class="redS">*</span>Location:</label>
        <br><select id="location" name="location">

            <option value="viu"> VIU</option>
            <option value="woodgroove"> Woodgroove</option>
            <option value="aquaticcentre">Aquatic Centre</option>
            <option value="collerydam"> Collery Dam</option>
            <option value="north"> Nort Nanaimo</option>
        </select> <br><br>
        <br>
        <br>
        <input type="submit" id="mySubmit" value="SUBMIT">


    </form>
</div>
</body>
</html>