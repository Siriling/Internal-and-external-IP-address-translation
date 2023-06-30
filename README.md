# 中文 | [English](https://github.com/Siriling/Internal-and-external-IP-address-translation/blob/main/English.md)
基于 PHP 的导航页内外网切换配置文件

# 目录

[一、简介](#一简介)

[二、视频资源 ](#二视频资源)

[三、实现](#三实现)

[四、展示](#四展示)

# 一、简介

从[blibli](https://www.bilibili.com)视频网站的看到的，这个转换文件是基于PHP开发的，但是视频作者提供的配置文件无法满足我的内网多应用访问需求。 了解了实现方法后，我改进了转换文件，实现了我想要的效果。 该文件就是上面的zhuan.php。  如果是PHP服务就添加这个文件，写上URL即可实现
# 二、视频资源

- [视频链接1](https://www.bilibili.com/video/BV1RF411u7r1)

- [视频链接2](https://www.bilibili.com/video/BV1PY41177Wa)
# 三、实现
分为两步，第一步判断导航页面的访问，第二步判断应用服务的访问
## 准备

URL中的参数

- ../：用于拼接前面的URL
- lan：内网的端口（不要少了`:`，不填写内网IP是因为安全原因隐藏起来）
- wan：完整的域名访问URL
- name：标志位，通过这个标志位提前设置好内网IP，配合lan属性隐藏内网IP

```
../zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=auto
```

> 实际上完整的URL为
>
> 处于内网时
>
> http://10.10.10.10/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=homarr
>
> 处于外网时
>
> https://start.demo.com:81/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=homarr

## 开始

导航页访问有两种，一种是根据提交的请求自动切换内外网，另外一种为手动点击切换按钮进行内外网切换

## 第一步

导航页的内外网切换

### 自动切换内外网

用途：用于作为浏览器主页

当你在**内网**访问该URL时，会判断来源IP地址是否为内网，结果获取到的为内网IP地址

```url
https://start.demo.com:81/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=auto
```

> 访问时的URL
>
> https://start.demo.com:81/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=auto
>
> 访问后跳转的URL
>
> http://10.10.10.10:1315

当你在**外网**访问该URL时，会判断来源IP地址是否为内网，结果获取到的为外网IP地址

```url
https://start.demo.com:81/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=auto
```

> 访问时的URL
>
> https://start.demo.com:81/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=auto
>
> 访问后跳转的URL
>
> https://start.demo.com:81

### 手动切换内外网

用途：用于手动切换

当你在**内网**点击切换按钮时，会判断来源IP地址是否为内网，结果获取到的为内网IP地址

```url
../zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=switch
```

> 访问时的URL
>
> http://10.10.10.10:1315/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=switch
>
> 访问后跳转的URL
>
> https://start.demo.com:81

当你在**外网**点击切换按钮时，会判断来源IP地址是否为内网，结果获取到的为外网IP地址

```url
../zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=switch
```

> 访问时的URL
>
> https://start.demo.com:81/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=switch
>
> 访问后跳转的URL
>
> http://10.10.10.10:1315

## 第二步

应用服务的内外网切换

应用服务的内外网切换原理类似于第一步中的[手动切换内外网](#)

### 访问应用自动切换

用途：用于访问应用时，根据当前网络环境进行内外网切换

当你在**内网**访问应用服务时，会判断来源IP地址是否为内网，结果获取到的为内网IP地址

```url
../zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=homarr
```

> 访问时的URL
>
> http://10.10.10.10:1315/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=switch
>
> 访问后跳转的URL
>
> http://10.10.10.10:1315

当你在**外网**访问应用服务时，会判断来源IP地址是否为内网，结果获取到的为外网IP地址

```url
../zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=homarr
```

> 访问时的URL
>
> https://start.demo.com:81/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=switch
>
> 访问后跳转的URL
>
> https://start.demo.com:81

# 四、展示

导航页

![start](images\start.png)

内外网切换

![Internal and external IP address translation](images\Internal and external IP address translation.png)

应用服务

![application](images\application.png)