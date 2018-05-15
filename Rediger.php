<!DOCTYPE html>

<html>
<head>
    
    <style>
    .ui-drop-hover{border:2px solid #bbb;} 
    .grupper{
        width:180px;height:250px;
    
    }
    
    .grupper li{border:1px solid #bbb;
    </style>
    
    <title>Rediger grupper</title>
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link href="Rediger.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <meta charset="utf-8">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
    <script src="http://code.jquery.com/ui/1.8.20/jquery-ui.min.js" type="text/javascript"></script>
    <script src="http://jquery-ui.googlecode.com/svn/tags/latest/external/jquery.bgiframe-2.1.2.js"
        type="text/javascript   "></script>
    <script src="http://jquery-ui.googlecode.com/svn/tags/latest/ui/minified/i18n/jquery-ui-i18n.min.js"
        type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $(".grupper li").draggable({
                appendTo: "body",
                helper: "clone",
                cursor: "move",
                revert: "invalid"
            });
 
            initDroppable($(".grupper li"));
            function initDroppable($elements) {
                $elements.droppable({
                    activeClass: "ui-state-default",
                    hoverClass: "ui-drop-hover",
                    accept: ":not(.ui-sortable-helper)",
 
                    over: function(event, ui) {
                        var $this = $(this);
                    },
                    drop: function(event, ui) {
                        var $this = $(this);
                        var li1 = $('<li>' + ui.draggable.text() + '</li>')
                        var linew1 = $(this).after(li1);
 
                        var li2 = $('<li>' + $(this).text() + '</li>')
                        var linew2 = $(ui.draggable).after(li2);
 
                        $(ui.draggable).remove();
                        $(this).remove();
 
                        initDroppable($(".grupper li"));
                        $(".grupper li").draggable({
                            appendTo: "body",
                            helper: "clone",
                            cursor: "move",
                            revert: "invalid"
                        });
                    }
                });
            }
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
<form action="gemgrupper.php" method="post">
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
            echo '<li class="ui-droppable" name="' . $result[$i][0] . '">' . $result[$i][1] . " " . $result[$i][2] . "</li>";
        }        
        echo "</ul>";
    }
    
    
    g
    mysqli_close($connection);
    ?>
</div>

<div class="NB"><!--Nustil og gem knap-->
<button class="bekraeft">Bekræft</button>
    </form>

<form action="Nulstil.php" method="post">
    <button class="nulstil">Nulstil</button>
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
