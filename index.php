<?php
session_start();
ini_set('xdebug.max_nesting_level', 1000000);

////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
/////////////////////////PERFECT////////////////////////////
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////

function labParf($x, $y)
{
    if ($x > 1000000 || $y > 1000000) {
        echo 'T\'abuse pas un peu quand meme ?';
        return false;
    }
    $tab = array(array());

    for ($coordY = 0; $coordY < $y; $coordY++) {
        for ($coordX = 0; $coordX < $x; $coordX++) {
            if (!isset($tab[$coordY][$coordX]))
                $tab[$coordY][$coordX] = 'X';
        }
    }
    $tab = generateLabParf($tab, 0, 0, array());

    $tab[$y - 1][$x - 1] = 'e';
    return $tab;
}

function generateLabParf($tab, $x, $y, $walls)
{
    $tab[$y][$x] = 'e';
    $walls = putInWall($tab, $y, $x, $walls);
    while (!empty($walls)) {

        shuffle($walls);

        $neighbourVisited = 0;

        $newWall = array_pop($walls);
        $newX = explode(',', $newWall)[1];
        $newY = explode(',', $newWall)[0];

        if (isset($tab[$newY][$newX + 1]) && $tab[$newY][$newX + 1] != 'X') {
            $neighbourVisited++;
        }
        if (isset($tab[$newY + 1][$newX]) && $tab[$newY + 1][$newX] != 'X') {
            $neighbourVisited++;
        }
        if (isset($tab[$newY][$newX - 1]) && $tab[$newY][$newX - 1] != 'X') {
            $neighbourVisited++;
        }
        if (isset($tab[$newY - 1][$newX]) && $tab[$newY - 1][$newX] != 'X') {
            $neighbourVisited++;
        }

        if ($neighbourVisited == 1) {
            $tab[$newY][$newX] = 'e';
            $walls = putInWall($tab, $newY, $newX, $walls);
        } else {
            $tab[$newY][$newX] = 'w';
        }

    }
    return $tab;
}

////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
//////////////////////ENDPERFECT////////////////////////////
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
/////////////////////////IMPERFECT//////////////////////////
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////

function labImparf($x, $y)
{
    if ($x > 1000000 || $y > 1000000) {
        echo 'T\'abuse pas un peu quand meme ?';
        return false;
    }
    $tab = array(array());

    for ($coordY = 0; $coordY < $y; $coordY++) {
        for ($coordX = 0; $coordX < $x; $coordX++) {
            if (!isset($tab[$coordY][$coordX]))
                $tab[$coordY][$coordX] = 'X';
        }
    }
    $tab = generateLabImparf($tab, 0, 0, array());

    $tab[$y - 1][$x - 1] = 'e';
    return $tab;
}

function generateLabImparf($tab, $x, $y, $walls)
{
    $tab[$y][$x] = 'e';
    $walls = putInWall($tab, $y, $x, $walls);
    while (!empty($walls)) {

        shuffle($walls);

        $neighbourVisitedVert = 0;
        $neighbourVisitedHoriz = 0;

        $newWall = array_pop($walls);
        $newX = explode(',', $newWall)[1];
        $newY = explode(',', $newWall)[0];

        if (isset($tab[$newY][$newX + 1]) && $tab[$newY][$newX + 1] != 'X') {
            $neighbourVisitedVert = 1;
        }
        if (isset($tab[$newY + 1][$newX]) && $tab[$newY + 1][$newX] != 'X') {
            $neighbourVisitedHoriz = 1;
        }
        if (isset($tab[$newY][$newX - 1]) && $tab[$newY][$newX - 1] != 'X') {
            $neighbourVisitedVert = 1;
        }
        if (isset($tab[$newY - 1][$newX]) && $tab[$newY - 1][$newX] != 'X') {
            $neighbourVisitedHoriz = 1;
        }

        $neighbourVisited = $neighbourVisitedHoriz + $neighbourVisitedVert;

        if ($neighbourVisited == 1) {
            $tab[$newY][$newX] = 'e';
            $walls = putInWall($tab, $newY, $newX, $walls);
        } else {
            $tab[$newY][$newX] = 'w';
        }

    }
    return $tab;
}

////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
///////////////////ENDIMPPERFECT////////////////////////////
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
////////////////////////EXT/////////////////////////////////
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////

function checkWay($tab, $x, $y, $endPosY, $endPosX)
{
    if ($x == $endPosX && $y == $endPosY) {
        if ($tab != 'end')
            $tab[$y][$x] = 'r';

        return 'end';
    } else {
        if (isset($tab[$y][$x]) && $tab[$y][$x] == 'e' && $tab != 'end') {
            $tab[$y][$x] = 'r';
            $tabTemp = checkWay($tab, $x - 1, $y, $endPosY, $endPosX);
            if ($tabTemp != 'end') {
                $tab = $tabTemp;
            } else {
                $tab = 'end';
            }
            $tabTemp = checkWay($tab, $x + 1, $y, $endPosY, $endPosX);
            if ($tabTemp != 'end') {
                $tab = $tabTemp;
            } else {
                $tab = 'end';
            }
            $tabTemp = checkWay($tab, $x, $y - 1, $endPosY, $endPosX);
            if ($tabTemp != 'end') {
                $tab = $tabTemp;
            } else {
                $tab = 'end';
            }
            $tabTemp = checkWay($tab, $x, $y + 1, $endPosY, $endPosX);
            if ($tabTemp != 'end') {
                $tab = $tabTemp;
            } else {
                $tab = 'end';
            }
        }
    }
    return $tab;
}

function checkImp($tab, $x, $y, $endPosY, $endPosX, $check)
{
    if ($x == $endPosX && $y == $endPosY) {
        $tab[$y][$x] = 'r';
        $_SESSION['check']++;
    } else {
        if (isset($tab[$y][$x]) && $tab[$y][$x] == 'e') {
            $tab[$y][$x] = 'r';
            $tab = checkImp($tab, $x - 1, $y, $endPosY, $endPosX, $check);
            $tab = checkImp($tab, $x + 1, $y, $endPosY, $endPosX, $check);
            $tab = checkImp($tab, $x, $y - 1, $endPosY, $endPosX, $check);
            $tab = checkImp($tab, $x, $y + 1, $endPosY, $endPosX, $check);
        }
    }
    return $tab;
}

function resolveLabImp($tab, $startPosY, $startPosX, $endPosY, $endPosX, $start)
{
    if ($endPosX < $startPosX || $endPosY < $startPosY || $startPosY < 0 || $endPosX < 0) {
        echo "<br>Erreur lors de la saisie des infos dans resolveLabImparf";
        return false;
    }

    $tab = tagWayImp($tab, $startPosX, $startPosY, $endPosY, $endPosX, $start);
    return $tab;
}

function resolveLabPerf($tab, $startPosY, $startPosX, $endPosY, $endPosX)
{
    if ($endPosX < $startPosX || $endPosY < $startPosY || $startPosY < 0 || $endPosX < 0) {
        echo "<br>Erreur lors de la saisie des infos dans resolveLabImparf";
        return false;
    }

    $tab = tagWayPerf($tab, $startPosX, $startPosY, $endPosY, $endPosX);
    return $tab;
}

function tagWayImp($tab, $x, $y, $endPosY, $endPosX, $start)
{
    if ($x == $endPosX && $y == $endPosY) {
        $tab[$y][$x] = 'r';
        printLab($tab, $endPosY + 1, $endPosX + 1);
        $time_elapsed_secs = microtime(true) - $start;
        echo '<br><h2>Résolu en ' . $time_elapsed_secs . ' secondes</h2></span>';
        exit();
    }
    if (isset($tab[$y][$x]) && $tab[$y][$x] == 'e') {
        $tab[$y][$x] = 'r';
        $tabTemp = tagWayImp($tab, $x - 1, $y, $endPosY, $endPosX, $start);
        if ($tabTemp != true)
            $tab = $tabTemp;
        $tabTemp = tagWayImp($tab, $x + 1, $y, $endPosY, $endPosX, $start);
        if ($tabTemp != true)
            $tab = $tabTemp;
        $tabTemp = tagWayImp($tab, $x, $y - 1, $endPosY, $endPosX, $start);
        if ($tabTemp != true)
            $tab = $tabTemp;
        $tabTemp = tagWayImp($tab, $x, $y + 1, $endPosY, $endPosX, $start);
        if ($tabTemp != true)
            $tab = $tabTemp;
    }

    return $tab;
}

function tagWayPerf($tab, $x, $y, $endPosY, $endPosX)
{
    if ($x == $endPosX && $y == $endPosY) {
        $tab[$y][$x] = 'r';
        printLab($tab, $endPosY + 1, $endPosX + 1);

        return true;
    }
    if (isset($tab[$y][$x]) && $tab[$y][$x] == 'e') {
        $tab[$y][$x] = 'r';
        $tabTemp = tagWayPerf($tab, $x - 1, $y, $endPosY, $endPosX);
        if ($tabTemp != true)
            $tab = $tabTemp;
        $tabTemp = tagWayPerf($tab, $x + 1, $y, $endPosY, $endPosX);
        if ($tabTemp != true)
            $tab = $tabTemp;
        $tabTemp = tagWayPerf($tab, $x, $y - 1, $endPosY, $endPosX);
        if ($tabTemp != true)
            $tab = $tabTemp;
        $tabTemp = tagWayPerf($tab, $x, $y + 1, $endPosY, $endPosX);
        if ($tabTemp != true)
            $tab = $tabTemp;
    }

    return $tab;
}

function printLab($tab, $y, $x)
{
    echo "<span style='display: inline-block; margin: 10px'><div style='display:inline-block; background-color: black; height: 10px; width: 10px;'></div>";
    for ($i = 0; $i < $x; $i++) {
        echo "<div style='display:inline-block; background-color: black; height: 10px; width: 10px;'></div>";
    }
    echo "<div style='display:inline-block; background-color: black; height: 10px; width: 10px;'></div><br>";
    for ($coordY = 0; $coordY < $y; $coordY++) {
        if ($coordY == 0) {
            echo "<div style='display:inline-block; background-color: green; height: 10px; width: 10px;'></div>";
        } else {
            echo "<div style='display:inline-block; background-color: black; height: 10px; width: 10px;'></div>";
        }
        for ($coordX = 0; $coordX < $x; $coordX++) {
            if (isset($tab[$coordY][$coordX]) && $tab[$coordY][$coordX] == "w") {
                echo "<div style='display:inline-block; background-color: black; height: 10px; width: 10px;'></div>";
            } else if (isset($tab[$coordY][$coordX]) && $tab[$coordY][$coordX] == "e") {
                echo "<div style='display:inline-block; background-color: white; height: 10px; width: 10px;'></div>";
            } else if (isset($tab[$coordY][$coordX]) && $tab[$coordY][$coordX] == "r") {
                echo "<div style='display:inline-block; background-color: red; height: 10px; width: 10px;'></div>";
            } else {
                echo "<div style='display:inline-block; background-color: black; height: 10px; width: 10px;'></div>";
            }
        }
        if ($coordY == $y - 1 && $coordX == $x) {
            echo "<div style='display:inline-block; background-color: blue; height: 10px; width: 10px;'></div>";
        } else {
            echo "<div style='display:inline-block; background-color: black; height: 10px; width: 10px;'></div>";
        }
        echo "<br>";
    }
    echo "<div style='display:inline-block; background-color: black; height: 10px; width: 10px;'></div>";
    for ($i = 0; $i < $x; $i++) {
        echo "<div style='display:inline-block; background-color: black; height: 10px; width: 10px;'></div>";
    }
    echo "<div style='display:inline-block; background-color: black; height: 10px; width: 10px;'></div></span>";
}

function putInWall($tab, $y, $x, $walls)
{
    if (isset($tab[$y][$x + 1]) && !in_array(($y) . ',' . ($x + 1), $walls) && $tab[$y][$x + 1] == 'X') {
        $wall = ($y) . ',' . ($x + 1);
        array_push($walls, $wall);
    }
    if (isset($tab[$y][$x - 1]) && !in_array(($y) . ',' . ($x - 1), $walls) && $tab[$y][$x - 1] == 'X') {
        $wall = ($y) . ',' . ($x - 1);
        array_push($walls, $wall);
    }
    if (isset($tab[$y + 1][$x]) && !in_array(($y + 1) . ',' . ($x), $walls) && $tab[$y + 1][$x] == 'X') {
        $wall = ($y + 1) . ',' . ($x);
        array_push($walls, $wall);
    }
    if (isset($tab[$y - 1][$x]) && !in_array(($y - 1) . ',' . ($x), $walls) && $tab[$y - 1][$x] == 'X') {
        $wall = ($y - 1) . ',' . ($x);
        array_push($walls, $wall);
    }
    return $walls;
}

////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
/////////////////////////ENDEXT/////////////////////////////
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
////////////////////MAIN FUNCTION//////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////

function goPerfect($y, $x)
{
    echo '<span style="display: inline-block; margin-left: 3%;width: auto; vertical-align: top"><h1>Labyrinthe parfait :</h1><br>';

    $start = microtime(true);
    $tab = labParf($x, $y);
    $time_elapsed_secs = microtime(true) - $start;

    echo '<h2>Generé en ' . $time_elapsed_secs . ' secondes</h2><br>';

    $result = checkWay($tab, 0, 0, $y - 1, $x - 1);

    while ($result != 'end') {
        $tab = labParf($x, $y);
        $result = checkWay($tab, 0, 0, $y - 1, $x - 1);
    }
    printLab($tab, $y, $x);
    echo '<br><h1>Resultat(s) :</h1><br><span>(Les différents resultats qui sont affichés sont différents (les plus courts))</span><br>';

    $start = microtime(true);
    $tab = resolveLabPerf($tab, 0, 0, $y - 1, $x - 1);
    $time_elapsed_secs = microtime(true) - $start;

    echo '<h2>Résolu en ' . $time_elapsed_secs . ' secondes</h2></span>';
}

function goImperfect($y, $x)
{
    $_SESSION['check'] = 0;
    echo '<span style="display: inline-block; margin-left: 3%;width: auto; vertical-align: top"><h1>Labyrinthe imparfait :</h1><br>';

    $start = microtime(true);
    $tab = labImparf($x, $y);
    $time_elapsed_secs = microtime(true) - $start;

    echo '<h2>Generé en ' . $time_elapsed_secs . ' secondes</h2><br>';

    checkImp($tab, 0, 0, $y - 1, $x - 1, 0);

    while ($_SESSION['check'] < 2) {
        $_SESSION['check'] = 0;
        $tab = labImparf($x, $y);
        checkImp($tab, 0, 0, $y - 1, $x - 1, 0);
    }

    printLab($tab, $y, $x);

    echo '<br><h1>Resultat(s) :</h1><br>';

    $start = microtime(true);
    $tab = resolveLabImp($tab, 0, 0, $y - 1, $x - 1, $start);
}

///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
//////////////////END MAIN FUNCTION////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////
///////////////////////MAIN/////////////////////////////////
////////////////////////////////////////////////////////////

//Change this values for different maze (x->colomns y->lines)
if (isset($_GET) && isset($_GET['col']) && isset($_GET['line'])) {
    $x = $_GET['col'];
    $y = $_GET['line'];
} else {
    $x = 30;
    $y = 20;
}
?>
    <h1>Pour changer la taille du tableau inserez "?line=y&col=x"</h1>
<?php
goPerfect($y, $x);
goImperfect($y, $x);

////////////////////////////////////////////////////////////
//////////////////////////ENDMAIN///////////////////////////
////////////////////////////////////////////////////////////