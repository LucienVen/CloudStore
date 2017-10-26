## GET方法通用参数

查询起始值`offset`、每页个数 `limit`

## `/user    /auth`

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

## `/address`

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

## `/orders`

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

**params**:**(option)** `canel=0,1` 取消或删除

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

## `/product`

### **GET** `/product` 获取产品信息

**params**: **(must)**`type:hot,suggest` 获取热门商品、推荐商品

response:

```json
{
    "type": "hot",
    "offset": 0,
    "limit": 10,
    "total": 6,
    "products": [
        {
            "id": "5952052",
            "cate_id": "1005000",
            "name": "先锋SEC-CL31S",
            "brand": "先锋",
            "cover_url": "http://p3.music.126.net/MAqISVPRc5tYIdpyDWZMSQ==/18555358232018793.jpg",
            "service": "1,3,7",
            "is_hot_sale": "1",
            "is_recommd": "0",
            "is_delete": "0",
            "create_time": "1508128918",
            "update_time": "1508128918",
            "status": "1",
            "price": "59.00"
        }
    ]
}
```

---

### **GET** `/product/{spu_id}` 获取商品详情

response:

```json
{
    "id": "5853054",
    "cate_id": "1006000",
    "name": "网易云音乐车载蓝牙播放器",
    "brand": "网易",
    "cover_url": "http://p3.music.126.net/BJVuKw-_CgkO477YABv1yw==/18665309394712674.jpg",
    "service": "1,3,7",
    "is_hot_sale": "0",
    "is_recommd": "0",
    "is_delete": "0",
    "create_time": "1508128914",
    "update_time": "1508128914",
    "status": "1",
    "desc": [
        {
            "type": "2",
            "value": "http://p3.music.126.net/DCd8gB-duSE82EypwiZQHw==/3426078240234880.jpg"
        }
    ],
    "skus": [
        {
            "id": "5854051",
            "spu_id": "5853054",
            "price": "99.00",
            "stock": "295",
            "sold": "8906",
            "original_price": "119.00",
            "is_delete": "0",
            "create_time": null,
            "update_time": null,
            "status": "1",
            "attr": [
                {
                    "id": "70",
                    "sku_id": "5854051",
                    "attr": "颜色",
                    "opt": "网易红"
                }
            ]
        }
    ]
}
```

---

### **POST** `/product/sku/{spu_id}` 添加 sku 信息

data:

```json
{
  'price': 123.00,
  'original_price': 233.00,
  'stock': 123,
  'attribute': {
    'attr': 'color',
    'opt': 'red'
}
```

response:

```json
{
  "id": "5854051",
  "spu_id": "5853054",
  "price": "99.00",
  "stock": "295",
  "sold": "8906",
  "original_price": "119.00",
  "is_delete": "0",
  "create_time": null,
  "update_time": null,
  "status": "1",
  "attribute": [
    {
      "id": "70",
      "sku_id": "5854051",
      "attr": "颜色",
      "opt": "网易红"
    }
  ]
}
```

---

### **PATH** `/product/sku/{sku_id}` 修改 sku 信息

---

### **DELETE** `/product/sku/{sku_id}` 删除 sku 信息

---

### **GET** `/product/sku/{sku_id}` 搜索 sku 信息

response:

```json
[
    {
        "id": "141",
        "sku_id": "9976088",
        "attr": "操作系统",
        "opt": "安卓版"
    },
    {
        "id": "142",
        "sku_id": "9976088",
        "attr": "颜色",
        "opt": "黑色"
    }
]
```

---

### **POST** `/product` 添加 SPU 信息

data:

```json
{
    'cate_id': 101000,
    'name': "test",
    'brand': "test",
    'show_price': 12,00,
    'service': "1,2,3",
    'desc': [
        "value": ""
    ],
    'sku': [{
        'price': 123.00,
        'original_price': 233.00,
        'stock': 123,
        'attribute': {
            'attr': 'color',
            'opt': 'red'
        }
    }]
}
```

response:

```json
{'spu_id': 123123}
```

----

### **PATCH** `/product/spu/{spu_id}` 修改 spu 信息

---

### **DELETE** `/product/spu/{spu_id}` 删除 spu 信息

---

### **GET** `/product/search` 获取搜索选项信息

**param**: **(must)** `cateId1` 一级分类id

response:

```json
{
    "brand": [
        "1MORE",
        "AKG",
        "Beats",
        "in-voice"
    ],
    "cate": [
        {
            "id": "1005000",
            "name": "耳机耳麦"
        },
        {
            "id": "1006000",
            "name": "播放器"
        },
        {
            "id": "1007000",
            "name": "数码配件"
        },
        {
            "id": "1009006",
            "name": "音箱音响"
        }
    ],
    "price": [
        {
            "begin": 0,
            "end": 1666
        },
        {
            "begin": 1667,
            "end": 3332
        },
        {
            "begin": 3333,
            "end": 4998
        }
    ]
}
```

---

### **POST** `/product/search` 获取搜索商品信息

data:

```json
{
	"limit": 10,
	"offset": 0,
	"cateId1": 101000,
	"orderBy": "DESC"
}
```

response:

```json
{
    "offset": 0,
    "limit": 10,
    "total": 100,
    "products": [
        {
            "id": "6452052",
            "cate_id": "1005000",
            "name": "Beats Pro 录音师专业版 头戴式耳机",
            "brand": "Beats",
            "cover_url": "http://p4.music.126.net/8AzE5wrKMBvbjBBlU_tgDw==/18513576790470528.jpg",
            "show_price": "2288.00",
            "total_sold": "20",
            "service": "8,12",
            "is_hot_sale": "0",
            "is_recommd": "1",
            "is_delete": "0",
            "create_time": "1508128917",
            "update_time": "1508128917",
            "status": "1",
            "price": "2288.00"
        }
    ]
}
```

---

## `/cart`

### **GET** `/cart` 获取购物车信息

response:

```json
{
    "num": 3,
    "freight": 0,
    "total_price": 757,
    "product": [
        {
            "cate_id": "1006000",
            "brand": "网易",
            "cover_url": "http://p3.music.126.net/BJVuKw-_CgkO477YABv1yw==/18665309394712674.jpg",
            "id": "1",
            "uid": "2",
            "sku_id": "5854051",
            "name": "网易云音乐车载蓝牙播放器",
            "num": "1",
            "price": "99.00",
            "is_delete": "0",
            "create_time": null,
            "update_time": null,
            "status": "1",
            "attr": [
                {
                    "id": "70",
                    "attr": "颜色",
                    "opt": "网易红"
                }
            ]
        }
    ]
}
```

---

### **POST** `/cart` 添加商品到购物车

data:

```json
{
	"sku_id": 5959050,
	"name": "先锋SEC-CL31S",
	"price": 59.00,
	"num": 1
}
```

response:

```json
true
```

---

### **PATCH** `/cart` 修改购物车商品信息

data:

```json
{
	"cart_id": 2,
	"num": 1
}
```

respose: 与 **GET**方法相同

---

### **DELETE** `/cart/{cart_id}` 删除购物车中的商品

response: 与**GET**方法相同

---

## `/media`

### **POST** `/media/desc` SPU 详情信息图片上传

---

