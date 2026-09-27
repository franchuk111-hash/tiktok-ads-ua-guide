<?php
header("Content-Type: text/plain; charset=utf-8");
if ((isset($_GET["k"]) ? $_GET["k"] : "") !== "dep927") { http_response_code(403); exit("no"); }
$root = "/home/creditkz/tiktok-ads.com.ua/www/";
$url  = "https://raw.githubusercontent.com/franchuk111-hash/tiktok-ads-ua-guide/main/deploy2.zip";
$zip  = $root . "_dep.zip";
$data = @file_get_contents($url);
if ($data === false) { echo "ERR download allow_url_fopen=" . ini_get("allow_url_fopen"); exit; }
file_put_contents($zip, $data);
echo "downloaded=" . strlen($data) . "\n";
echo "zipclass=" . (class_exists("ZipArchive") ? "yes" : "no") . "\n";
if (!class_exists("ZipArchive")) { exit; }
$z = new ZipArchive();
$r = $z->open($zip);
echo "open=" . var_export($r, true) . " files=" . (is_resource($z) || $r === TRUE ? $z->numFiles : -1) . "\n";
if ($r === TRUE) {
  $ok = $z->extractTo($root);
  echo "extract_www=" . var_export($ok, true) . "\n";
  $z->close();
}
foreach (["dlia-avto","dlia-medytsyny","dlia-finansiv","dlia-turyzmu","dlia-it","creator-marketplace","influencer-marketing","oplata/payment-failed"] as $d) {
  $p = $root . $d . "/index.html";
  echo "check " . $d . ": " . (file_exists($p) ? filesize($p) . "b" : "MISSING") . "\n";
}
