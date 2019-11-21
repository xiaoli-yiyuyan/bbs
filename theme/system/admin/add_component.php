<?php self::load('common/header',['title' => '后台管理']); ?>
<?php self::load('admin/header_nav'); ?>
<link href=/static/admintemplate/css/app.721040b44651a744dc3b340b3d127c19.css rel=stylesheet>

<div class="content">
    
<div class="namespace"><a href="/admin/page/">根分类</a> /
    <div class="nav_title">编辑组件</div>
</div>
<div id=app></div>
    <script type=text/javascript src=/static/admintemplate/js/manifest.3ad1d5771e9b13dbdad2.js></script>
    <script type=text/javascript src=/static/admintemplate/js/vendor.6c70df58022e2fec1939.js></script>
    <script type=text/javascript src=/static/admintemplate/js/app.8b8a1b0e9ceeace28296.js></script>
</div>
<?php self::load('common/footer_nav'); ?>
<script>
function GetUrlParms() {
    var args = new Object(); 
    var query = location.href.split('?')[1];//获取查询串 
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

var trim = function (str, char) {
    return str.replace(new RegExp('^\\'+char+'+|\\'+char+'+$', 'g'), '');
};
 

var namespace = GetUrlParms()['namespace'];
namespace = trim(namespace, '/');
if (namespace) {
    var namespace_index = namespace.split('/');

    var namespace_path = '';
    for (var p in namespace_index) {
        namespace_path += '/' + namespace_index[p];
        $('.nav_title').before('<a href="/admin/page/?namespace=' + namespace_path + '">' + namespace_index[p] + '</a> / ');

    }
}
</script>
<?php self::load('common/footer'); ?>
