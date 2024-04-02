# Laravel Fingerprint Solution
Laravel package for connect and get data from fingerprint Solution X100-C, X304, X302-S, X401, X601, C1

## Easy Installation
### Install with composer

To install with [Composer](https://getcomposer.org/), simply require the
latest version of this package.

```bash
composer require latansamashiro/laravel-fp-solution
```

Make sure that the autoload file from Composer is loaded.
```bash
composer dump-autoload
```
### How to Use
```
use Latansamashiro\Fingerprint\FingerPrint;
...

// example
$ip_address = "192.168.1.10";
$commkey = "0";
$port = "4370";
$fp_machine = new FingerPrint($ip_address, $commkey, $port);

// Check Connection to Machine FP (return Boolean)
$is_connect = $fp_machine->connect();
echo $is_connect;

// Get Data from Machine (return Array)
$data = $fp_machine->getData();
print_r($data);

```

## License
MIT
