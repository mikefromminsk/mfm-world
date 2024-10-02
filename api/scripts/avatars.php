<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/mfm-token/utils.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/mfm-data/utils.php";

$val = get_required(avatar_name);
$val = get_required(scene_path);
$val = get_required(portal_name);
$val = get_required(texture);
$val = get_required(rase); // human robot

$response[content] = $val;

commit($response);