# sixty-pai
##说明
本项目是sixty'den博客的api（yii版本），由于本人是前端，并且从来没用过yii，所以可能存在很多不规范和不对的地方，
请不要参照里面的代码用于业务。如果有神建议或者问题可以去[Sixty](www.sixtyden.com)留言哦。

### 部分说明
    1.我一不留意就把业务代码写在了model层
    2.我尽量在后端少做事情，我一般放到前端处理（因为我是前端，哈哈^_^）
    3.由于对yii不太熟，取数据用例Query对象，改数据又重新New了AR对象。。。
    4.图片是接的七牛云
    5.登录用的微博第三方

### 新浪微信登录
    因为前端不想用新浪的JS SDK，然后就在前端直接请求微博接口，结果导致了跨域。因为不想用微博自带的那个按钮，还有一些标签，
    我就在后端转一下接口。使用的是[guzzle](http://guzzle-cn.readthedocs.io/zh_CN/latest/quickstart.html)
    
    
        