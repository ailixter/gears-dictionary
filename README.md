# gears-dictionary
The project, which Gears Dictionary

## Flat Dictionary

```php
use Ailixter\Gears\Dictionary\ReadonlyFlat;

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

function testReadonly (ReadonlyDictionaryInterface $readonly, $key) {
    return $readonly->get($key);
}
```

```php
use Ailixter\Gears\Dictionary\Flat;

$writable = new Flat($readonly->all());

$writable->set('x', 456);
$array = $writable->set('y', 789)->remove('x')->all(); // ['y' => 789]
echo $writable->has('y'); // true

function testWritable (DictionaryInterface $writable, $key, $value) {
    return $writable->set($key, $value)->get($key);
}
```