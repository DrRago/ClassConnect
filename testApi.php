<?php
$fp = fopen("newFile.txt", 'w+');
$start = time();

for ($i = 1; $i < 999999999; ++$i) {
    $date = date("d.m.Y H:i:s") . ": ";
    fwrite($fp, $date);

    $content = getContent();
    if (!isset($firstcrash) & $content == "null") {
        $f = fopen("firstCrash.txt", 'w');
        fwrite($f, $date);
        fclose($f);
        $firstcrash = 1;
    }

    fwrite($fp, getContent());
    echo (date("d.m.Y H:i:s") . ": ". getContent() . "\n");
    fwrite($fp, "\r\n");
    time_sleep_until($start + $i * 10);
}
fclose($fp);

function getContent() {
    $data["k"] = "QVBJV0Vic2l0ZSBza2lhZG5zZ";
    $data["id"] = 1;
    $url = 'http://api.tandashi.de/api/get_user';
    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ),
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result == null) {
        $result = "null";
    }
    return $result;
}