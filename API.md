用户接口
1、登录
    methods: GET
    api:\login\login
    参数: {
        username: string,
        password: string
    }
2、注册
    method: POST
    api: \login\register
    参数：{
        username,
        password,
        password2,
        email
    }