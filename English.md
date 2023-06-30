# [中文](https://github.com/Siriling/Internal-and-external-IP-address-translation/blob/main/README.md) | English
Configuration file for switching between internal and external network of navigation page based on PHP

# Content

[1.Introduction](#1Introduction)

[二、视频资源 ](#二视频资源)

[三、实现](#三实现)

[4.Show](#4.Show)

# 1.Introduction

From the [blibli](https://www.bilibili.com) video website, this conversion file is developed based on PHP, but the configuration file provided by the video author cannot meet my intranet multi-application access requirements. After learning how to do it, I improved the conversion file to achieve what I wanted. This file is zhuan.php above. If it is a PHP service, add this file and write the URL to achieve it
# 2.Video resources

- [Video link1](https://www.bilibili.com/video/BV1RF411u7r1)

- [Video link2](https://www.bilibili.com/video/BV1PY41177Wa)
# 3.Implement
It is divided into two steps, the first step is to judge the access of the navigation page, and the second step is to judge the access of the application service
## Prepare

parameters in the URL

- ../: Used to splice the previous URL
- lan: The port of the intranet (do not miss `:`, do not fill in the intranet IP because it is hidden for security reasons)
- wan: Complete domain name access URL
- name: Flag bit, set the intranet IP in advance through this flag bit, and hide the intranet IP with the lan attribute

```
../zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=auto
```

> Actually the full URL is
>
> When on the Internet
>
> http://10.10.10.10/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=homarr
>
> When on the external
>
> https://start.demo.com:81/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=homarr

## Start

There are two types of navigation page access, one is to automatically switch between internal and external networks according to the submitted request, and the other is to manually click the switch button to switch between internal and external networks

## First step

Switch between internal and external network of navigation page

### Automatically switch between internal and external networks

Purpose: used as a browser home page

When you access the URL in **intranet**, it will judge whether the source IP address is an intranet, and the obtained IP address is the intranet IP address

```url
https://start.demo.com:81/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=auto
```

> URL when accessed
>
> https://start.demo.com:81/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=auto
>
> URL redirected after visiting
>
> http://10.10.10.10:1315

When you access the URL from **external**, it will judge whether the source IP address is an internal network, and the result is an external network IP address

```url
https://start.demo.com:81/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=auto
```

> URL when accessed
>
> https://start.demo.com:81/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=auto
>
> URL redirected after visiting
>
> https://start.demo.com:81

### Manually switch between internal and external networks

Purpose: for manual switching

When you click the switch button in **intranet**, it will judge whether the source IP address is an intranet, and the result is an intranet IP address

```url
../zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=switch
```

> URL when accessed
>
> http://10.10.10.10:1315/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=switch
>
> URL redirected after visiting
>
> https://start.demo.com:81

When you click the switch button in **external**, it will judge whether the source IP address is an intranet, and the result is an external IP address

```url
../zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=switch
```

> URL when accessed
>
> https://start.demo.com:81/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=switch
>
> URL redirected after visiting
>
> http://10.10.10.10:1315

## Second step

Intranet and intranet switching of application services

The principle of switching between internal and external networks of application services is similar to [Manually switch between internal and external networks](#Manually switch between internal and external networks) in the first step

### Access App Auto Switch

Purpose: When accessing applications, switch between internal and external networks according to the current network environment

When you click the switch button in **intranet**, it will judge whether the source IP address is an intranet, and the result is an intranet IP address

```url
../zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=homarr
```

> URL when accessed
>
> http://10.10.10.10:1315/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=switch
>
> URL redirected after visiting
>
> http://10.10.10.10:1315

When you click the switch button in **external**, it will judge whether the source IP address is an intranet, and the result is an external IP address

```url
../zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=homarr
```

> URL when accessed
>
> https://start.demo.com:81/zhuan.php?lan=:1315&wan=https://start.demo.com:81&name=switch
>
> URL redirected after visiting
>
> https://start.demo.com:81

# 4.Show

导航页

![start](images\start.png)

内外网切换

![Internal and external IP address translation](images\Internal and external IP address translation.png)

应用服务

![application](images\application.png)