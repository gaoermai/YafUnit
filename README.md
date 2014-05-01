# YafUnit

## Introduction

YafUnit是一个基于[Yaf](https://github.com/laruence/php-yaf)扩展的PHPUnit测试框架，目的在于以人为核心，将项目分割为多个服务，进行快速迭代的敏捷开发，同时保证每个环节是可以被测试。

## Requirement
- PHP 5.3 + (需要支持命名空间)

## Tutorial

### Layout
标准项目结构：

```
+ public
  | - index.php     // Application entry
  | + static/
     | + scripts    // js script files
     | + images     // images files
     | + styles     // css files
+ application
  | - Bootstrap.php   // Bootstrap
  | + config 
     | - application.ini // Configure 
  | + controllers
     - User.php      // User controller
  | + views
     | + user
        - index.html // View template for user controller
  | + library
  | + models   // Models
  | + modules  // Modules
  | + plugins  // Plugins
  | + Cores    // 自定义核心文件，autoload
     | + Exception                    // 核心异常类，应用公用的异常
        |- DbDeleteFailureException   // 如DB异常...
     | - Controller.php               // 核心控制器，应用的控制器将会继承这个类
     | - Model.php                    // 核心模型，应用的模型将会继承这个类，同时可以自己构建一些 MySQLModel 等
     | - Exception.php                // 核心异常类，应用的自定义异常将会继承这个类
     | - ExceptionHandler.php         // 核心异常处理类，不启动YAF本身自带的异常接收方式，抛出的异常将会被这个类接收
     | - View.php                     // 核心视图模板引擎类，应用的视图会继承这个类，可以重写一些display，render方法
     | - Session.php                  // 核心会话类，自动判断当CLI请求时模拟一个虚拟的会话句柄来完成会话操作
   | + Services      // 自定义服务层，每个服务实现自己的业务逻辑，尽量减少耦合度
     | + Http        // 这是一个Http服务例子
        |+ Request   // 里面带有一个Http请求类，通过装饰请求的方式完成CURL请求
+ tests              // 这里测试用例的目录，以下目录结构和application一致，测试文件尾部增加Test标识
  | + controllers
     - UserTest.php  // test user controller
  | + library        // test library
  | + modules        // test modules
  | + models         // test models
  | + plugins        // test plugins
   | + Services      // test Services
     | + Http
        |+ Request
  | - phpunit.xml    // 里面配置的需要测试的测试用例
  | - YafUnit.php    // 用于模拟测试的核心类，含有View/Request
  | - TestCase.php   // 测试基类，所有测试类将会继承这个类，在基境时加载需要的Yaf信息
+ vandor           // 第三方composer.json生成的文件夹，里面包含了第三方安装的所有类库，不建议修改
- composer.json    // 配置composer安装
```

### DocumentRoot
设置应用访问的Web根目录为public下

### Nginx Rewrite rules
```
server {
        listen ****;
        server_name  domain.com;
        root   document_root;
        index  index.php index.html index.htm;

        if (!-e $request_filename) {
                rewrite  ^(.*)$  /index.php?r=/$1  last;
                break;
        }
}
```

### PHPUnit testing
```
[root@centos ~]# cd [yourwebroot]/tests
[root@centos tests]# phpunit -c phpunit.xml
PHPUnit 4.0.15 by Sebastian Bergmann.

Configuration read from [yourwebroot]/tests/phpunit.xml

...............

Time: 2.87 seconds, Memory: 2.75Mb

OK (15 tests, 26 assertions)
```

### About namespace
以下目录结构中项目必须存在命名空间，除tests目录外，命名空间和文件路径一致才能保证自动装载，tests目录默认使用YafUnit做命名空间，防止冲突。
```
[yourwebroot]/application/Cores/
[yourwebroot]/application/Services/
[yourwebroot]/tests/
```

为了以防命名空间的错乱，可以将类的书写全部加上全局空间定义，如：
```
Yaf\Dispatcher => \Yaf\Dispatcher
Cores\Session  => \Cores\Session
Util_Validate  => \Util_Validate
```

### More
这个应用的设计初衷是为了实现基本的框架底层，规范框架命名和结构体系，定制自动化测试。

其他核心业务请根据自身场景进行扩展：
- 在Cores下扩展需要的Db类, Cache实现方式, 核心Controller等；
- 在Services下完成需要的业务服务，尽量减少各个Service之间的耦合度；
- 在Models下只处理底层的Db数据逻辑，把业务逻辑移动到Service中处理，提高Service的独立性；
- 在library中属于本地类库，按照Yaf自动装载规则，根据文件类型分类目录；
- 使用会话时，请使用Cores\Session，该对象会自动判断是否是CLI模式进行Session管理；
- Controller, Model, Service类中都可以增加defaultExceptionHandler静态方法用于捕捉异常的默认处理；
- 扩展Cores\View的方法，如assign，display方法等，不建议引入其他模板引擎；
- 测试用例的目录结构和application一致，测试文件尾部增加Test标识，为了可以自动生成对应的xml测试列表；
- 可以通过定义 APPLICATION_NOT_RUN 的值，引入public/index.php，实现守护进程/Crontab需求。