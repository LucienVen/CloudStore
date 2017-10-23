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
        },
        {
            "id": "6159050",
            "cate_id": "1005000",
            "name": "先锋SEC-S201BT",
            "brand": "先锋",
            "cover_url": "http://p4.music.126.net/S84ikRLX60CKZEqGoQSXYQ==/18768663487959707.jpg",
            "service": "1,3,7",
            "is_hot_sale": "1",
            "is_recommd": "0",
            "is_delete": "0",
            "create_time": "1508128926",
            "update_time": "1508128926",
            "status": "1",
            "price": "0.00"
        },
        {
            "id": "6173054",
            "cate_id": "1005000",
            "name": "AKG K374U",
            "brand": "AKG",
            "cover_url": "http://p4.music.126.net/lbMuCR3ouNG892qeILWyPg==/19056735532653788.jpg",
            "service": "1,3,7",
            "is_hot_sale": "1",
            "is_recommd": "0",
            "is_delete": "0",
            "create_time": "1508128917",
            "update_time": "1508128917",
            "status": "1",
            "price": "0.00"
        },
        {
            "id": "6178051",
            "cate_id": "1005000",
            "name": "魔声 Diamondz",
            "brand": "魔声",
            "cover_url": "http://p4.music.126.net/GtY3a1ZPEQc8Db9gKkZ0gQ==/18511377767072088.jpg",
            "service": "1,3,7",
            "is_hot_sale": "1",
            "is_recommd": "0",
            "is_delete": "0",
            "create_time": "1508128925",
            "update_time": "1508128925",
            "status": "1",
            "price": "0.00"
        },
        {
            "id": "6483074",
            "cate_id": "1005000",
            "name": "森海塞尔cx2.00",
            "brand": "森海塞尔",
            "cover_url": "http://p3.music.126.net/4jsEhPMMwWfOoANxkXk3EQ==/109951162969431859.jpg",
            "service": "1,3,8,12",
            "is_hot_sale": "1",
            "is_recommd": "0",
            "is_delete": "0",
            "create_time": "1508128920",
            "update_time": "1508128920",
            "status": "1",
            "price": "369.00"
        },
        {
            "id": "6538071",
            "cate_id": "1005000",
            "name": "漫步者（EDIFIER）W675BT 头戴式无线蓝牙音乐耳机",
            "brand": "漫步者（EDIFIER）",
            "cover_url": "http://p3.music.126.net/J1CGOOBZGdhFcrkCjf0fHg==/109951162995562544.jpg",
            "service": "8,12",
            "is_hot_sale": "1",
            "is_recommd": "0",
            "is_delete": "0",
            "create_time": "1508128923",
            "update_time": "1508128923",
            "status": "1",
            "price": "279.00"
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
        },
        {
            "type": "2",
            "value": "http://p4.music.126.net/6fg1QC9_GC6mPjM89l3Xiw==/3445869445042607.jpg"
        },
        {
            "type": "2",
            "value": "http://p4.music.126.net/PPiQFRHK5tNSwiZ31pYG-w==/3437073352020694.jpg"
        },
        {
            "type": "2",
            "value": "http://p4.music.126.net/HDaTzTJ0VyTv4LH6VhUGBg==/2946691177412025.jpg"
        },
        {
            "type": "2",
            "value": "http://p3.music.126.net/rPpSyElFcaOtMSWsXoeg1g==/1416170988550966.jpg"
        },
        {
            "type": "1",
            "value": "商品交易成功后会在2个工作日内发货，法定节假日顺延，请在确认商品完好后再签收。"
        },
        {
            "type": "1",
            "value": "若存在质量问题，请务必在三包规定时间内联系客服"
        },
        {
            "type": "1",
            "value": "•客服账号：向【云音乐客服】账号私信反馈"
        },
        {
            "type": "1",
            "value": "温馨提示：完整的产品本身、包装和三包凭证是电子产品进行保修的基础，请务必查看齐全后签收并妥善保管；"
        },
        {
            "type": "1",
            "value": "注意事项：若您有发票需求，请在下单后五分钟之内私信“云音乐客服”并留言：发票抬头、订单号、您的姓名以及联系方式。（一律为普通发票，含发票的订单会在4个工作日内随货发出）若在发货后提出发票需求，发票单独寄出且运费需由用户自行承担。"
        },
        {
            "type": "1",
            "value": "<br>"
        },
        {
            "type": "1",
            "value": "<span style=\"font-weight:bold;\">网易云音乐车载蓝牙播放器售后服务承诺：</span> "
        },
        {
            "type": "1",
            "value": "<span style=\"font-weight:bold;\">如何申请退换货？</span> "
        },
        {
            "type": "1",
            "value": "1.\t自收到商品签收之日起30日内，用户可申请无理由退换货，我们承诺30天包邮退换，退款将原路返还，不同的银行处理时间不同，预计1-5个工作日到账；"
        },
        {
            "type": "1",
            "value": "<br>"
        },
        {
            "type": "1",
            "value": "<span style=\"font-weight:bold;\">退换货及维修说明：</span>"
        },
        {
            "type": "1",
            "value": "1.\t为了维护用户的体验和权益，网易云音乐车载蓝牙播放器在退换时应当保证产品完好、配件齐全，且不影响二次销售。遭人为破坏或污损的商品不提供30天无理由退换货服务，敬请谅解。"
        },
        {
            "type": "1",
            "value": "影响二次销售的情况，包括但不仅限于以下："
        },
        {
            "type": "1",
            "value": "1)\t产品配件不齐全或包装不完整的；"
        },
        {
            "type": "1",
            "value": "2)\t人为原因，导致设备故障及损坏的；"
        },
        {
            "type": "1",
            "value": "3)\t造成产品或配件磨损或刮花的，包括产品上标明的型号、序列号、验证码等，被更改、删除、移动或不可辨认的；"
        },
        {
            "type": "1",
            "value": "4)\t 其他非本公司原因造成损害的。"
        },
        {
            "type": "1",
            "value": "2.\t退货注意事项："
        },
        {
            "type": "1",
            "value": "1)\t如有发票或赠品，退货时需寄回，换货无需寄回；"
        },
        {
            "type": "1",
            "value": "2)\t发票、保修卡、检测报告等凭证不能进行涂改；"
        },
        {
            "type": "1",
            "value": "3)\t商品的完整标配指原厂包装内的所有配件；"
        },
        {
            "type": "1",
            "value": "4)\t完整原厂包装指商品出厂时的包装，包括彩印纸盒和纸盒里的内胆包装。建议外包装在收货之日起保留30天；"
        },
        {
            "type": "1",
            "value": "5)\t赠品是指价格为零的赠送商品，退货必须保证包装完好，不影响二次使用；"
        },
        {
            "type": "1",
            "value": "6)\t请您支付寄回的快递费（到付件一律拒收），若质检后为产品性能问题，网易云音乐会报销寄回的快递费（最高22元），请将快递发票随货寄出（无发票不报销）。"
        },
        {
            "type": "1",
            "value": "3、网易云音乐车载蓝牙播放器在三包期内出现《车载蓝牙播放器商品性能故障表》所列性能故障的情况，经厂商检测确定后，凭三包凭证可享受免费维修服务。"
        },
        {
            "type": "1",
            "value": "<br>"
        },
        {
            "type": "1",
            "value": "免责条款："
        },
        {
            "type": "1",
            "value": "1.\t网易云音乐积分商城提供的图片，由于拍摄灯光变化及显示器色差等原因可能与实物有细微区别，效果演示图和示意图仅供参考（图片为合成图、模拟演示图），有关产品的外观（包括但不限于颜色）请以实物为准。"
        },
        {
            "type": "1",
            "value": "2.\t限于篇幅，网易云音乐积分商城所包含的信息（包括但不限于产品规格、功能说明等）可能不完整，请以有关产品使用说明书的具体信息为准。"
        },
        {
            "type": "1",
            "value": "3.\t最终解释权归网易云音乐所有。"
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
        },
        {
            "id": "5854052",
            "spu_id": "5853054",
            "price": "99.00",
            "stock": "585",
            "sold": "17957",
            "original_price": "119.00",
            "is_delete": "0",
            "create_time": null,
            "update_time": null,
            "status": "1",
            "attr": [
                {
                    "id": "71",
                    "sku_id": "5854052",
                    "attr": "颜色",
                    "opt": "炫酷黑"
                }
            ]
        }
    ]
}
```

---

