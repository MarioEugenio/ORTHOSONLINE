<?php
$xml = simplexml_load_file('http://globoesporte.globo.com/dynamo/futebol/times/palmeiras/rss2.xml');
echo "<pre>".__FILE__.':'.__LINE__."<hr>"; print_r($xml->channel); echo "</pre><hr>"; die();
