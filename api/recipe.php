<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/mfm-world/api/utils.php";

$domain = get_required(domain);

$response[recipes] = dataObject([recipe, $domain], 100);

commit($response);