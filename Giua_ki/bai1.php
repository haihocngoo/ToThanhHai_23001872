<?php
$name = "Nguyen Van An";
$score = 7.5;
if ($score >= 8) {
    $rank = "Giỏi";
} elseif ($score >= 6.5) {
    $rank = "Khá";
} elseif ($score >= 5) {
    $rank = "Trung bình";
} else {
    $rank = "Yếu";
}

echo "Họ tên: " . $name . "\n";
echo "Điểm: " . $score . "\n";
echo "Xếp loại: " . $rank . "\n";
?>
