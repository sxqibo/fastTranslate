# Google Cloud Translate V3 使用说明

## 前置条件

1. **Google Cloud 项目**：需要有一个启用了 Cloud Translation API 的 Google Cloud 项目
2. **服务账号密钥**：需要下载服务账号的 JSON 密钥文件
3. **网络访问**：需要能够访问 Google Cloud API

## 配置步骤

### 1. 获取服务账号密钥

1. 访问 [Google Cloud Console](https://console.cloud.google.com/)
2. 选择你的项目
3. 进入 "IAM 和管理" > "服务账号"
4. 创建新的服务账号或选择现有的
5. 为服务账号分配 "Cloud Translation API 用户" 角色
6. 创建并下载 JSON 格式的密钥文件

### 2. 放置密钥文件

将下载的 JSON 密钥文件放在 `sample/` 目录下，例如：
```
sample/
  └── translate2025-464112-daa7d0598c52.json
```

### 3. 配置项目 ID

在示例代码中，确保 `project_id` 与你的 Google Cloud 项目 ID 一致：

```php
$config = [
    'project_id' => 'your-project-id-here',
    'http_options' => [
        'timeout' => 30,
        'connect_timeout' => 10,
    ]
];
```

## 网络配置

### 如果遇到网络连接问题

1. **检查网络连接**：确保能够访问 `translate.googleapis.com`
2. **配置代理**：如果需要使用代理，可以在配置中添加：

```php
$config = [
    'project_id' => 'your-project-id',
    'http_options' => [
        'proxy' => 'http://your-proxy:port',
        'timeout' => 30,
        'connect_timeout' => 10,
    ]
];
```

3. **防火墙设置**：确保防火墙允许访问 Google Cloud API

## 使用方法

### 语言检测

```php
$obj = TranslateFactory::getTranslateObject('googleV3', $config);
$result = $obj->detectLanguage('Hello world');
```

### 文本翻译

```php
$result = $obj->getTranslation('Hello world', 'zh-CN');
```

## 常见问题

### 1. 凭据文件错误
```
Unable to read the credential file specified by GOOGLE_APPLICATION_CREDENTIALS
```
**解决方案**：检查凭据文件路径是否正确，确保文件存在且有读取权限。

### 2. 网络连接超时
```
Failed to connect to translate.googleapis.com
```
**解决方案**：
- 检查网络连接
- 配置代理（如果需要）
- 增加超时时间
- 检查防火墙设置

### 3. 项目 ID 错误
```
请配置 project_id
```
**解决方案**：确保在配置中正确设置了 `project_id`。

### 4. API 权限不足
```
Permission denied
```
**解决方案**：确保服务账号有足够的权限访问 Cloud Translation API。

## 测试

运行示例代码：
```bash
php sample/FactoryDemoGoogleV3.php
```

如果一切配置正确，应该能看到语言检测结果。
