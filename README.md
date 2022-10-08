# MySQLのパフォーマンス確認用リポジトリ

## 起動方法

```
git clone git@github.com:t-kuni/mysql-performance.git
cd mysql-performance
cp .env.example .env
cd environments
cp docker-compose-linux.yml docker-compose.yml
cp .env.example .env
docker-compose up -d
docker-compose run workspace sh
composer install
php artisan migrate --seed
```

## DBを確認する方法

http://localhost:8080/

## Tips

MySQL Workbenchを使うと実行計画が確認しやすい

![](https://i.gyazo.com/fc5c5dc123058c736a9f7b7c89ae0451.png)

## 1つのインデックスに対して、複数カラムの絞り込みを行うとどうなる？

textカラムにインデックスを付与している  
`AND`の場合はインデックスが使われる  
`OR`の場合はインデックスが使われない

```
SELECT * FROM test.single_index_records WHERE text = "text0" AND no = 2;
```

## 複合インデックスに対して、部分的なカラムの絞り込みを行うとどうなる？

text, noカラムにインデックスを付与している  
`text`単体での絞り込みにはインデックスが使われる
`no`単体での絞り込みにはインデックスが使われない

```
SELECT * FROM test.multi_index_records WHERE text = "text0"
```

## 多段ジョインのパフォーマンス

```sql
SELECT SQL_NO_CACHE *
FROM join_1_records AS j1
         LEFT JOIN join_2_records AS j2 ON j1.id = j2.`1_id`
         LEFT JOIN join_3_records AS j3 ON j2.`3_id` = j3.id
         LEFT JOIN join_4_records AS j4 ON j3.id = j4.`3_id`
         LEFT JOIN join_5_records AS j5 ON j4.`5_id` = j5.id
WHERE j1.id = 1
```

### 外部キー（インデックス）あり

Duration / Fetch  
0.0015 sec / 0.0029 sec

### 外部キー（インデックス）なし

Duration / Fetch  
0.126 sec / 0.239 sec

## 多段ジョイン＋GROUP BYのパフォーマンス

```sql
SELECT SQL_NO_CACHE j1.name, GROUP_CONCAT(j3.name),
       GROUP_CONCAT(j5.name)
FROM join_1_records AS j1
         LEFT JOIN join_2_records AS j2 ON j1.id = j2.`1_id`
         LEFT JOIN join_3_records AS j3 ON j2.`3_id` = j3.id
         LEFT JOIN join_4_records AS j4 ON j3.id = j4.`3_id`
         LEFT JOIN join_5_records AS j5 ON j4.`5_id` = j5.id
WHERE j1.id = 1
GROUP BY j1.id
```

※実用する場合にはカンマのエスケープや、カンマ区切りからアプリケーション側のオブジェクトに展開する処理などが入る  
※リレーションが深くなるとアプリケーション側のオブジェクトに展開するのが難しい（不可能）  
※GROUP BYがあるため1件ずつ返すことが出来ない

インデックスがあればJOINそのものは速いが、JOINを行う度にレコードが増えていく都合でGROUP BYとの相性が悪い

### 外部キー（インデックス）あり

Duration / Fetch  
0.149 sec / 0.0000072 sec  
Total: 0.1490072 sec

![](https://i.gyazo.com/fcaeaee4c6abc6de27af3f00abbb50dc.png)

インデックスが効いており、基本的には左のレコード数×１のコストでJOINできている  
j5のみフルスキャンになっている（フルスキャンの方が早いと判断されたと思われる）

### 外部キー（インデックス）なし

Duration / Fetch  
0.587 sec / 0.0000072 sec

![](https://i.gyazo.com/90b889b294c2bb65f3cf9d10e3445aa6.png)

j2, j4テーブルのJOIN時にインデックスが無いため、左のレコード数×右のレコード数のコストが掛かっている

### （余談）インデックス有りで各テーブルをINで取得する場合

アプリケーション側でテーブル間の紐づけを行う前提

```sql
SELECT SQL_NO_CACHE *
FROM join_1_records
WHERE id = 1 # Duration / Fetch
# 0.00065 sec / 0.0000098 sec

SELECT SQL_NO_CACHE *
FROM join_2_records
WHERE `1_id` = 1 # 0.0023 sec / 0.0020 sec

SELECT SQL_NO_CACHE *
FROM join_3_records
WHERE id IN (1, 1001, 2001, 3001, 4001, 5001, 6001, 7001, 8001, 9001) # 0.00075 sec / 0.000018 sec

SELECT SQL_NO_CACHE *
FROM join_4_records
WHERE `3_id` IN (1, 1001, 2001, 3001, 4001, 5001, 6001, 7001, 8001, 9001) # 0.0027 sec / 0.0021 sec

SELECT SQL_NO_CACHE *
FROM join_5_records
WHERE id IN (1, 1001, 2001, 3001, 4001, 5001, 6001, 7001, 8001, 9001) # 0.00073 sec / 0.000013 sec

Total: 0.0112708 sec
```

## 関連するテーブルのカラムで絞り込みを行うケース

### WHERE IN+副問合せを使う場合

```SQL
SELECT SQL_NO_CACHE *
FROM join_1_records AS j1
WHERE id IN (
	SELECT `1_id` 
    FROM join_2_records AS j2 
    WHERE `3_id` IN (
		SELECT id 
		FROM join_3_records AS j3
		WHERE id IN (
			SELECT `3_id` 
			FROM join_4_records AS j4 
			WHERE `5_id` IN (
				SELECT `id` 
				FROM join_5_records AS j5 
				WHERE j5.id = 10
			)
		)
	)
)
```

Total: 0.0093 sec

### JOINを使う場合

（試して気づいたが、1対多関連をJOINした場合、左表の行が増殖するので絞り込みに向かない。SELECTするカラムによってはDISTINCTで緩和できるが。）

```SQL
SELECT SQL_NO_CACHE DISTINCT j1.*
FROM join_1_records AS j1
    JOIN join_2_records AS j2 ON j1.id = j2.`1_id`
    JOIN join_3_records AS j3 ON j2.`3_id` = j3.id
    JOIN join_4_records AS j4 ON j3.id = j4.`3_id`
    JOIN join_5_records AS j5 ON j4.`5_id` = j5.id AND j5.id = 10
```

Total: 0.012 sec

> JOIN ON で絞り込み条件を入れるのと、JOIN ONの後WHERE句で絞り込み条件を入れるのとでは、結果が違う  
> JOIN ONで絞り込み条件を書くと、「結果を絞るのではなく、結合前のテーブルのレコードを絞る」らしい。

https://atsuizo.hatenadiary.jp/entry/2016/12/12/163921

### 結論

単に絞り込みするだけならWHERE IN+副問合せの方が早い

# Todo 

* [ ] WHEREでCOALESCEを使って条件式を増減させるケース
