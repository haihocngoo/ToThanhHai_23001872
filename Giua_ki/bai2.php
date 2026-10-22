<?php
function calculateTotal($prices)
{
    $total = 0;

    foreach ($prices as $price) {
        $total += $price;
    }

    return $total;
}

function findMaxPrice($prices)
{
    if (count($prices) === 0) {
        return null;
    }

    $maxPrice = $prices[0];

    foreach ($prices as $price) {
        if ($price > $maxPrice) {
            $maxPrice = $price;
        }
    }

    return $maxPrice;
}

$prices = [100000, 250000, 150000, 300000, 200000];

$total = calculateTotal($prices);
$maxPrice = findMaxPrice($prices);

echo "Tổng giá trị sản phẩm: " . number_format($total) . " đồng\n";

if ($maxPrice !== null) {
    echo "Giá sản phẩm cao nhất: "
        . number_format($maxPrice) . " đồng\n";
} else {
    echo "Danh sách sản phẩm rỗng.\n";
}