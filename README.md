# gears-dictionary
The project, which Gears Dictionary

## Flat Dictionary

### use Ailixter\Gears\Dictionary\ReadonlyFlat;
```php

$readonly = new ReadonlyFlat(['x' => 123]);

if ($readonly->has('x')) {
    echo $readonly->get('x'); // 123
}
echo $readonly->get('y'); // null
echo $readonly->get('y', 'notset'); // 'notset'
echo $readonly['y']; // null
echo isset($readonly['x']); // true
echo isset($readonly['y']); // false
unset($readonly['x']); // AccessException
```

### use Ailixter\Gears\Dictionary\Flat;
```php
$writable = new Flat($readonly->all());

$writable->set('x', 456);
$array = $writable->set('y', 789)->remove('x')->all(); // ['y' => 789]
echo $writable->has('y'); // true
```

## Structured Dictionary

### use Ailixter\Gears\Dictionary\ReadonlyStruct;
```php
$readonly = new ReadonlyStruct([
    'x' => [123, 456],
    'y' => [
        'z' => 789
    ]
]);

if ($readonly->has('x')) {
    echo $readonly->get('x'); // [123, 456]
}
echo $readonly->get('x/0'); // 123 
echo $readonly['x/1']; // 456
echo isset($readonly['y/z']); // true
echo isset($readonly['y/z/0']); // false
unset($readonly['x/0']); // AccessException
```

### use Ailixter\Gears\Dictionary\Struct;
```php
$writable = new Struct($readonly->all());

$writable->set('x', 456);
$writable->has('x/0'); // false
```

```php
$writable->add('x', 456);
$writable->has('x/0'); // true
$writable->get('x'); // [456]
```

## Interfaces

### use Ailixter\Gears\Dictionary\ReadonlyDictionaryInterface;
```php
function testReadonly (ReadonlyDictionaryInterface $readonly) {
    return $readonly->get('param');
}

testReadonly(new ReadonlyFlat($_POST)) === testReadonly(new Struct($_POST)); // true
```

### use Ailixter\Gears\Dictionary\DictionaryInterface;
```php
function testWritable (DictionaryInterface $writable, $key) {
    return $writable->set($key, 123)->get($key);
}

testWritable(new Flat($_POST), 'param') === testWritable(new Struct($_POST), 'data/0'); // true
```

## DictionaryExtraInterface

### use extracting:
```php
$writable->has('x'); // true
echo $writable->extract('x'); // [456]
$writable->has('x'); // false
```

### use references:
```php
$writable = new Flat;
$var =& $writable->ref('x');
$writable->set('x', 123);
echo $var; // 123
```

```php
$writable = new Struct;
$var = 123;
$writable->setref('x/0', $var);
$var = 456;
echo $writable->get['x']; // [456]
```

```php
(new Struct)->refer($_GET)->set('p/route', 'chapter/1');
echo $_GET['p']; // ['route' => 'chapter/1']
```

## Howtos

### Struct: use custom path separator
```php
echo new Struct(['x' => [123, 456])->setPathSeparator('.')->get('x.0'); // 123
```

### Struct: export data
```php
function export($dbRecord, $map) {
    $jsonData = new Struct;
    foreach ($map as $dst => $src) {
        $jsonData[$dst] = $dbRecord[$src];
    }
    return $jsonData;
}

$jsonData = export(new Struct($dbRecord), [
    'record_id'       => 'id',
    'contacts/email'  => 'email',
    'contacts/phone'  => 'phone',
    'logo_url'        => 'images/url/0'
]);
echo json_encode($jsonData->all());
```