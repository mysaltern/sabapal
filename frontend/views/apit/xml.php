

<?php

header('Content-Type: application/xml');

$status = $xmlValues['status'];
$auth = $xmlValues['auth'];

//$someJSON = "[{'status':'$status','auth':'$auth'}]";




$someJSON = '[{"Status":"' . $status . '","Authority":"' . $auth . '"}]';


print ($someJSON);
?>

