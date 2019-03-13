<div id="playername">Username: none selected</div><br>
<?php
    include_once "MinecraftQuery.class.php";
    if(! file_exists('OnlinePlayerSettings.ini'))
    {
        echo('Invalid configuration.');
        Return;
    }
    
    $Query = new MinecraftQuery( );
    $settings = parse_ini_file('OnlinePlayerSettings.ini');
    
    try
    {
        $Query->Connect($settings['Ip'] , $settings['Port']);
        $players = $Query->GetPlayers();
        if($players == null)
        {
            echo($settings['NoPlayers']);
            Return;
        }
        foreach($players as $username)
        {
            echo('<img src="http://cravatar.eu/helmavatar/' . $username . '.png" title="' . $username . '" onmouseover="enlarge(this)" onmouseout="shrink(this)">    ');
        }
    }
    catch( MinecraftQueryException $e )
    {
        echo $e->getMessage( );
    }
?>

<script>
document.getElementById('playername').style.visibility = 'hidden';
var hidden = null;

function enlarge(x) {
    x.style.height = "40px";
    x.style.width = "40px";
    if(hidden != null)
    {
        window.clearTimeout(hidden);
        hidden = null;
    }
    document.getElementById('playername').style.visibility = 'visible';
    document.getElementById('playername').innerHTML = 'Username: ' + x.title;
}

function shrink(x) {
    x.style.height = "32px";
    x.style.width = "32px";
    if(hidden != null)
    {
        window.clearTimeout(hidden);
        hidden = null;
    }
    hidden = window.setTimeout(function() {document.getElementById('playername').style.visibility = 'hidden';}, 500);
}
</script>