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

// cURL 请求
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $blobUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false); // 只返回 body
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($response === false) {
    echo "请求失败: " . curl_error($ch) . PHP_EOL;
} else {
    echo "HTTP 状态码: $httpCode" . PHP_EOL;

    if ($httpCode == 200) {
        echo "访问成功!" . PHP_EOL;
        echo substr($response, 0, 500) . PHP_EOL;
    } else {
        // 尝试解析 Azure 返回的 XML 错误信息
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($response);
        if ($xml !== false && isset($xml->Code) && isset($xml->Message)) {
            echo "错误代码: " . (string)$xml->Code . PHP_EOL;
            echo "错误信息: " . (string)$xml->Message . PHP_EOL;
        } else {
            echo "未解析到详细错误信息:" . PHP_EOL;
            echo $response . PHP_EOL;
        }
    }
}

curl_close($ch);
