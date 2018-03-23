# tproto

### How to use.

Create Transmitter. For example, use transmitter with unbuffered PDO query and symfony:

```php
return new \Symfony\Component\HttpFoundation\StreamedResponse(function() use ($pdo) {
    $tm = new \RV\TProto\Proto\Transmitter\Transmitter(function($data) {
        echo $data;
    }, null, true);
    
    $pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
    $res = $pdo->query("SELECT id, status FROM tblclients");
    while (false !== ($row = $res->fetch(\PDO::FETCH_ASSOC))) {
        $tm->send($row);
    }
});
```

Create receiver. For example (now there is only guzzle adapter, you can use your own adapters):

```php
$stream = $client->get('https://test.com/stream')->getBody();
$update = new \RV\TProto\Proto\Receiver\Receiver($stream, function($data) {
    print_r($data);
});
$update->run();
```

If you need to receive objects not one at a time, but a batch, then you can use BatchReceiver (200 in batch, for example):

```php
$stream = $client->get('https://test.com/stream')->getBody();
$update = new \RV\TProto\Proto\Receiver\BatchReceiver($stream, function($data) {
    print count($data);
}, null, 200);
$update->run();
```

---

Also, you can use customize serializer and DTO:

```php
class Client
{
    public $id;
    public $status;
    
    public function __construct($id, $status)
    {
        $this->id = $id;
        $this->status = $status;
    }
}
```

```php
class CustomSerializer implements \RV\TProto\Serializer\SerializerInterface
{
    public function serialize($data)
    {
        return $data['id'].";".$data['status'];
    }
    
    public function deserialize($data)
    {
        return new Client($data['id'], $data['status']);
    }
    
    public function getDelimiter()
    {
        return ":";
    }
}
```

And use it on transmitter and receiver, for example receiver:

```php
$update = new \RV\TProto\Proto\Receiver\Receiver($stream, function($data) {
    var_dump($data);
}, new CustomSerializer());
```

It print object:

```php
object(Client)#1 (2) {
  ["id"]=>
  int(123)
  ["status"]=>
  int(0)
}
```
