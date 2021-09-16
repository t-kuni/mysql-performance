:LOOP
    .\unison\unison . socket://local.XXXX.com:5000/ ^
        -repeat ^
        watch ^
        -auto ^
        -batch ^
        -prefer newer ^
        -ignore "Path .git" ^
        -ignore "Path .idea" ^
        -ignore "Path environment" ^
        -ignore "Path storage/framework/cache/*" ^
        -ignore "Path storage/framework/sessions/*" ^
        -ignore "Path storage/debugbar/*"
goto :LOOP
