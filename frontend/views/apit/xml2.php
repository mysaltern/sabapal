

<?php

header('Content-Type: application/xml');

$status = $xmlValues['status'];
$auth = $xmlValues['RefID'];

//$someJSON = "[{'status':'$status','auth':'$auth'}]";




$someJSON = '[{"Status":"' . $status . '","RefID":"' . $auth . '"}]';


print ($someJSON);
?>

