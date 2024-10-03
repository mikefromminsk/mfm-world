<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/mfm-token/utils.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/mfm-world/api/utils.php";

$address = get_required(address);
$password = get_required(password);

onlyInDebug();


requestEquals("/mfm-token/init.php", [
    address => $address,
    password => $password
]);


function launchList($tokens, $address, $password)
{
    foreach ($tokens as $token) {
        $domain = $token[domain];
        $amount = $token[amount] ?: 1000000;
        tokenAccountReg($domain, $address, $password, $amount);
        $account = requestAccount($domain, $GLOBALS[address]);
        if ($account[balance] > 0){
            $key = tokenKey($domain, $address, $password, $account[prev_key]);
            $next_hash = tokenNextHash($domain, $address, $password, $key);
            postWithGas("/mfm-world/api/token_deposit.php", [
                domain => $domain,
                amount => $account[balance],
                pass => "$key:$next_hash"
            ]);
        }
        unset($token[domain]);
        if (sizeof(array_keys($token)) > 0) {
            postWithGas("/mfm-world/api/info_set.php", [
                domain => $domain,
                info => json_encode($token),
            ]);
        }
        if (worldBalance($domain, [avatar, $GLOBALS[address]]) == 1000000)
            postWithGas("/mfm-world/api/send.php", [
                from_path => implode("/", [avatar, $GLOBALS[address]]),
                to_path => world,
                domain => $domain,
                amount => $amount / 2,
            ]);
    }
}


$tokens = [
    [domain => "rock"],
    [domain => "oak_tree_generator"],
    [domain => "oak_tree", loot => [
        "oak_log" => 1,
    ]],
    [domain => "oak_log"],
    [domain => "stone"],
    [domain => "house1", recipe => [
        "oak_log" => 8
    ]],
    [domain => "house2", recipe => [
        "oak_log" => 20
    ]],
    [domain => "house3", recipe => [
        "stone" => 30
    ]],
    [domain => "zombie", loot => [
        "stone" => 1,
    ]],
    [domain => "zombie_spawner"],
    [domain => "zombie_spawner_generator"],
    [domain => "chest", recipe => [
        "oak_log" => 8
    ]],
];

launchList($tokens, $address, $password);


$response[success] = true;

echo json_encode($response);