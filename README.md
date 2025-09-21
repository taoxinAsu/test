# test

```
SELECT id,
       img_url AS old_url,
       CONCAT(
           'https://saauthtx.corpnet5.com/blob',
           REPLACE(
               SUBSTRING_INDEX(img_url, '?', 1), 
               'https://cn01sawechatdevtestsa01.blob.core.chinacloudapi.cn',
               ''
           )
       ) AS new_url
FROM article
WHERE img_url LIKE 'https://cn01sawechatdevtestsa01.blob.core.chinacloudapi.cn%';


```

```
UPDATE article
SET img_url = CONCAT(
    'https://saauthtx.corpnet5.com/blob',
    REPLACE(
        SUBSTRING_INDEX(img_url, '?', 1),
        'https://cn01sawechatdevtestsa01.blob.core.chinacloudapi.cn',
        ''
    )
)
WHERE img_url LIKE 'https://cn01sawechatdevtestsa01.blob.core.chinacloudapi.cn%';


```
