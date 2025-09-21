<?php
$config = [
    'DefaultEndpointsProtocol'=>'https',
    'AccountName'=>'wechatmatrixstorage',
    'AccountKey'=>'3lQM7GNaHUSP3bSO7Z/YwdXWRDQI9IskAdRAT7XylR09bl971fmfNs1QaJ5lFbl2/xqYJ6k7CketHs/hZBL6cA==',
    'EndpointSuffix'=>'core.chinacloudapi.cn',
    'AccountUrl' => '',
    'ContainerName' => 'gsk',
    'sassString' => '',
];


// 要测试的 Blob 名称
$blobName = "test.txt"; // 替换成你实际的文件

// 构造完整 URL
$blobUrl = sprintf("%s/%s/%s%s",
    rtrim($config['AccountUrl'], '/'),
    $config['ContainerName'],
    $blobName,
    $config['sassString']
);

// 初始化 cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $blobUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true); // 返回 header + body
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// 开启详细调试输出
curl_setopt($ch, CURLOPT_VERBOSE, true);
$verbose = fopen('php://temp', 'w+');
curl_setopt($ch, CURLOPT_STDERR, $verbose);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// 分离响应头和 body
$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $headerSize);
$body = substr($response, $headerSize);

echo "HTTP 状态码: $httpCode\n";
echo "==== 响应头 ====\n";
echo $header . "\n";
echo "==== 响应体 ====\n";
echo $body . "\n";

// 打印详细调试信息
rewind($verbose);
$verboseLog = stream_get_contents($verbose);
echo "==== cURL 调试信息 ====\n";
echo $verboseLog;

curl_close($ch);
