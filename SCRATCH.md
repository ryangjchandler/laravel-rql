# Scratch

```php
public function compile(string $query): Eloquent\Builder
{
    // 1. Tokenise the query.
    // 2. Parse the query into an abstract syntax tree.
    // 3. Compile the AST into an Eloquent query.
    // 4. Return the builder object.
}
```

```php
$query = Rql::compile(<<<rql
   
rql);
```

```php
class MyOrdersExport
{
    public function query()
    {
        return Order::query()
            ->where()
            ->orderBy();
    }

    public function row(Order $order): array
    {
        return [
            'id' => $order->id,
            'price' => '£' . number_format($order->price, 2),
        ];
    }
}
```
