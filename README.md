# MySQLのパフォーマンス確認用リポジトリ

```
git clone git@github.com:t-kuni/mysql-performance.git
cd environments
docker-compose up -d
docker-compose run workspace sh
```

MySQL

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
