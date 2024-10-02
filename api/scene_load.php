<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/mfm-world/api/utils.php";

$scene_name = get_required(scene);

if (!dataExist([$scene_name])) error("scene does not exist");

$scene = dataObject([$scene_name], 1000);

for ($x = 0; $x < $scene[settings][width]; $x++) {
    for ($y = 0; $y < $scene[settings][height]; $y++) {
        $spawner_base = endsWith($scene[blocks]["$x:$y"][domain], _spawner);
        if ($spawner_base != null && countMobs($scene, $x, $y, 10, $spawner_base) < 5) {
            $pos = randPos($scene, $x, $y, 10);
            dataSet([$scene_name, mobs, $pos, domain], $spawner_base);
            foreach (dataObject([info, $spawner_base, loot], 100) as $domain => $amount) {
                worldSend($domain, [world], [$scene_name, mobs, $pos], $amount);
            }
        }
    }
}

commit();