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
        <div class="chat-top"><span class="chat-nickname">{{ item.nickname }}</span>\
            <span class="chat-addtime">{{ item.addtime }}</span><span class="chat-a" v-on:click="altTa(item.nickname)">@Ta</span></div>\
            <div class="chat-content" v-html="item.content"></div></div>',
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
                face: ["爱你","抱抱","不活了","不要","超人","大哭","嗯嗯","发呆","飞呀","奋斗",
                "尴尬","感动","害羞","感动","嘿咻","画圈圈","惊吓","敬礼","快跑","路过","抢劫",
                "杀气","上吊","调戏","跳舞","万岁","我走了","喜欢","吓死人","嚣张","疑问","做操"]
            };
        },
        template: '<div class="chat-input border-t">\
            <div class="chat-input-top">\
                <span class="face" v-on:click="showFaceBox"></span><input type="text" v-model="value"><button v-on:click="send">发送</button>\
            </div>\
            <div class="chat-face-box transition" :style="{height: height}"><div class="face-box">\
                <span v-for="img of face" class="face-out"><img :src="\'/static/images/face/\' + img + \'.gif\'" alt="img" v-on:click="addFacs(img)"></span>\
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
        list: [{
            'userid':1,
            'content': '你好',
            'addtime': new Date()
        }],
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
                data.lastid = result[result.length - 1].id;
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
