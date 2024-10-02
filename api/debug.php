<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/mfm-world/api/utils.php";

$response[world] = dataObject([""], 1000);

commit($response);
