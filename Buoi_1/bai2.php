<?php

function calculateAverageScore(array $students): float
{
    if (count($students) === 0) {
        return 0;
    }

    $totalScore = 0;
    foreach ($students as $student) {
        $totalScore += $student["score"];
    }

    return $totalScore / count($students);
}

function getRank(float $score): string
{
    if ($score >= 8) {
        return "Gioi";
    }
    if ($score >= 6.5) {
        return "Kha";
    }
    if ($score >= 5) {
        return "Trung binh";
    }
    return "Yeu";
}

function displayStudent(array $student): void
{
    echo "Ho ten: {$student['name']}<br>";
    echo "Tuoi: {$student['age']}<br>";
    echo "Diem: {$student['score']}<br>";
    echo "Xep loai: " . getRank($student["score"]) . "<br><br>";
}

$students = [
    ["name" => "Nguyen Van An", "age" => 20, "score" => 8.5],
    ["name" => "Tran Thi Binh", "age" => 21, "score" => 6.5],
    ["name" => "Le Van Cuong", "age" => 19, "score" => 4.5],
    ["name" => "Pham Thi Dung", "age" => 20, "score" => 7.5]
];

foreach ($students as $student) {
    displayStudent($student);
}

echo "Diem trung binh: " . number_format(calculateAverageScore($students), 2);

