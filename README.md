**POST** `/auth` 登录

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

---

**DELETE** `/auth` 注销

response:

```
"logout success!"
```

---

**POST** `/user` 注册

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

---

**PATCH** `/user/{id}` 修改用户信息

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

---

**GET** `/user` 获取用户信息

可选参数：当前页数`page`、每页个数 `offset`

response:

```
// one
{
  "id": 1,
  ...
}
```

---

**GET** `/address` 获取地址信息

response:

````
{
  "all": 3,
  "data": [
    "id": 1
    ...
  ]
}
````

---

**PSOT** `/address` 添加新地址

data:

```
{
  "name": "姓名",
  "address": "地址",
  "phone": "联系电话"
}
```

response:

```
{
  "id": 3,
  ...
}
```

---

**PATCH** `/address/{address_id}` 修改地址信息

data:

```
{
  "name": "姓名",
  ...
}
```

response:

```
{
  "id": 3
  ...
}
```

---

**DELETE** `/address/{address_id}` 删除地址

response:

```
"Delete Success!"
```

