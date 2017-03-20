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

输入仅识别数字和 *a* / *j* / *q* / *k* / *A* / *J* / *Q* / *K*，其余字符不作处理

*1* 看做 *A*, *0* 看做 *10*

一次输入超过5个一行以前5个做计算

输入不符要求的字符需重新输入5张牌

#### DEMO

*C/Poker_C.exe* (Windows 10 x64)

## PHP_POP 版本

#### 用法

GET *http(s)://your.domain.com/Poker.php?{参数}*

#### JSON 返回值

errCode | errText | judgeText
--- | --- | ---
400 | "unknown error" | NULL
401 | "empty pokers" | NULL
402 | "not enough pokers" | NULL
0 | NULL | *judgeText_JSON*

#### judgeText JSON 返回值

type | value | toSum | toLeft
--- | --- | --- | ---
"BOMB" | which four-of-a-kind | NULL | NULL
"FIVE BULLS" | NULL | NULL | NULL | NULL
"FIVE SMALL BULLS" | NULL | NULL | NULL | NULL
"BULLS" | value of bull | 3 of pokers to sum | 2 of pokers then left

#### 参数要求

输入仅识别数字和 *a* / *j* / *q* / *k* / *A* / *J* / *Q* / *K*，其余字符不作处理

*1* 看做 *A*, *0* 看做 *10*

超过5个参数以前5个做计算

#### DEMO

*PHP_POP/Poker.htm*  (CentOS 7.2 x64, Nginx, PHP5.6)

## JavaScript_POP 版本

#### 用法

HTML head 需引用 *Poker.js*

```
<script type="text/javascript" src="Poker.js"></script>
```

HTML body 需设置以下两个标签和参数

```
<input type="text" id="in">
<button onclick="run()">OK</button>
```

#### 参数要求

输入仅识别数字和 *a* / *j* / *q* / *k* / *A* / *J* / *Q* / *K*，其余字符不作处理

*1* 看做 *A*, *0* 看做 *10*

超过5个参数以前5个做计算

#### DEMO

*JavaScript_POP/Poker.htm* (Chrome 57.0.2987.98 (64-bit), Windows 10 x64)