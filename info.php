<?php
include 'include/init.php';
include 'jssdk.php';
if(!is_numeric($_GET['id'])){
    exit();
}
include_once 'getVideo.php';
$url = $database->get('video_info','frame_url',array('vid'=>$_GET['id']));
$cswanda = new cswanda_crack();
//$test = $cswanda->getVideo('http://api.cswanda.com/mletvip.php?id=23414955&auth_key=1453570077-0-0-93c4fcfed3b0c2c6b98acedd7276b87f&t=24225918','http://fuck.cswanda.com/mletv.php?id=23414955');
$apiUrl = $cswanda->getApiUrl($url);
$vedio = $cswanda->getVideo($apiUrl,$url);
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>流量君</title>
    <meta name="title" content="元旦0元看电影">
    <meta name="keywords" content="电影,流量君电影，微信电影,手机在线观看,院线电影,微信流量君电影,看嘛TV,神马影院,吉吉影音,热播电影,高清播放,微信看电影,电影天堂,最新电影,好莱坞电影">
    <meta name="irCategory" content="电影">
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" id="viewport" name="viewport">
    <meta content="telephone=no" name="format-detection">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta content="流量君电影" name="apple-mobile-web-app-title">
    <link href="css/game1.css" rel="stylesheet" type="text/css">
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
<body style="cursor: default;">
<img data-type="gif" width="100%" src="images/ddd.gif">
<div class="MacPlayer" id="MacPlayer">
    <div id="player2" style="height:100%;margin:0; margin-bottom:1px;padding:0;width: 100%;height: 280px">
        <video id="video2" width="100%" height="100%" autoplay="autoplay" controls autobuffer>
            <source src="<?php echo $vedio?>" type="video/mp4"/>
        </video>
    </div>
</div>
<footer class="footer">
<button onclick="location.reload();" class="button blue" id="reload">切换播放线路</button>
    <?php
        $pid = $database->get('gether_info','pid',array('id'=>$_GET['id']));
        if($pid==0){
            $pid = $_GET['id'];
        }
        if($part = $database->select('gether_info',array('title','id'),array('pid'=>$pid))){
            echo '<ul class="dramaNumList" style="text-align:center;padding:0;">';
            foreach($part as $v){
                echo '<li><a data-episode="8" href="info.php?id='.$v['id'].'" rel="nofollow">'.$v['title'].'</a></li>';
            }
            echo '</ul>';
        }
    ?>
<a href="/" class="button green">电影首页</a>
<br><p>加载需要时间请耐心等待</p>
<div id="advs3" style="display:none">
</div>
</footer>
<p style="text-align:center;padding:0;">电影来自互联网,所有影片仅供测试和学习交流<br>请大家支持正版,如有侵权联系2309822684@qq.com删除</p>

</body></html>