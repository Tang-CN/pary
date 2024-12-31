# Pray

前后端数据分离祈福项目

## 项目介绍

本项目是一个基于爬虫 demo 主要功能是从指定网站上自动抓取特定数据，将其存储到 MySQL 数据库中，并通过 ThinkPHP 框架提供 API 接口以供前端调用，前端采用 Vue3 开发，实现数据的动态展示和交互，最终为用户提供一个祈福页面，展现爬取的数据内容。

- 前端使用 unibest 框架，实现祈福页面展示。
- 后端使用 Thinkphp 框架，实现 RESTful API 接口。
- 数据使用 python 爬虫，实现数据爬取。

## 功能特点

- 前端使用实现祈福页面展示, 数据请求。
- 后端使用 Thinkphp 框架，统一成功/失败响应格式封装，解决跨域请求。
- 数据使用 python 爬虫，实现数据获取，数据清洗，数据过滤。

## 使用说明

- 克隆项目到本地 安装依赖
- 框架文档都在
- 爬虫代码在 pray_spider 文件当中
- 后端代码在 tp 文件当中
- 前端代码在 unibest 文件当中
- 图片根据爬取的 json 文件存放 tp/public/static 文件下
- 效果在/pray.gif
  ![效果](https://github.com/Tang-CN/pray/blob/main/pray.gif)

## 技术栈

- Vue3.js：
- TypeScript:
- Thinkphp：
- MySQL：
- Python：

## 缺点

- 数据存储需要手动导入爬取的 json 文件
