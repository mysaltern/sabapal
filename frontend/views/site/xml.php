<?php header("Content-Type: application/xml; charset=utf-8"); ?>
<?xml version="1.0" encoding="UTF-8"?>


<?php

$xml = new \yii\web\XmlResponseFormatter;
$xml->rootTag = 'Response';

Yii::$app->response->format = 'custom_xml';
Yii::$app->response->formatters['custom_xml'] = $xml;

return ['customer' => ['name' => 'John Smith']];
?>

