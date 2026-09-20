<?php

function findBestStudent(array $students): ?array
{
    if (count($students) === 0) {
        return null;
    }

    $bestStudent = $students[0];
    foreach ($students as $student) {
        if ($student["score"] > $bestStudent["score"]) {
            $bestStudent = $student;
        }
    }
    return $bestStudent;
}

function findWorstStudent(array $students): ?array
{
    if (count($students) === 0) {
        return null;
    }

    $worstStudent = $students[0];
    foreach ($students as $student) {
        if ($student["score"] < $worstStudent["score"]) {
            $worstStudent = $student;
        }
    }
    return $worstStudent;
}

function countPassedStudents(array $students): int
{
    $count = 0;
    foreach ($students as $student) {
        if ($student["score"] >= 5) {
            $count++;
        }
    }
    return $count;
}

function findStudentByName(array $students, string $name): ?array
{
    foreach ($students as $student) {
        if (strcasecmp($student["name"], $name) === 0) {
            return $student;
        }
    }
    return null;
}

function displayStudent(array $student): void
{
    echo "Ho ten: {$student['name']} - Tuoi: {$student['age']} - Diem: {$student['score']}<br>";
}

$students = [
    ["name" => "Nguyen Van An", "age" => 20, "score" => 8.5],
    ["name" => "Tran Thi Binh", "age" => 21, "score" => 6.5],
    ["name" => "Le Van Cuong", "age" => 19, "score" => 4.5],
    ["name" => "Pham Thi Dung", "age" => 20, "score" => 7.5]
];

$bestStudent = findBestStudent($students);
$worstStudent = findWorstStudent($students);
$foundStudent = findStudentByName($students, "Tran Thi Binh");

echo "Sinh vien co diem cao nhat:<br>";
displayStudent($bestStudent);

echo "<br>Sinh vien co diem thap nhat:<br>";
displayStudent($worstStudent);

echo "<br>So sinh vien dat: " . countPassedStudents($students) . "<br>";

echo "<br>Ket qua tim kiem:<br>";
if ($foundStudent !== null) {
    displayStudent($foundStudent);
} else {
    echo "Khong tim thay sinh vien.";
}

