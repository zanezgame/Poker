# Poker

Judge | Example
--- | ---
炸弹 | [ K K K K ] + ( A )
五花牛 | [ 10 J Q K K ]
五小牛 | [ A A 2 2 4 ]
牛牛 | [ 2 3 5 ] + ( 4 6 )
牛九 | [ K Q J ] + ( 4 5 )
牛八 | [ 10 1 9 ] + ( 2 6 )
牛七 | [ 1 4 5 ] + ( 3 4 )
牛六 | [ 3 8 9 ] + ( 3 3 )
牛五 | [ 10 J Q ] + ( 9 6 )
牛四 | [ 4 3 3 ] + ( 2 A )
牛三 | [ 9 9 2 ] + ( 5 8 )
牛二 | [ 7 4 9 ] + ( A A )
牛丁 | [ 8 8 4 ] + ( A Q )
没牛 | ( 3 5 7 1 9 )

## C 版本
#### 运行：
```
Welcome to the game:
what pokers ?
("0" for 10, joker not allowed)
```
输入5张牌，输出牌面的结果：
```
2 3 4 5 6
========= BULL =========
10 : [ 2 3 5 ] + ( 4 6 )
...
12345
========= BULL =========
5 : [ A 4 5 ] + ( 2 3 )
...
Jqa13
--------- LOSE ---------
```
#### 输入要求
输入参数间可加 空格 / Tab / 换行
*A* / *J* / *Q* / *K* 不区分大小写
*1* 看做 *A*
*0* 看做 *10*
一次输入超过5个一行以前5个做计算
输入不符要求的字符需重新输入5张牌