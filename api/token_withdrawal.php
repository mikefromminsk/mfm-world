<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/mfm-world/api/utils.php";

$gas_address = get_required(gas_address);
$domain = get_required(domain);
$amount = get_int_required(amount);

if ($domain == $gas_domain) error("cannot deposit gas");

if (worldBalance($domain, [avatar, $gas_address]) < $amount) error("not enough balance");

tokenSend($domain, world, $gas_address, $amount);
dataDec([avatar, $gas_address, inventory, $domain], $amount);

commit();
