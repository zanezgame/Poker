<?php
include 'Poker.php';
$joker = new Poker();
$joker->gameStart($_SERVER['QUERY_STRING']);
//$joker -> gameStart('12345');
?>