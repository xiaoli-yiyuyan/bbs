<?php $this->load('components/common/header',['title' => '用户中心']); ?>
<?php $this->load('/components/common/header_nav', ['back_url' => '/index', 'title' => '首页']); ?>

<div class="user-info border-b">
    <img class="user-photo photo" src="<?=$userinfo['photo']?>" alt="">
    <div class="info-box">
        <div class="user-nc">
            <span><?=$userinfo['nickname']?> <span class="vip_icon vip_0">vip <?=$userinfo['vip_level']?></span><span class="user_lv">lv.<?=$userinfo['level']?></span></span>
            <?php if ($user['id'] != 0 && $user['id'] != $userinfo['id']) { ?>
            <?php if ($is_care) { ?>
            <span class="care_btn">
                <!-- <span class="care_str">已关注</span> -->
                <button data-id="<?=$userinfo['id']?>" class="btn btn-shadow btn-sm btn_care">已关注</button>
            </span>
            <?php } else { ?>
            <span class="care_btn">
                <!-- <span class="care_str">未关注</span> -->
                <button data-id="<?=$userinfo['id']?>" class="btn btn-shadow btn-fill btn-sm btn_care">关注</button>
            </span>
            <?php } ?>
            <?php } ?>
        </div>
        <div class="user-ep"><?=$userinfo['explain']?></div>
    </div>
</div>
<div class="tab ">
    <div class="tab-header">
        <div class="tab-link tab-active" data-to-tab=".tab1">帖子(<?=$list['page']['count']?>)</div>
        <div class="tab-link" data-to-tab=".tab2">动态(<?=$reply_list['page']['count']?>)</div>
    </div>
    <div class="tab-content">
            <div class="tab-page tab1 tab-active">
            <?php $this->load('/components/forum/list', ['list' => $list]); ?>

            </div>
            <div class="tab-page tab2">
            <?php $this->load('/components/forum/reply_list', ['list' => $reply_list]); ?>

            </div>
    </div>
</div>

<script type="text/javascript">
    $('.bbs_article').click(function() {
        var id = $(this).data('id');
        if (id) {
            location.href = '/forum/view/?id=' + id;
        }
        return false;
    });

    $('.bbs_reply').click(function() {
        var id = $(this).data('forum-id');
        if (id) {
            location.href = '/forum/view/?id=' + id;
        }
        return false;
    });
    var care_time = $.now() - 1000 * 5;
    $('.btn_care').click(function() {
        var $this = $(this);
        var diff_time = 5 - Math.ceil(($.now() - care_time) / 1000);
        if (diff_time > 0) {
            return $.alert('请再等 ' + diff_time + ' 秒后操作');
        }
        care_time = $.now();
        $.getJSON('/user/ajax_care', {id: $this.data('id')}).then(function(data) {
            if (data.err) {
                return $.alert(data.msg);
            }
            $.msg(data.msg);
            if (data.is_care) {
                $this.removeClass('btn-fill').text('已关注');
            } else {
                $this.addClass('btn-fill').text('关注');
            }
        });
    });
    function urlParse(url) {
        var args = new Object(); 
        var query = url.split('?')[1];//获取查询串 
        var pairs = query.split("&");//在逗号处断开 
        for(var i = 0; i < pairs.length; i ++) { 
            var pos = pairs[i].indexOf('=');//查找name=value 
            if (pos == -1) continue;//如果没有找到就跳过 
            var argname = pairs[i].substring(0, pos);//提取name 
            var value = pairs[i].substring(pos + 1);//提取value 
            args[argname] = unescape(value);//存为属性 
        }
        return args;
    }

    function urlWrite(params) {
        var url = [];
        for (var p in params) {
            url.push(p + '=' + params[p]);
        }
        return url.join('&');
    }

    $('.tab-link[data-to-tab=".tab1"]').click(function() {
        $('.bbs_page_jump').each(function() {
            var href = $(this).attr('href');
            if (!href || href == '#') {
                return;
            }
            href = urlParse(href);
            href['tab'] = '1';
            $(this).attr('href', '?' + urlWrite(href));
        });
    });

    $('.tab-link[data-to-tab=".tab2"]').click(function() {
        $('.bbs_page_jump').each(function() {
            var href = $(this).attr('href');
            if (!href || href == '#') {
                return;
            }
            href = urlParse(href);
            href['tab'] = '2';
            $(this).attr('href', '?' + urlWrite(href));
        });
    });
    
    $(function() {
        var params = urlParse(location.href);
        if (params['tab'] == '1') {
            $('div[data-to-tab=".tab1"]').click();
        }
        if (params['tab'] == '2') {
            $('div[data-to-tab=".tab2"]').click();
        }
    });
</script>
<?php $this->load('components/common/footer'); ?>
