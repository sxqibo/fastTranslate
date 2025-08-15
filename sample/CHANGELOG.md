# 更新日志

## 2024-12-19 - Google V3 翻译优化

### 修复的问题

1. **凭据文件路径问题**
   - 修复了 `GOOGLE_APPLICATION_CREDENTIALS` 环境变量设置
   - 使用绝对路径确保凭据文件能被正确读取

2. **Google V3 API 调用错误**
   - 修复了 `detect` 方法中使用了错误的客户端类的问题
   - 将 `TranslateClient` (V2) 替换为 `TranslationServiceClient` (V3)
   - 修正了 `detectLanguage` 方法的参数格式

3. **错误处理改进**
   - 添加了完善的异常处理
   - 提供了网络连接问题的诊断信息
   - 添加了凭据文件存在性检查

### 代码变更

#### src/Translate/Translate.php
- 修复了 Google V3 的 `detect` 方法实现
- 使用正确的 `TranslationServiceClient` 和参数格式

#### sample/FactoryDemoGoogleV3.php
- 修复了凭据文件路径设置
- 添加了错误处理和网络配置选项
- 使用较短的测试文本减少复杂性

#### 新增文件
- `sample/README_GoogleV3.md` - Google V3 使用说明
- `sample/CHANGELOG.md` - 更新日志
- `sample/FactoryDemoGoogleV2.php` - Google V2 示例（API Key 方式）

### 使用方法

#### Google V3 (推荐用于生产环境)
```php
// 设置凭据文件路径
$credentialsPath = __DIR__ . '/your-credentials.json';
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $credentialsPath);

$config = [
    'project_id' => 'your-project-id',
    'http_options' => [
        'timeout' => 30,
        'connect_timeout' => 10,
    ]
];

$obj = TranslateFactory::getTranslateObject('googleV3', $config);
$result = $obj->detectLanguage('Hello world');
```

#### Google V2 (简单易用)
```php
$config = [
    'api_key' => 'your-api-key'
];

$obj = TranslateFactory::getTranslateObject('googleV2', $config);
$result = $obj->getTranslation('Hello world', 'zh-CN');
```

### 注意事项

1. **网络访问**：Google V3 需要能够访问 `translate.googleapis.com`
2. **凭据文件**：确保 JSON 凭据文件存在且有正确的权限
3. **项目 ID**：确保 `project_id` 与 Google Cloud 项目一致
4. **API 权限**：服务账号需要有 Cloud Translation API 的访问权限

### 故障排除

如果遇到网络连接问题：
1. 检查网络连接
2. 配置代理（如果需要）
3. 检查防火墙设置
4. 增加超时时间
