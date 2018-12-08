require.config({
    paths: {
        vue: '../vue'
    },
    urlArgs: 'ver=1.0.0'
});

require(['vue'], function(Vue) {
    var bus = new Vue();

    Vue.component('chat-list', {
        props: ['item'],
        template: '<div class="chat-view">\
        <div class="chat-photo" :style="{backgroundImage: \'url(\' + item.photo + \')\'}"></div>\
        <div class="chat-top"><span class="chat-nickname">{{ item.nickname }}({{ item.level }}级)</span>\
            <span class="chat-addtime">{{ item.addtime }}</span><span class="chat-a" v-on:click="altTa(item.nickname)">@Ta</span></div>\
            <div class="chat-content" v-html="item.content"></div><div class="user-explain border-b">{{ item.explain }}</div></div>',
        methods: {
            altTa: function(userid) {
                bus.$emit('altTa', userid);
            }
        }
    });

    Vue.component('chat-send', {
        data: function() {
            return {
                value: '',
                height:'0px',
                face: [
                    { name: "爱你", src: "aini.gif" },
                    { name: "抱抱", src: "baobao.gif" },
                    { name: "不活了", src: "buhuole.gif" },
                    { name: "不要", src: "buyao.gif" },
                    { name: "超人", src: "chaoren.gif" },
                    { name: "大哭", src: "daku.gif" },
                    { name: "嗯嗯", src: "enen.gif" },
                    { name: "发呆", src: "fadai.gif" },
                    { name: "飞呀", src: "feiya.gif" },
                    { name: "奋斗", src: "fendou.gif" },
                    { name: "尴尬", src: "ganga.gif" },
                    { name: "感动", src: "gandong.gif" },
                    { name: "害羞", src: "haixiu.gif" },
                    { name: "嘿咻", src: "heixiu.gif" },
                    { name: "画圈圈", src: "huaquanquan.gif" },
                    { name: "惊吓", src: "jinxia.gif" },
                    { name: "敬礼", src: "jingli.gif" },
                    { name: "快跑", src: "kuaipao.gif" },
                    { name: "路过", src: "luguo.gif" },
                    { name: "抢劫", src: "qiangjie.gif" },
                    { name: "杀气", src: "shaqi.gif" },
                    { name: "上吊", src: "shangdiao.gif" },
                    { name: "调戏", src: "tiaoxi.gif" },
                    { name: "跳舞", src: "tiaowu.gif" },
                    { name: "万岁", src: "wanshui.gif" },
                    { name: "我走了", src: "wozoule.gif" },
                    { name: "喜欢", src: "xihuan.gif" },
                    { name: "吓死人", src: "xiasiren.gif" },
                    { name: "嚣张", src: "xiaozhang.gif" },
                    { name: "疑问", src: "yiwen.gif" },
                    { name: "做操", src: "zuocao.gif" }
                ]
            };
        },
        template: '<div class="chat-input border-t">\
            <div class="chat-input-top">\
                <span class="face" v-on:click="showFaceBox"></span><input type="text" v-model="value"><button v-on:click="send">发送</button>\
            </div>\
            <div class="chat-face-box transition" :style="{height: height}"><div class="face-box">\
                <span v-for="img of face" class="face-out"><img :src="\'/static/images/face/\' + img.src" alt="img" v-on:click="addFacs(img.name)"></span>\
            </div></div>\
        </div>',
        methods: {
            send: function() {
                var _this = this;
                var content = $.trim(this.value);
                if (content.length == 0) {
                    alert('内容不能为空！');
                    return;
                }
                $.post('/Chat/sendMsg?classid=' + data.classid, {'touserid': 0, 'content': content}, function(result) {
                    if (result.err) {
                        alert(result.msg);
                        return;
                    }
                    _this.value = '';
                }, 'json');
            },
            showFaceBox: function() {
                this.height = this.height == '0px' ? $('.face-box').innerHeight() + 'px' : '0px';
                console.log(this.height);
            },
            addFacs: function(img) {
                this.value += '[表情:' + img + ']';
            }
        },
        created: function() {
            var _this = this;
            bus.$on('altTa', function (userid) {
                _this.value = '[@:' + userid + ']' + _this.value;
            });
        }
    });
    var data = {
        my: [],
        list: [],
        user: [],
        classid: $('#app-room').data('classid')
    }
    new Vue({
        el: '#app-room',
        data: data
    });
    function init() {
        $.get('/Chat/fistList', {'classid': data.classid}, function(result) {
            if(result.length > 0) {
                data.list = result;
                data.lastid = result[0].id;
            } else {
                data.lastid = 0;
            }
            update();
        }, 'json');
    }

    var update = function() {
        $.get('/Chat/newList', {'classid': data.classid, 'lastid': data.lastid}, function(result) {
            if (result.length > 0) {
                for (var p in result) {
                    data.list.splice(0, 0, result[p]);
                }
                data.lastid = result[result.length - 1].id;
            }
            console.log('rest.this');
            update();
        }, 'json');
    }
    init();
});
