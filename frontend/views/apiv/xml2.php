

<?php

header('Content-Type: application/xml');

$status = $xmlValues['Status'];
$resNum = $xmlValues['RefID'];

//$someJSON = "[{'status':'$status','auth':'$auth'}]";




$someJSON = '[{"Status":"' . $status . '","RefID":"' . $resNum . '"}]';


print ($someJSON);
?>

