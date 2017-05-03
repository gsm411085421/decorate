-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017-05-03 04:35:38
-- 服务器版本： 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fengniao_decorate`
--

-- --------------------------------------------------------

--
-- 表的结构 `tp_admin`
--

CREATE TABLE `tp_admin` (
  `id` smallint(6) NOT NULL,
  `user` varchar(30) NOT NULL,
  `name` char(10) DEFAULT NULL,
  `phone` char(15) NOT NULL DEFAULT '' COMMENT '电话',
  `password` char(64) NOT NULL,
  `headimg` varchar(100) DEFAULT NULL,
  `last_login_time` datetime DEFAULT NULL,
  `last_login_ip` varchar(15) DEFAULT NULL,
  `login_times` int(11) NOT NULL DEFAULT '0',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delete_time` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-正常  0-禁用'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_admin`
--

INSERT INTO `tp_admin` (`id`, `user`, `name`, `phone`, `password`, `headimg`, `last_login_time`, `last_login_ip`, `login_times`, `create_at`, `delete_time`, `status`) VALUES
(1, 'admin', '超级管理员', '', 'b70482e5bc2ccd501a5ceff731233136', '20170424\\1e4260296e100db0bf89ce9f8a8f6a60.jpg', '2017-04-25 09:05:29', '2130706433', 1, '2017-04-24 05:36:17', NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tp_auth_group`
--

CREATE TABLE `tp_auth_group` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_auth_group`
--

INSERT INTO `tp_auth_group` (`id`, `title`, `status`, `rules`) VALUES
(1, '普通管理员', 1, '1,2,5,72'),
(4, '总经理', 1, '1,2,3,4,50,49,48,54,5,38,39,37,36,69,35,34,46,44,67,68,33,31,30,29,51,32,52,47'),
(5, '副总经理', 1, '1,5'),
(8, 'Boss', 1, '5'),
(10, '人特让他', 1, '5,72,38,39,37,36,69');

-- --------------------------------------------------------

--
-- 表的结构 `tp_auth_group_access`
--

CREATE TABLE `tp_auth_group_access` (
  `uid` mediumint(8) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_auth_group_access`
--

INSERT INTO `tp_auth_group_access` (`uid`, `group_id`) VALUES
(1, 4),
(1, 5),
(2, 1),
(2, 4),
(2, 5),
(2, 8),
(3, 1),
(3, 4),
(3, 5),
(3, 8),
(5, 4),
(7, 1),
(8, 10);

-- --------------------------------------------------------

--
-- 表的结构 `tp_auth_rule`
--

CREATE TABLE `tp_auth_rule` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_auth_rule`
--

INSERT INTO `tp_auth_rule` (`id`, `name`, `title`, `type`, `status`, `condition`) VALUES
(1, 'Auth/index', '用户管理', 1, 1, ''),
(2, 'Auth/group', '用户组管理', 1, 1, ''),
(3, 'Auth/rule', '权限设置', 1, 1, ''),
(4, 'Menu/index', '菜单管理', 1, 1, ''),
(5, 'Index/index', '首页', 1, 1, ''),
(38, 'Order/index', '销售订单', 1, 1, ''),
(37, 'Expect/index', '期数列表', 1, 1, ''),
(36, 'service/index', '客服列表', 1, 1, ''),
(35, 'user/userLevel', '会员等级', 1, 1, ''),
(34, 'user/index', '会员列表', 1, 1, ''),
(50, 'Advertisement/index', '广告管理', 1, 1, ''),
(33, 'lottery/odds', '房间赔率', 1, 1, ''),
(32, 'Room/index', '房间列表', 1, 1, ''),
(31, 'lottery/type', '投注类型', 1, 1, ''),
(49, 'payment/index', '支付配置', 1, 1, ''),
(48, 'Setting/index', '系统配置', 1, 1, ''),
(47, 'bill/platform', '平台账户', 1, 1, ''),
(46, 'Robot/index', '机器人管理', 1, 1, ''),
(45, 'bill/transfer', '线下转账', 1, 1, ''),
(44, 'UserLog/index', '登录日志', 1, 1, ''),
(42, 'bill/backwater', '返水记录', 1, 1, ''),
(41, 'Bill/apply', '用户提现', 1, 1, ''),
(40, 'Bill/online', '线上充值', 1, 1, ''),
(30, 'lottery/method', '彩票玩法', 1, 1, ''),
(29, 'Lottery/index', '彩种列表', 1, 1, ''),
(39, 'Order/statistics', '订单统计', 1, 1, ''),
(51, 'Backwater/index', '返水比率规则', 1, 1, ''),
(52, 'Room/level', '房间等级规则', 1, 1, ''),
(53, 'Statistics/userProfit', '在线会员盈亏', 1, 1, ''),
(54, 'Publish/index', '公告管理', 1, 1, ''),
(59, 'agency/index', 'VIP佣金用户列表', 1, 1, ''),
(57, 'agency/clearing', '代理商历史结算列表', 1, 1, ''),
(58, 'agency/chargeoff', '代理商出账列表', 1, 1, ''),
(60, 'Statistics/transfer', '线下转账统计', 1, 1, ''),
(61, 'Statistics/recharge', '线上充值统计', 1, 1, ''),
(62, 'Statistics/platformLoss', '平台总盈亏统计', 1, 1, ''),
(63, 'Statistics/userLoss', '用户盈亏统计', 1, 1, ''),
(64, 'Statistics/currentRecharge', '今日充值统计', 1, 1, ''),
(65, 'Statistics/site', '网站统计', 1, 1, ''),
(66, 'Statistics/wholeUser', '用户统计', 1, 1, ''),
(67, 'user/bill', '用户帐变记录', 1, 1, ''),
(68, 'user/userDeduction', '会员扣款', 1, 1, ''),
(69, 'Service/message', '系统自动回复', 1, 1, ''),
(71, 'user/index2', '会员列表2', 1, 1, ''),
(72, 'index/main', '主页', 1, 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `tp_auxiliary`
--

CREATE TABLE `tp_auxiliary` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '简介',
  `price` int(11) NOT NULL DEFAULT '0' COMMENT '单价',
  `unit` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '单位',
  `cover` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '封面',
  `update_at` datetime NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='辅材';

--
-- 转存表中的数据 `tp_auxiliary`
--

INSERT INTO `tp_auxiliary` (`id`, `title`, `summary`, `price`, `unit`, `cover`, `update_at`, `create_at`, `status`) VALUES
(3, '中国搭大赛11', '啊是的萨达打算', 320, '元', '/uploads/20170424/a22583c7c4a0c848965c1c79b4cc77b7.jpg', '2017-04-24 11:05:03', '2017-04-19 02:35:10', 1),
(4, '中国搭大赛', '啊是的萨达打算', 320, '元', '/uploads/20170419/ec35fb733d85940fbe91fbd0a111f33d.jpg', '2017-04-19 10:51:18', '2017-04-19 02:40:27', 1);

-- --------------------------------------------------------

--
-- 表的结构 `tp_auxiliary_detail`
--

CREATE TABLE `tp_auxiliary_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `a_id` int(10) UNSIGNED NOT NULL COMMENT '辅材表Id',
  `title` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '介绍',
  `cover` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sorted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='辅材详细';

--
-- 转存表中的数据 `tp_auxiliary_detail`
--

INSERT INTO `tp_auxiliary_detail` (`id`, `a_id`, `title`, `summary`, `cover`, `sorted`) VALUES
(2, 4, 'kak', '38', '/uploads/20170419/d9555fac5af3fab0e993032fed665403.jpg', 50),
(3, 4, 'adasd', '1231', '/uploads/20170419/f9fa56494ee44fcefaa275a9d84f1eb2.jpg', 50),
(7, 3, 'sadasd', '', '', 50);

-- --------------------------------------------------------

--
-- 表的结构 `tp_config_img`
--

CREATE TABLE `tp_config_img` (
  `id` int(11) NOT NULL,
  `img_url` varchar(255) NOT NULL COMMENT '图片路径'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_config_img`
--

INSERT INTO `tp_config_img` (`id`, `img_url`) VALUES
(5, '/uploads/images/20170424/8c5389b51bb550a45a04b3f48004d827.png'),
(6, '/uploads/images/20170424/0bac2d882bab5a10d7e3a2fba43c6d74.png');

-- --------------------------------------------------------

--
-- 表的结构 `tp_designer`
--

CREATE TABLE `tp_designer` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL COMMENT '设计师名字',
  `head_img` varchar(255) NOT NULL COMMENT '设计师头像',
  `rank` varchar(20) NOT NULL COMMENT '设计师级别',
  `introduce` text NOT NULL COMMENT '设计师简介',
  `sort` int(11) NOT NULL COMMENT '排序字段',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL COMMENT '更新时间',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_designer`
--

INSERT INTO `tp_designer` (`id`, `name`, `head_img`, `rank`, `introduce`, `sort`, `create_at`, `update_at`, `status`) VALUES
(28, '骐杰', '/uploads/images/20170424/c5e8e9b3f638db18b681657121b1a77b.png', '特级', '高级室内建筑师,从事室内设计十余年,设计项目遍及深圳、上海等国内多个城市,完成设计项目200多个,深得业主和合作伙伴的好评,作品多次在各类杂志及', 0, '2017-04-24 08:19:17', '2017-04-24 16:19:17', 1),
(29, 'Tina', '/uploads/images/20170424/57bf99a6a6591e2e5c6818ea951bec18.png', '高级', '古典欧式、现代欧式、田园乡村、新古典、现代简约设计理念： 设计并非把自我审美情趣和理念强加于人，而应运用我们的专业知识和手段，将您对新居的期待值转化为实际的呈现。', 0, '2017-04-24 08:19:27', '2017-04-24 16:19:27', 1),
(30, '李青', '/uploads/images/20170424/44cfe86dde759e57b404315454946a0a.png', '高级', '拒绝矫揉造作，还理性居所。排斥一成不变，释放居住魅力。纵有千般楼宇，亦能万种雕刻，只做专属定制设计', 0, '2017-04-24 08:19:38', '2017-04-24 16:19:38', 1),
(31, 'Mike', '/uploads/images/20170424/ac940ede2a96e59a8413df3bb5b956c0.png', '高级', '2013年获成都市建筑装饰空间艺术设计大赛金奖 2013年成都市装饰协会评选成都市优秀设计师 2014年获成都市金蓉杯艺术设计大赛优秀作品奖 2015年奥斯卡设计大赛银奖', 0, '2017-04-24 08:19:46', '2017-04-24 16:19:46', 1);

-- --------------------------------------------------------

--
-- 表的结构 `tp_designer_produce`
--

CREATE TABLE `tp_designer_produce` (
  `id` int(11) NOT NULL,
  `designer_id` int(11) NOT NULL COMMENT '设计师id',
  `name` varchar(20) NOT NULL COMMENT '作品名称',
  `introduce` text NOT NULL COMMENT '作品简介',
  `img_url` varchar(255) NOT NULL COMMENT '作品封面',
  `sort` int(11) NOT NULL COMMENT '排序字段',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_at` datetime NOT NULL COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='设计师作品表';

--
-- 转存表中的数据 `tp_designer_produce`
--

INSERT INTO `tp_designer_produce` (`id`, `designer_id`, `name`, `introduce`, `img_url`, `sort`, `create_at`, `update_at`, `status`) VALUES
(14, 28, '河畔新世界-现代简约-170㎡', '本案户型结构完全满足客户一家三代人的居住需求和生活习惯，所以几乎没有做任何调整和修改。装修风格上客户要求简约清爽又不失品质，旅居芬兰两年的经历让他对素雅整洁注重收纳的北欧风有所偏好，刚从东南亚旅游归来又对一点点东南亚木式酒店风有点感', '/uploads/images/20170424/01a24fcb57e9eb57778d6fc8345bd487.png', 0, '2017-04-24 08:21:00', '2017-04-24 16:21:00', 1),
(16, 28, '万科金域蓝湾-美式-178㎡', '设计理念: 对于一套178㎡的户型供一家三口之用，无疑有些奢华，一切都源于女主人对西欧家居陈设和风格要求的严谨需求。空间的打造不可避免…...  通过对新户型动线的贯通，开辟出为女主人提供丰富陈设可能的细部文化空间和很好的收纳空间，对于西欧发挥的奢华空间处理得以淋漓发挥，以素雅的象牙白作为基调，含蓄闲意之美油然而生。  精彩由此展开……', '/uploads/images/20170424/cb668cf729df619316e208ccaf759a4f.png', 0, '2017-04-24 08:24:23', '2017-04-24 16:24:23', 1),
(17, 28, 'sfsfs', 'afafa', '/uploads/images/20170424/b79ce4cd2389e56b8d443e2f01bf26b9.png', 0, '2017-04-24 09:02:42', '2017-04-24 17:02:42', 1),
(18, 28, 'gg', 'gg', '/uploads/images/20170424/269ada1196837e0c3c36259b357c556c.png', 0, '2017-04-24 09:02:52', '2017-04-24 17:02:52', 1);

-- --------------------------------------------------------

--
-- 表的结构 `tp_designer_produce_img`
--

CREATE TABLE `tp_designer_produce_img` (
  `id` int(11) NOT NULL,
  `produce_id` int(11) NOT NULL COMMENT '作品id',
  `img_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tp_designer_produce_img`
--

INSERT INTO `tp_designer_produce_img` (`id`, `produce_id`, `img_url`) VALUES
(36, 14, '/uploads/images/20170424/58f7c8d78c11fa2306b83540df4af48e.png'),
(37, 14, '/uploads/images/20170424/fff5095a43bde69c56089b196b495cba.png'),
(38, 14, '/uploads/images/20170424/57d9162cb34d790dfe20f4e9713c960f.png'),
(42, 16, '/uploads/images/20170424/c4fed9064662a556855ff272971224dd.png'),
(43, 16, '/uploads/images/20170424/c081fc08bdd2321705332e7f24fcdf36.png'),
(44, 16, '/uploads/images/20170424/39bd0d5c69d350cacf6c28e34575ab8b.png'),
(45, 17, '/uploads/images/20170424/6c3d5d2b07d7d558ab547c35cf477b8c.png'),
(46, 17, '/uploads/images/20170424/f572099eb97ac1d09c3a7231cae15fde.png'),
(47, 18, '/uploads/images/20170424/455de6168bd3881750af8f0137b2cd43.png'),
(48, 18, '/uploads/images/20170424/ef841a43d94bde26cca2adfe338b3062.png');

-- --------------------------------------------------------

--
-- 表的结构 `tp_estate`
--

CREATE TABLE `tp_estate` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '楼盘名称',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `sorted` tinyint(1) NOT NULL DEFAULT '10' COMMENT '排序',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='楼盘';

--
-- 转存表中的数据 `tp_estate`
--

INSERT INTO `tp_estate` (`id`, `name`, `status`, `sorted`, `create_at`) VALUES
(5, '春天里', 1, 0, '2017-04-24 03:12:12'),
(6, '保利夜语', 1, 1, '2017-04-24 03:12:31'),
(7, '时代锦绣', 1, 2, '2017-04-24 03:12:47'),
(8, '空港十六区', 1, 3, '2017-04-24 03:13:11'),
(9, '蓝光BRC', 1, 1, '2017-04-24 03:13:27');

-- --------------------------------------------------------

--
-- 表的结构 `tp_layout`
--

CREATE TABLE `tp_layout` (
  `id` int(10) UNSIGNED NOT NULL,
  `estate_id` int(10) UNSIGNED NOT NULL COMMENT '楼盘id',
  `name` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '户型名称',
  `room` tinyint(4) NOT NULL COMMENT '室',
  `hall` tinyint(4) NOT NULL DEFAULT '0' COMMENT '厅',
  `kitchen` tinyint(4) NOT NULL DEFAULT '0' COMMENT '厨',
  `toilet` tinyint(4) NOT NULL DEFAULT '0' COMMENT '卫',
  `balcony` tinyint(4) NOT NULL DEFAULT '0' COMMENT '阳台',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `sorted` tinyint(1) NOT NULL DEFAULT '10',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='户型';

--
-- 转存表中的数据 `tp_layout`
--

INSERT INTO `tp_layout` (`id`, `estate_id`, `name`, `room`, `hall`, `kitchen`, `toilet`, `balcony`, `status`, `sorted`, `create_at`) VALUES
(1, 1, '一室', 1, 0, 0, 0, 0, 0, 10, '2017-04-20 05:20:43'),
(2, 1, '三室二厅，带阳台', 3, 2, 0, 0, 1, 0, 10, '2017-04-20 05:21:01'),
(3, 5, '一室二厅二卫，一厨房，带阳台', 2, 1, 1, 0, 2, 0, 10, '2017-04-24 03:18:37');

-- --------------------------------------------------------

--
-- 表的结构 `tp_layout_attr`
--

CREATE TABLE `tp_layout_attr` (
  `id` int(10) UNSIGNED NOT NULL,
  `layout_id` int(10) UNSIGNED NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '户型名字',
  `wall_area` decimal(6,2) DEFAULT '0.00' COMMENT '墙面面积',
  `floor_area` decimal(6,2) DEFAULT '0.00' COMMENT '地面面积',
  `perimeter` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '周长',
  `top_area` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '顶面面积',
  `total_area` decimal(6,2) NOT NULL DEFAULT '0.00' COMMENT '总面积'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='户型属性';

--
-- 转存表中的数据 `tp_layout_attr`
--

INSERT INTO `tp_layout_attr` (`id`, `layout_id`, `type`, `name`, `wall_area`, `floor_area`, `perimeter`, `top_area`, `total_area`) VALUES
(10, 1, 'room', 'qwe', '1.00', '2.00', '3.00', '1.00', '0.00'),
(14, 2, 'room', 'qwe', '1.00', '1.00', '1.00', '1.00', '0.00'),
(15, 2, 'room', 'qwe', '1.00', '1.00', '1.00', '1.00', '0.00'),
(16, 2, 'room', 'asd', '1.00', '1.00', '1.00', '1.00', '0.00'),
(17, 2, 'hall', 'asd', '1.00', '1.00', '1.00', '1.00', '0.00'),
(18, 2, 'hall', 'asd', '2.00', '2.00', '3.00', '4.00', '0.00'),
(19, 2, 'balcony', 'asd', '1.00', '2.00', '2.00', '4.00', '0.00'),
(28, 3, 'room', '主卧', '18.00', '18.00', '10.00', '18.00', '0.00'),
(29, 3, 'room', '次卧', '12.00', '9.00', '9.00', '9.00', '0.00'),
(30, 3, 'hall', '餐厅', '12.00', '5.00', '8.00', '9.00', '0.00'),
(31, 3, 'kitchen', '厨房', '9.00', '12.00', '8.00', '10.00', '0.00'),
(32, 3, 'balcony', '生活阳台', '6.00', '9.00', '5.00', '8.00', '0.00'),
(33, 3, 'balcony', '观景阳台', '7.00', '8.00', '7.00', '7.00', '0.00');

-- --------------------------------------------------------

--
-- 表的结构 `tp_materials`
--

CREATE TABLE `tp_materials` (
  `id` int(11) NOT NULL,
  `cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类 id',
  `brand_id` int(11) NOT NULL DEFAULT '0' COMMENT '品牌 id',
  `series_id` int(11) NOT NULL DEFAULT '0' COMMENT '品牌系列 id',
  `title` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '摘要',
  `price` int(11) NOT NULL DEFAULT '0' COMMENT '单价',
  `unit` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '单位',
  `cover` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '封面图',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='主材';

-- --------------------------------------------------------

--
-- 表的结构 `tp_materials_brand`
--

CREATE TABLE `tp_materials_brand` (
  `id` int(11) NOT NULL,
  `name` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sorted` tinyint(1) NOT NULL DEFAULT '50' COMMENT '排序值',
  `is_on_home` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示在首页'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='主材品牌';

--
-- 转存表中的数据 `tp_materials_brand`
--

INSERT INTO `tp_materials_brand` (`id`, `name`, `logo`, `sorted`, `is_on_home`) VALUES
(1, 'ddd', '/uploads/20170424/df2e4f39fef86e5b4d3968fd719aab2a.png', 2, 1),
(2, 'aaa', '/uploads/20170424/2a7d9b55618bef4aaf23bb88b3cac30d.png', 2, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tp_materials_cate`
--

CREATE TABLE `tp_materials_cate` (
  `id` int(11) NOT NULL,
  `cate_name` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sorted` tinyint(1) NOT NULL DEFAULT '50' COMMENT '排序值',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='主材类别';

--
-- 转存表中的数据 `tp_materials_cate`
--

INSERT INTO `tp_materials_cate` (`id`, `cate_name`, `sorted`, `status`) VALUES
(1, '瓷砖', 1, 1),
(2, '地板', 2, 1),
(3, '洁具、卫浴五金', 3, 1),
(4, '橱柜', 4, 1),
(5, '门', 5, 1),
(6, '厨卫集成吊顶、照明', 6, 1),
(7, '石材', 7, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tp_materials_cate_brand`
--

CREATE TABLE `tp_materials_cate_brand` (
  `id` int(11) NOT NULL,
  `cate_id` int(11) NOT NULL COMMENT '分类 id',
  `brand_id` int(11) NOT NULL COMMENT '品牌 id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='主材分类、品牌绑定';

--
-- 转存表中的数据 `tp_materials_cate_brand`
--

INSERT INTO `tp_materials_cate_brand` (`id`, `cate_id`, `brand_id`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- 表的结构 `tp_materials_detail`
--

CREATE TABLE `tp_materials_detail` (
  `id` int(11) NOT NULL,
  `m_id` int(11) NOT NULL COMMENT '主表 id',
  `title` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '介绍',
  `cover` varchar(63) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '图片',
  `sorted` tinyint(1) UNSIGNED NOT NULL DEFAULT '50' COMMENT '排序值 0-255'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='主材详情';

-- --------------------------------------------------------

--
-- 表的结构 `tp_materials_series`
--

CREATE TABLE `tp_materials_series` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL COMMENT '品牌 id',
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sorted` tinyint(1) NOT NULL DEFAULT '50'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='主材品牌系列';

-- --------------------------------------------------------

--
-- 表的结构 `tp_site_info`
--

CREATE TABLE `tp_site_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `click_num` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '访问量'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='网站信息';

--
-- 转存表中的数据 `tp_site_info`
--

INSERT INTO `tp_site_info` (`id`, `click_num`) VALUES
(1, 19);

-- --------------------------------------------------------

--
-- 表的结构 `tp_usage_area`
--

CREATE TABLE `tp_usage_area` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '使用区域名字',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `sorted` tinyint(1) NOT NULL DEFAULT '10',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='使用区域';

--
-- 转存表中的数据 `tp_usage_area`
--

INSERT INTO `tp_usage_area` (`id`, `name`, `status`, `sorted`, `create_at`) VALUES
(1, '客厅', 1, 1, '2017-04-19 08:54:32'),
(2, '餐厅', 1, 2, '2017-04-22 09:27:06'),
(3, '厨房', 1, 3, '2017-04-22 09:27:23'),
(4, '卫生间', 1, 4, '2017-04-22 09:27:35'),
(5, '主卫', 1, 5, '2017-04-24 03:17:52'),
(6, '次卫', 1, 6, '2017-04-24 03:18:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tp_admin`
--
ALTER TABLE `tp_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp_auth_group`
--
ALTER TABLE `tp_auth_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp_auth_group_access`
--
ALTER TABLE `tp_auth_group_access`
  ADD UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `tp_auth_rule`
--
ALTER TABLE `tp_auth_rule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `tp_auxiliary`
--
ALTER TABLE `tp_auxiliary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp_auxiliary_detail`
--
ALTER TABLE `tp_auxiliary_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp_config_img`
--
ALTER TABLE `tp_config_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp_designer`
--
ALTER TABLE `tp_designer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp_designer_produce`
--
ALTER TABLE `tp_designer_produce`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp_designer_produce_img`
--
ALTER TABLE `tp_designer_produce_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp_estate`
--
ALTER TABLE `tp_estate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp_layout`
--
ALTER TABLE `tp_layout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp_layout_attr`
--
ALTER TABLE `tp_layout_attr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp_materials`
--
ALTER TABLE `tp_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cate_id` (`cate_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `series_id` (`series_id`);

--
-- Indexes for table `tp_materials_brand`
--
ALTER TABLE `tp_materials_brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp_materials_cate`
--
ALTER TABLE `tp_materials_cate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp_materials_cate_brand`
--
ALTER TABLE `tp_materials_cate_brand`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cate_id` (`cate_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `tp_materials_detail`
--
ALTER TABLE `tp_materials_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `m_id` (`m_id`);

--
-- Indexes for table `tp_materials_series`
--
ALTER TABLE `tp_materials_series`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `tp_site_info`
--
ALTER TABLE `tp_site_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tp_usage_area`
--
ALTER TABLE `tp_usage_area`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `tp_admin`
--
ALTER TABLE `tp_admin`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `tp_auth_group`
--
ALTER TABLE `tp_auth_group`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- 使用表AUTO_INCREMENT `tp_auth_rule`
--
ALTER TABLE `tp_auth_rule`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- 使用表AUTO_INCREMENT `tp_auxiliary`
--
ALTER TABLE `tp_auxiliary`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `tp_auxiliary_detail`
--
ALTER TABLE `tp_auxiliary_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- 使用表AUTO_INCREMENT `tp_config_img`
--
ALTER TABLE `tp_config_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- 使用表AUTO_INCREMENT `tp_designer`
--
ALTER TABLE `tp_designer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- 使用表AUTO_INCREMENT `tp_designer_produce`
--
ALTER TABLE `tp_designer_produce`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- 使用表AUTO_INCREMENT `tp_designer_produce_img`
--
ALTER TABLE `tp_designer_produce_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- 使用表AUTO_INCREMENT `tp_estate`
--
ALTER TABLE `tp_estate`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- 使用表AUTO_INCREMENT `tp_layout`
--
ALTER TABLE `tp_layout`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `tp_layout_attr`
--
ALTER TABLE `tp_layout_attr`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- 使用表AUTO_INCREMENT `tp_materials`
--
ALTER TABLE `tp_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `tp_materials_brand`
--
ALTER TABLE `tp_materials_brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `tp_materials_cate`
--
ALTER TABLE `tp_materials_cate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- 使用表AUTO_INCREMENT `tp_materials_cate_brand`
--
ALTER TABLE `tp_materials_cate_brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `tp_materials_detail`
--
ALTER TABLE `tp_materials_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `tp_materials_series`
--
ALTER TABLE `tp_materials_series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `tp_site_info`
--
ALTER TABLE `tp_site_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `tp_usage_area`
--
ALTER TABLE `tp_usage_area`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
