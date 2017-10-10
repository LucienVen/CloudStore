# API

### Login 登录

**POST** `/auth`

data:

```
{
  phone: 15612341234,
  password: 123456
}
```

response: 

status`200, 422`

```
{
  data: {
    uid: 1,
    phone: 12345678123,
    ....
  }
}
```



### Signup 注册

**POST** `/user`

data: 

```
{
  phone: 1233123123,
  password: 123456
}
```

response:

status`200, 422`

```
{
  data: {
    uid: 1,
    phone: 1231414312,
    ...
  }
}
```

