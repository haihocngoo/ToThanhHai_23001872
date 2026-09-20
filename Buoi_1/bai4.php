<?php

class Student
{
    public string $name;
    public int $age;
    public float $score;

    public function __construct(string $name, int $age, float $score)
    {
        $this->name = $name;
        $this->age = $age;
        $this->score = $score;
    }

    public function getRank(): string
    {
        if ($this->score >= 8) {
            return "Gioi";
        }
        if ($this->score >= 6.5) {
            return "Kha";
        }
        if ($this->score >= 5) {
            return "Trung binh";
        }
        return "Yeu";
    }

    public function isPassed(): bool
    {
        return $this->score >= 5;
    }

    public function display(): void
    {
        echo "Ho ten: {$this->name}<br>";
        echo "Tuoi: {$this->age}<br>";
        echo "Diem: {$this->score}<br>";
        echo "Xep loai: {$this->getRank()}<br><br>";
    }
}

function findBestStudent(array $students): ?Student
{
    if (count($students) === 0) {
        return null;
    }

    $bestStudent = $students[0];
    foreach ($students as $student) {
        if ($student->score > $bestStudent->score) {
            $bestStudent = $student;
        }
    }
    return $bestStudent;
}

function countPassedStudents(array $students): int
{
    $count = 0;
    foreach ($students as $student) {
        if ($student->isPassed()) {
            $count++;
        }
    }
    return $count;
}

function calculateAverageScore(array $students): float
{
    if (count($students) === 0) {
        return 0;
    }

    $totalScore = 0;
    foreach ($students as $student) {
        $totalScore += $student->score;
    }
    return $totalScore / count($students);
}

$student1 = new Student("Nguyen Van An", 20, 8.5);
$student2 = new Student("Tran Thi Binh", 21, 6.5);
$student3 = new Student("Le Van Cuong", 19, 4.5);
$student4 = new Student("Pham Thi Dung", 20, 7.5);

$students = [$student1, $student2, $student3, $student4];

foreach ($students as $student) {
    $student->display();
}

$bestStudent = findBestStudent($students);
echo "Sinh vien co diem cao nhat:<br>";
$bestStudent?->display();

echo "So sinh vien dat: " . countPassedStudents($students) . "<br>";
echo "Diem trung binh cua lop: " . number_format(calculateAverageScore($students), 2);

