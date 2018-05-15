<!DOCTYPE html>

<html>
<head>
    <title>Rediger grupper</title>
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link href="Rediger.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <meta charset="utf-8">
    
   <script>
function itemInSpot(drag_item,spot)
{
    var oldSpotItem = $(spot).find('img');
    if(oldSpotItem.length>0) {
        oldSpotItem.appendTo('#inventory').draggable({ revert: 'invalid' });
    }
    var item = $('<img />');
    item.attr('src',drag_item.attr('src')).attr('class',drag_item.attr('class')).appendTo(spot).draggable({ revert: 'invalid' });
    drag_item.remove(); // remove the old object
}

$(document).ready(function() {
    $(".circles").draggable({ revert: 'invalid'});
    $('#inventory').droppable();
    $("#circles").droppable({ accept: '.circles'})
    $('#circles,#inventory').bind('drop', function(ev,ui) { itemInSpot(ui.draggable,this); });
});

</script>

</head> 
<body>
<header>
    <h1>Rediger Grupper</h1>
<form action="../IT-systemet/logud.php" method="post">
<a style="text-decoration: none" href="../logud.php"><img class=logud src="../css/logout.png"></a>
</form>
</header>

<div class="liste">
    <h2>IxD Studerende på 2. semester</h2>
    <?php
    require_once '../connection.php';
    require_once '../globalfunctions.php';
    globalfunctions();
    
    $query = "SELECT gruppeid FROM studerende ORDER BY gruppeid_redigeret DESC";
    $result = select_query($query, $connection);
    $result = query_to_array($result);
    $antalgrupper = $result[0][0];
    
    for($f=1; $f<=$antalgrupper; $f++){
        echo '<ul class="grupper" id=gruppe' . $f . ">";
        $query = "SELECT id, fornavn, efternavn FROM studerende WHERE gruppeid_redigeret = " . $f . " ORDER BY fornavn ASC, efternavn ASC";
        $result = select_query($query, $connection);
        $result = query_to_array($result);
        echo "<h3> Gruppe " . $f . "</h3>";
        for($i=0; $i<count($result); $i++){
            echo '<li class="gruppe ' . $f . '"><input readonly draggable="true" ondragstart"drag(event)" ondrop="drop(event)" ondragleave="drop(event)" ondragover="allowDrop(event)" value="' . $result[$i][1] . ' ' . $result[$i][2] . '"></li>';
        }        
        echo "</ul>";
    }
    
    
    
    mysqli_close($connection);
    ?>
</div>

<div class="NB"><!--Nustil og gem knap-->
<form action="Nulstil.php" method="post">
    <button class="nulstil">Nulstil</button>
    </form>
<form action="gemgrupper.php" method="post">
    <button class="bekraeft">Bekræft</button>
    </form>
</div>

<footer>
    <form action="sendstu.php" method="post">
    <button class="sendstu">Send grupper til studerende</button>
    </form>
    <form action="sendsek.php" method="post">
    <button class="sendsek">Send grupper til studiesekretær</button>
    </form>
</footer>

</body>
</html>
