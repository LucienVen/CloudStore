### GET方法通用参数

查询起始值`offset`、每页个数 `limit`

### **POST** `/auth` 登录

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

### **DELETE** `/auth` 注销

response:

```
"logout success!"
```

---

### **POST** `/user` 注册

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

### **PATCH** `/user/{id}` 修改用户信息

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

### **GET** `/user` 获取用户信息

response:

```
// one
{
  "id": 1,
  ...
}
```

---

### **GET** `/address` 获取地址信息

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

### **PSOT** `/address` 添加新地址

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

### **PATCH** `/address/{address_id}` 修改地址信息

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

### **DELETE** `/address/{address_id}` 删除地址

response:

```
"Delete Success!"
```

---

### **GET** `/orders[/{order_id}]` 获取订单信息

**route param**: order_id 获取特定订单信息

response:

```json
{
    "id": "3",
    "number": "1201710236553163",
    "type": "1",
    "upload_uid": "2",
    "check_uid": null,
    "total_price": "698.00",
    "discount": "0.00",
    "payment": "1",
    "trade_id": null,
    "payment_status": "0",
    "address_id": "1",
    "express_id": null,
    "express_status": "0",
    "is_delete": "0",
    "create_time": "1508741124",
    "update_time": "1508741124",
    "status": "0",
    "items": [
        {
            "id": "3",
            "order_id": "3",
            "sku_id": "5854051",
            "name": "网易云音乐车载蓝牙播放器",
            "num": "1",
            "price": "99.00"
        },
        {
            "id": "4",
            "order_id": "3",
            "sku_id": "5882053",
            "name": "JBL Reflect Mini BT",
            "num": "1",
            "price": "599.00"
        }
    ]
}
```

---

### **POST** `/orders` 创建订单

data:

```json
{
	"payment": 1,// 支付方法：1-微信、2-支付宝、3-银行卡、4-到付
	"address_id": 1, // 地址 id
	"cart": true, // 是否来自购物车
	"total_price": 698.00, // 总价
	"sku_id": null, // 点击立即购买时，传递此参数
	"num": null, // sku_id的数量
	"discount": 0, // 折扣
	"cart_ids": [{ // 购物车商品 id
		"id": "1"
	},{
		"id": "2"
	}]
}
```

repsonse:

```json
{
    "order_id": "4", // 订单表 id
    "order_number": "1201710235533729", // 订单编号
    "skus": [
        {
            "id": "5",
            "order_id": "4",
            "sku_id": "5854051",
            "name": "网易云音乐车载蓝牙播放器",
            "num": "1",
            "price": "99.00"
        },
        {
            "id": "6",
            "order_id": "4",
            "sku_id": "5882053",
            "name": "JBL Reflect Mini BT",
            "num": "1",
            "price": "599.00"
        }
    ],
    "pay_limit": 1508744618, // 支付时限
    "pay_url": "/qr_code_url" // 第三方 api 地址
}
```

---

### **PATCH** `/orders/{order_id}` 验证

data:

```json
{
    "check_uid": 3
}
```

response

```json
true
```

---

### **delete** `/orders/{order_id}` 删除订单

**params**: canel 0或1 取消或删除

resoponse:

```json
true
```

---

### **PATCH** `/orders/{order_id}/express` 更新快递信息

data:

```json
{
    "express_id": "123445661",
    "express_status": 1
}
```

response:

```json
true
```

---

### **GET** `/orders/{order_id}/payment` 获取支付信息

response:

```json
{
    "id": "4",
    "order_number": "1201710235533729",
    "upload_uid": "2",
    "total_price": "698.00",
    "payment": "1",
    "trade_id": null,
    "payment_status": "0",
    "pay_limit": 1508744618
}
```

---

