<?php

class CartItem
{
    private string $name;
    private float $price;
    private int $quantity;

    public function __construct(string $name, float $price, int $quantity)
    {
        if (trim($name) === '') {
            throw new InvalidArgumentException('Ten san pham khong duoc de trong.');
        }
        if ($price <= 0) {
            throw new InvalidArgumentException('Don gia phai lon hon 0.');
        }
        if ($quantity <= 0) {
            throw new InvalidArgumentException('So luong phai lon hon 0.');
        }

        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getTotal(): float
    {
        return $this->price * $this->quantity;
    }
}

class ShoppingCart
{
    private array $items = [];

    public function addItem(CartItem $item): void
    {
        $this->items[] = $item;
    }

    public function removeItem(string $name): bool
    {
        foreach ($this->items as $index => $item) {
            if (strcasecmp($item->getName(), $name) === 0) {
                unset($this->items[$index]);
                $this->items = array_values($this->items);
                echo "Da xoa san pham: {$item->getName()}<br>";
                return true;
            }
        }

        echo "Khong tim thay san pham: {$name}<br>";
        return false;
    }

    public function calculateTotal(): float
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }
        return $total;
    }

    public function displayCart(): void
    {
        if (count($this->items) === 0) {
            echo "Gio hang dang trong.<br>";
            return;
        }

        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr><th>Ten san pham</th><th>Don gia</th><th>So luong</th><th>Thanh tien</th></tr>";

        foreach ($this->items as $item) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($item->getName()) . '</td>';
            echo '<td>' . number_format($item->getPrice()) . ' VND</td>';
            echo '<td>' . $item->getQuantity() . '</td>';
            echo '<td>' . number_format($item->getTotal()) . ' VND</td>';
            echo '</tr>';
        }

        echo "</table>";
        echo "<strong>Tong tien: " . number_format($this->calculateTotal()) . " VND</strong><br>";
    }
}

function addProduct(ShoppingCart $cart, string $name, float $price, int $quantity): void
{
    try {
        $cart->addItem(new CartItem($name, $price, $quantity));
    } catch (InvalidArgumentException $exception) {
        echo "Khong the them {$name}: {$exception->getMessage()}<br>";
    }
}

$cart = new ShoppingCart();

addProduct($cart, 'Laptop', 15000000, 1);
addProduct($cart, 'Chuot khong day', 350000, 2);
addProduct($cart, 'Ban phim', 750000, 1);
addProduct($cart, 'Tai nghe', 600000, 2);

echo '<h2>Gio hang ban dau</h2>';
$cart->displayCart();

echo '<h2>Xoa san pham</h2>';
$cart->removeItem('Ban phim');

echo '<h2>Gio hang sau khi xoa</h2>';
$cart->displayCart();

echo '<h2>Kiem tra du lieu khong hop le</h2>';
addProduct($cart, 'San pham loi', 0, 1);
addProduct($cart, 'San pham loi', 100000, 0);
$cart->removeItem('San pham khong ton tai');

