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

// 需要测试的 Blob 名称
$blobName = "test.txt"; // 替换为你的实际文件名

// 构造完整 URL
$blobUrl = sprintf("%s/%s/%s%s",
    rtrim($config['AccountUrl'], '/'),
    $config['ContainerName'],
    $blobName,
    $config['sassString']
);

// 使用 cURL 发起请求
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $blobUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($response === false) {
    echo "请求失败: " . curl_error($ch) . PHP_EOL;
} else {
    echo "HTTP 状态码: $httpCode" . PHP_EOL;
    if ($httpCode == 200) {
        echo "访问成功!" . PHP_EOL;
        echo substr($response, 0, 500) . PHP_EOL; // 只显示前500字节
    } elseif ($httpCode == 403) {
        echo "403 Forbidden: 权限不足或 SAS Token 无效/过期" . PHP_EOL;
    } else {
        echo "其他错误:" . PHP_EOL;
        echo $response . PHP_EOL;
    }
}

curl_close($ch);
