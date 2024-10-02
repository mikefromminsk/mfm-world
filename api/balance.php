<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/mfm-world/api/utils.php";

$address = get_required(address);
$domain = get_required(domain);

$response[balance] = worldBalance($domain, [avatar, $address]);

commit();