<?php
/* 允许跨域（如前端与后端不同域名） */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

/* 取 POST 原始 JSON */
$input = json_decode(file_get_contents('php://input'), true);
if (!$input)  die(json_encode(['code'=>1,'msg'=>'JSON 非法']));

$score = intval($input['score'] ?? 0);
$wrong = $input['wrong'] ?? [];

/* 这里仅演示：写本地文件，可按需改数据库 */
$file = 'scores/' . date('Y-m-d') . '.log';
if (!is_dir('scores')) mkdir('scores');
$line = date('Y-m-d H:i:s') . "\t" . $_SERVER['REMOTE_ADDR'] . "\t" . $score . "分\t" . json_encode($wrong, JSON_UNESCAPED_UNICODE) . PHP_EOL;
file_put_contents($file, $line, FILE_APPEND);

/* 返回成功 */
echo json_encode(['code'=>0,'msg'=>'已记录','score'=>$score,'wrong_count'=>count($wrong)]);
?>