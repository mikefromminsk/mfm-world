<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/mfm-world/api/utils.php";

$path = get_required(path);

$response[inventory] = dataObject([$path, inventory], 1000);

commit($response);
