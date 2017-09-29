# CloudStore Api 使用手册
## 零、使用

引用的各个框架、插件官方手册：

- [Slim](https://www.slimframework.com/docs/)
- [FluentPDO](http://envms.github.io/fluentpdo/)
- [Composer](https://docs.phpcomposer.com)

下载：`git clone https://github.com/touchFishTeam/CloudStore_API.git cloudstore`

```shell
cd cloudstore

# global
composer install
# local
php composer.phar install
```

开启服务器后，访问http://your.domain.com/cloudstore/public/index.php/test

如果成功，显示：

```
"success"
```

创建 mysql 数据库名为 `cloudstore`，导入`/help/test.sql`文件，在`/App/Settings.php`中将`db`中的配置改为你的数据库配置，访问http://your.domain.com/cloudstore/public/index.php/test/yourname

如果成功，显示：

```
[{"id":"1","name":"123"},{"id":"2","name":"abada"}]
```

配置完成

---

## 一、入口

public文件夹下的`index.php`

```
public
|--index.php
|--start.php
```

```php
<?php
// 可编辑条目

// 定义应用文件夹
define("APP_PATH", __DIR__."/../App");

// Slim实例变量，在应用文件夹中
$app = \Core\Start::getApp();
```

---

## 二、文件结构

```
App							应用文件夹
  |--Action						控制器
  |--Model						模型
  |--Route						路由
  |--Validate					验证器// TODO
Core						核心文件夹
	|--FluentPDO				FluentPDO 插件
	|--Action.php				主控制器
	|--Application.php			应用文件加载器
	|--Config.php				配置文件加载器
	|--Init.php					核心文件初始化载入
	|--Model.php				主模型
	|--Start.php				框架启动器
	|--Validate.php				主验证器
public						公有文件夹
	|--index.php				入口文件
	|--start.php				启动器
vendor						composer插件
composer.json				composer插件目录
```

---

## 三、配置文件

App 目录下的`Settings.php`文件为该应用的配置文件

在 settings 中可以对 Slim 框架进行配置，在 [Slim官方手册](https://www.slimframework.com/docs/) 中查阅详情

在 db 中进行数据库的配置

```php
// database setting
[
    'db' => [
      'host' => '127.0.0.1',		// 服务器地址
      'user' => 'root',				// 数据库用户名
      'pass' => '0212',				// 数据库密码
      'dbname' => 'cloudstore',		// 数据库名
      'prefix' => '',				// 表前缀，空为没有
	]
];
```

---

## 四、路由

与 Slim 中的路由定义相同

**需要注意的是，要将路由文件名写为`*.route.php`形式**

在结构上，最好路由文件与控制器、模型、验证器同名，便于管理

---

## 五、控制器

1. 遵循 PSR-0 协议，自定义控制器的命名空间**必须**为该控制器所处的目录，以便自动加载器可以识别

2. 自定义控制器**必须**继承主控制器，可以使用完全限定名称来引用主控制器，即`\Core\Action`形式

3. 自定义控制器**必须**这样进行初始化：

   ```php
   // ...
   public function __construct($c)
   {
       parent::__construct($c);
       // ../
   }
   //...
   ```

4. 控制器本质上只负责对数据的**分发**，对数据的操作、识别，以及数据库的操作，都应该放在 Model 中

5. 控制器使用 php 内部异常类来返回异常，使用`\Exception`类捕获异常

6. 本框架为 API 后台设计，所以**必须**使用主控制器中定义的返回方法进行数据返回

7. 返回方法

   ```php
   /**
    * 成功响应
    *
    * @param array $data 成功数据
    * @param int   $code 状态码
    *
    * @return \Psr\Http\Message\ResponseInterface    Response 响应
    */
   protected function success($data, $code = 200);

   /**
    * 错误响应
    *
    * @param int    $code 错误码
    * @param string $info 错误信息
    *
    * @return \Psr\Http\Message\ResponseInterface    Response 响应
    */
   protected function error($code, $info = null);

   // 在自定义的控制器中
   $this->success($res, 301);
   $this->error(404, "Resource Not Found");
   ```

8. Cookie

   ```php

   /**
    * 设置响应头中的 set-cookies 字段
    *
    * @param \Slim\Http\Cookies $cookie   Slim Cookie 对象
    * @param array|string       $value    要设置的 Cookie
    * @param String             $path     有效路径
    * @param string             $expires  过期时间
    * @param bool               $httponly 是否为 http 只读
    *
    * @return void
    */
   protected function cookie($cookie, $value, $path = "/", $expires = null, $httponly = false);
   ```

   ​

实例：

```php
<?php
// App/Action/User.php

namespace App\Action;

use \Core\Action;

class User extends Action
{
 	public function __construct($c)
    {
    	parent::__construct($c);
	}
  
    public function info()
    {
        try {
            $user = new \App\Model\User;
            $res = $user->info($this->_request->getParsedBody());
            return $this->success($res);
        } catch (\Exception $e) {
            return $this->error($e->code);
        }
    }
}
```



## 六、模型

## 七、验证器

## 八、中间件