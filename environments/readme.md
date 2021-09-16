# Laravel Local Environment Skeleton

Docker + Laravelのローカル環境の最小構成のスケルトンです。


## 利用方法

クローンする

```bash
git clone --depth 1 https://github.com/t-kuni/laravel-local-environment-skeleton.git [FOLDER_NAME]
cd [FOLDER_NAME]
rm -rf .git
```

設定ファイルをコピーして必要に応じて変更する  
（プロジェクト全体を検索して`XXXX`と記載されている部分を、環境に合わせて書き換えてください。）

```
cp .env.example .env
cp docker-compose-[linux or win].yml docker-compose.yml
```

hostsに本アプリのドメインを追記する

```
127.0.0.1 local.XXXX.com
```

自己署名証明書を生成する  
ホスト名とIPアドレスは環境に合わせて書き換えてください。

```bash
docker run --rm -v $PWD/certs:/out -e HOST=local.XXXX.com -e IP=127.0.0.1 tkuni83/self-sign-cert
```

動作確認

https://local.XXXX.com

## DBを確認する

http://local.XXXX.com:8080/



## npmやcomposer, artisanの実行

以下のコマンドでコンテナのシェルを起動すれば`npm`や`composer`, `php`を利用できる

```
docker-compose run workspace sh
```

まだLaravelをインストールしていない場合は以下のコマンドでインストールできる。

```
composer create-project laravel/laravel .
```

## ファイルの同期（Windowsの場合）

Windowsの場合はunisonでファイルを同期します（unisonを使わない場合、ファイル同期が重く画面表示が遅い）

`sync-files.bat`を起動するとファイルが同期されます。