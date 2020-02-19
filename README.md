# phpuk2020

```
docker build -f Dockerfile -t swoole-php .
```

```
docker run --rm -p 9501:9501 -v $(pwd):/app -w /app swoole-php ./00-coroutine.php
```