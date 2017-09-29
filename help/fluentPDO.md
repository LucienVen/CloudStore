
## Database: FluentPDO
与 [FluentPDO](https://github.com/envms/fluentpdo) 框架基本相同，有以下几点变化

1. 初始化类的时候不需要再传递 pdo 实例：

    ```php
    void __construct(array $db, FluentStructure $structure = null)

    参数：
        $db: 数据库信息配置数组，格式为
             'db' => [
                 'host' => '127.0.0.1',
                 'user' => 'root',
                 'pass' => '1234',
                 'dbname' => 'vshare',
                 'prefix' => 'v_',
             ]
    ```

2. 对于`from()`、`insertInto()`、`update()`、`deleteFrom()`不需要再传递表名，FPDO 会根据继承其的Model 文件名自动初始化表名，所以请**将 Model 文件名与数据库表名对应**。
3. `\FluentPDO->getField` 获取表的字段

    ```php
    array getField()

    返回值：
        表的字段数组
    ```

4. `\BaseQuery->field` 开启过滤不需要的字段（插入时）

    ```php
    \BaseQuery field()

    返回值：
        该查询实例自身
    ```

5. `\BaseQuery->getFPDO` 获取传递到本查询实例的 fpdo 实例

    ```php
    \FluentPDO getFPDO()

    返回值：
        返回本查询的前置 FPDO 实例
    ```

