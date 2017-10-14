### Login 登录

**POST** `/auth`

data:

```
{
  "phone": 15612341234,
  "password": 123456
}
```

response: 

```
{
    "id": 1,
    "phone": 12345678123,
    ....
}
```



### Logout 登出

**DELETE** `/auth`

response:

```
"logout success!"
```



### Signup 注册

**POST** `/user`

data: 

```
{
  "phone": 1233123123,
  "password": 123456
  "password_again": 123456
}
```

response: 

```
{
    "id": 1,
    "phone": 1231414312,
    ...
}
```



### Update 修改用户信息

**PATCH** `/user/{id}`

data:

```
{
  "phone": 12312341234,
  "username": "yvenchang",
  "email": "chenyifan.gg@gmail.com"
}
```

response: 

```
{
  "id": 1,
  ...
}
```



### Info 获取用户信息

**GET** `/user[/{id}]`

`/user`为获取全部用户信息，需要管理员权限 ，可选参数：当前页数`page`、每页个数 `offset`

response:

```
// all
{
  "all": 122,
  "page": 1,
  "data": [
    {
      "id": 1,
      ...
    },
    ...
  ]
}
```

```
// one
{
  "id": 1,
  ...
}
```

