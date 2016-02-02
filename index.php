<?php
include 'include/init.php';
include 'jssdk.php';
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>流量君电影</title>
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" id="viewport" name="viewport">
    <meta content="流量君,流量君电影|微信电影,值得信任的安全电影,最新免费电影,热播剧,热门综艺,喜剧片" name="Description">
    <meta content="流量君电影|我的少女时代,夏洛特烦恼,北京时间,坏蛋必须死" name="Keywords">
    <meta content="telephone=no" name="format-detection">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="Cache-Control" content="no-transform">
    <link href="css/global.css" rel="stylesheet" type="text/css">
    <link href="css/index_v2.css" rel="stylesheet" type="text/css">
    <script src="js/jquery-2.2.0.min.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <?php
    $jssdk = new JSSDK(APPID,SECRET);
    $jsbag = $jssdk->getSignPackage();
    ?>
    <script type="text/javascript">
        wx.config({"debug":false,
            "beta":false,
            "appId":"<?php echo $jsbag['appId']?>",
            "nonceStr":"<?php echo $jsbag['nonceStr']?>",
            "timestamp":<?php echo $jsbag['timestamp']?>,
            "url":"<?php echo $jsbag['url']?>",
            "signature":"<?php echo $jsbag['signature']?>",
            "jsApiList":["onMenuShareTimeline","onMenuShareAppMessage"]});
        wx.ready(function(){
            wx.onMenuShareTimeline(setShare());
            //“分享给朋友”按钮点击状态及自定义分享内容接口
            wx.onMenuShareAppMessage(setShare());
        });
        function setShare(){
            return {
                title: '为了感谢没屏蔽我的朋友们', // 分享标题
                desc: '我看了这个电影觉得很不错，推荐给你', // 分享描述
                link: '<?php echo $jsbag['url']?>', // 分享链接
                imgUrl: 'http://dingyuehao.lyiptv.com.cn/images/share_log.jpg', // 分享图标
                type: 'link', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    // 用户确认分享后执行的回调函数
                }, cancel: function () {}
            }
        }
    </script>
</head>
<body>
<img data-type='gif' width='100%' src='images/ddd.gif'/>
<div class="mod_a globalPadding">
    <div class="th_a"><span class="sMark"><i class="iPoint"></i>推荐电影</span>
        <a href="">流量君祝大家开心每一天!</a>
    </div>
    <div class="tb_a">
        <ul class="picTxt picTxtA clearfix">
            <?php
                $list = $database->select('gether_info',array('id','title','cover','part','category','add_time'),array('AND'=>array('is_read'=>1,'pid'=>0),'ORDER'=>'id DESC'));
                foreach($list as $value){?>
            <li>
                <div class="con">
                    <a href="./info.php?id=<?php echo $value['id']?>" target="_self">
                        <img height="135" src="<?php echo $value['cover']?>" alt="" />
                        <span class="sNum"><?php echo $value['part']?><em class="emHot"><?php echo $value['category']?></em></span>
                        <span class="sTit"><?php echo $value['title']?></span>
                        <span class="sDes">更新：<?php echo date('Y-m-d',$value['add_time']);  ?></span>
                    </a>
                </div>
            </li>
            <?php }?>
         </ul>
        </div>
    </div>
</body>
</html>