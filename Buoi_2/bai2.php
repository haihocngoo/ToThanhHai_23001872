<?php

class Movie
{
    private int $id;
    private string $title;
    private float $price;
    private int $totalSeats;
    private int $availableSeats;

    public function __construct(int $id, string $title, float $price, int $totalSeats)
    {
        if ($id <= 0 || trim($title) === '' || $price <= 0 || $totalSeats <= 0) {
            throw new InvalidArgumentException('Thong tin phim khong hop le.');
        }

        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->totalSeats = $totalSeats;
        $this->availableSeats = $totalSeats;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function bookTicket(int $quantity): bool
    {
        if ($quantity <= 0) {
            echo "So ve dat phai lon hon 0.<br>";
            return false;
        }
        if ($quantity > $this->availableSeats) {
            echo "Khong du ghe trong cho phim {$this->title}.<br>";
            return false;
        }

        $this->availableSeats -= $quantity;
        echo "Da dat {$quantity} ve phim {$this->title}.<br>";
        return true;
    }

    public function cancelTicket(int $quantity): bool
    {
        if ($quantity <= 0) {
            echo "So ve huy phai lon hon 0.<br>";
            return false;
        }
        if ($quantity > $this->getSoldSeats()) {
            echo "Khong the huy nhieu hon so ve da ban cua phim {$this->title}.<br>";
            return false;
        }

        $this->availableSeats += $quantity;
        echo "Da huy {$quantity} ve phim {$this->title}.<br>";
        return true;
    }

    public function getSoldSeats(): int
    {
        return $this->totalSeats - $this->availableSeats;
    }

    public function getRevenue(): float
    {
        return $this->getSoldSeats() * $this->price;
    }

    public function displayInfo(): void
    {
        echo "Ma phim: {$this->id}<br>";
        echo "Ten phim: " . htmlspecialchars($this->title) . "<br>";
        echo "Gia ve: " . number_format($this->price) . " VND<br>";
        echo "Tong so ghe: {$this->totalSeats}<br>";
        echo "So ghe con lai: {$this->availableSeats}<br>";
        echo "So ve da ban: {$this->getSoldSeats()}<br>";
        echo "Doanh thu: " . number_format($this->getRevenue()) . " VND<br><br>";
    }
}

function findMovieById(array $movies, int $id): ?Movie
{
    foreach ($movies as $movie) {
        if ($movie->getId() === $id) {
            return $movie;
        }
    }
    return null;
}

function getTotalRevenue(array $movies): float
{
    $totalRevenue = 0;
    foreach ($movies as $movie) {
        $totalRevenue += $movie->getRevenue();
    }
    return $totalRevenue;
}

function getBestSellingMovie(array $movies): ?Movie
{
    if (count($movies) === 0) {
        return null;
    }

    $bestSellingMovie = $movies[0];
    foreach ($movies as $movie) {
        if ($movie->getSoldSeats() > $bestSellingMovie->getSoldSeats()) {
            $bestSellingMovie = $movie;
        }
    }
    return $bestSellingMovie;
}

$movies = [
    new Movie(1, 'Avengers', 100000, 100),
    new Movie(2, 'Avatar', 120000, 80),
    new Movie(3, 'Batman', 90000, 120)
];

$avengers = findMovieById($movies, 1);
$avatar = findMovieById($movies, 2);

if ($avengers !== null) {
    $avengers->bookTicket(30);
    $avengers->cancelTicket(5);
}
if ($avatar !== null) {
    $avatar->bookTicket(40);
}

echo '<h2>Danh sach phim</h2>';
foreach ($movies as $movie) {
    $movie->displayInfo();
}

echo '<h2>Tong doanh thu</h2>';
echo number_format(getTotalRevenue($movies)) . ' VND<br>';

echo '<h2>Phim ban chay nhat</h2>';
$bestSellingMovie = getBestSellingMovie($movies);
if ($bestSellingMovie !== null) {
    $bestSellingMovie->displayInfo();
} else {
    echo 'Danh sach phim rong.<br>';
}

echo '<h2>Kiem tra du lieu khong hop le</h2>';
if ($avengers !== null) {
    $avengers->bookTicket(0);
    $avengers->bookTicket(200);
    $avengers->cancelTicket(0);
    $avengers->cancelTicket(200);
}

$notFoundMovie = findMovieById($movies, 999);
if ($notFoundMovie === null) {
    echo 'Khong tim thay phim co ma 999.<br>';
}

if (getBestSellingMovie([]) === null) {
    echo 'Khong the tim phim ban chay nhat vi danh sach rong.<br>';
}
echo 'Tong doanh thu cua danh sach rong: ' . number_format(getTotalRevenue([])) . ' VND';
