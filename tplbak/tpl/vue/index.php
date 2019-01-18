<?php self::load('common/header',['title' => 'Vue']); ?>
<script src="/static/js/vue.js"></script>
<script src="/static/js/vue-router.js"></script>
<script type="text/javascript">

</script>
<div id="main">
    <top-nav></top-nav>
    <router-view></router-view>

    <bottom-nav></bottom-nav>
</div>
<script type="text/javascript">

    var data = {
        stores: [
            {id:1, name: '铁', count: 0, price: 125, inputShow: false},
            {id:2, name: '铜', count: 100, price: 500, inputShow: false},
            {id:3, name: '银', count: 0, price: 2000, inputShow: false},
            {id:4, name: '金', count: 0, price: 8000, inputShow: false},
            {id:5, name: '钻', count: 0, price: 32000, inputShow: false},
        ],
        mines: [
            {id:1, name: '铁矿区', level: 1, lostTime: 125, inputShow: false},
            {id:2, name: '铜矿区', level: 2, lostTime: 500, inputShow: false},
            {id:3, name: '银矿区', level: 3, lostTime: 2000, inputShow: false},
            {id:4, name: '金矿区', level: 4, lostTime: 8000, inputShow: false},
            {id:5, name: '钻矿区', level: 5, lostTime: 3200, inputShow: false},
        ],
        shopList: [1, 2, 4, 8, 16]

    }

    Vue.component('top-nav', {
        data: function() {
            return data;
        },
        template: '<div><div>我的金币:(0) 市场</div>\
        <div><router-link to="/mystore">我的资产</router-link>:\
        <span v-for="item of stores">{{ item.name }}({{ item.count }}) </span>\
        </div>\
        <div><router-link to="/myequip">武器</router-link>:木镐[升级] 耐久:120</div>\
        <div><router-link to="/myrobot">机器人</router-link>:自动挖掘机器人[补充](25000)</div>\
        <div><router-link to="/minelist">矿区</router-link>: 等级 1级[升级](4*4)</div></div>'
    });

    Vue.component('bottom-nav', {
        template: '<a>bottom-nav</a>'
    });


    Vue.component('my-store', {
        template: '<div><div>我的资产</div>\
        <store-list v-for="store of stores" v-bind:store="store"></store-list>\
        </div>',
        data: function() {
            return data;
        },
        components: {
            'store-list': {
                props: ['store'],
                template: '<div>{{ store.name }}({{ store.count }}) <input style="width:60px;" v-show="store.inputShow" /><span v-on:click="storeSell(store)">出售[{{ store.price }}/个]</span></div>',
                methods: {
                    storeSell: function(data) {
                        data.inputShow = !data.inputShow;
                        console.log(data);
                    }
                }
            }
        }
    });

    Vue.component('my-equip', {
        template: '<div><div>===我的武器===</div>\
        <div>名称：木镐</div>\
        <div>等级：1级(升级)</div>\
        <div>耐久：120/120</div>\
        <div>--技能--</div>\
        <div>挖到铁矿的几率提升1%</div>\
        </div>'
    });

    Vue.component('my-mine', {
        template: '<div>\
            <div class="my-mine">共有{{mines.length}}个矿区 [<a href="#/mineshop">购买</a>]</div>\
            <ul>\
            	<mine-list v-for="mine of mines" v-bind:mine="mine"></mine-list>\
            </ul>\
        </div>',
        data: function() {
            return data;
        },
        components: {
            'mine-list': {
                props: ['mine'],
                template: '<li>\
            		<span class="mine-name">{{mine.name}}</span>\
            		<span class="mine-level">(LV.{{mine.level}})</span>\
            		<span class="mine-lost" v-if="mine.lostTime > 0">{{mine.lostTime}}</span>\
            		<span class="mine-lost" v-else>可采集</span>\
            	</li>'
            }
        },
        methods: {
        },
        mounted: function() {
        }
    });

    Vue.component('my-robot', {
        template: '<div><div>===我的挖掘机器人===</div>\
        <div>名称：低级机器人[升级]</div>\
        <div>耐久：120/120</div>\
        <div>--技能--</div>\
        <div>挖到铁矿的几率提升1%</div></div>'
    });

    Vue.component('mine-shop', {
        data: function() {
            return data;
        },
        template: '<div><div v-for="item of shopList">矿区 * {{ item }} [购买 {{ item * 1000 }}]</div></div>'
    });

        const Foo = { template: '<div>foo</div>' }
        const Bar = { template: '<div>bar</div>' }

        // 2. 定义路由
        // 每个路由应该映射一个组件。 其中"component" 可以是
        // 通过 Vue.extend() 创建的组件构造器，
        // 或者，只是一个组件配置对象。
        // 我们晚点再讨论嵌套路由。
        const routes = [
          { path: '/mystore', component: Vue.component('my-store') },
          { path: '/myrobot', component: Vue.component('my-robot') },
          { path: '/myequip', component: Vue.component('my-equip') },
          { path: '/myrobot', component: Vue.component('my-robot') },
          { path: '/minelist', component: Vue.component('my-mine') },
          { path: '/mineshop', component: Vue.component('mine-shop') },
        ]

        // 3. 创建 router 实例，然后传 `routes` 配置
        // 你还可以传别的配置参数, 不过先这么简单着吧。
        const router = new VueRouter({
          routes // （缩写）相当于 routes: routes
        })

    var vm = new Vue({
        el: '#main',
        data: {
            currentView: 'my-mine'
        },
        methods: {
        },
        router
    }).$mount('#main');

    var updateTime = function() {
        for (var item in data.mines) {
            if(data.mines[item].lostTime > 0) {
                Vue.set(data.mines[item], 'lostTime', data.mines[item].lostTime - 1);
            }
        }
        setTimeout(updateTime,1000);
    }
    updateTime();
</script>
<?php self::load('common/footer'); ?>
