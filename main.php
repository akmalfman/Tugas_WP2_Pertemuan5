<?php

// Kelas Book merepresentasikan objek buku
class Book
{
    // Atribut-atribut buku
    private $title;
    private $author;
    private $year;
    private $isBorrowed;

    // Constructor untuk inisialisasi buku
    public function __construct($title, $author, $year)
    {
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
        $this->isBorrowed = false;
    }

    // Getter untuk mendapatkan judul buku
    public function getTitle()
    {
        return $this->title;
    }

    // Getter untuk mendapatkan status pinjam buku
    public function isBorrowed()
    {
        return $this->isBorrowed;
    }

    // Fungsi untuk meminjam buku
    public function borrowBook()
    {
        if (!$this->isBorrowed) {
            $this->isBorrowed = true;
            echo "Buku " . $this->title . " telah dipinjam.\n";
        } else {
            echo "Buku " . $this->title . " sudah dipinjam sebelumnya.\n";
        }
    }

    // Fungsi untuk mengembalikan buku
    public function returnBook()
    {
        if ($this->isBorrowed) {
            $this->isBorrowed = false;
            echo "Buku " . $this->title . " telah dikembalikan.\n";
        } else {
            echo "Buku " . $this->title . " belum dipinjam.\n";
        }
    }
}

// Kelas Library merepresentasikan objek perpustakaan
class Library
{
    // Koleksi buku dalam perpustakaan
    private $books = [];

    // Fungsi untuk menambahkan buku baru ke perpustakaan
    public function addBook(Book $book)
    {
        $this->books[] = $book;
        echo "Buku " . $book->getTitle() . " berhasil ditambahkan ke perpustakaan.\n";
    }

    // Fungsi untuk mencetak daftar buku yang tersedia
    public function printAvailableBooks()
    {
        echo "Daftar buku yang tersedia:\n";
        foreach ($this->books as $book) {
            if (!$book->isBorrowed()) {
                echo "- " . $book->getTitle() . "\n";
            }
        }
        echo "===========================\n"; // Penambahan pemisah
    }

    // Fungsi untuk menampilkan menu interaktif
    public function interactiveMenu()
    {
        echo "\nMenu:\n";
        echo "1. Tampilkan daftar buku\n";
        echo "2. Tambahkan buku baru\n";
        echo "3. Pinjam buku\n";
        echo "4. Kembalikan buku\n";
        echo "5. Keluar\n";

        $choice = readline("Pilih menu (1-5): ");

        switch ($choice) {
            case '1':
                $this->printAvailableBooks();
                break;
            case '2':
                $this->addBookFromUserInput();
                break;
            case '3':
                $this->borrowBookFromUserInput();
                break;
            case '4':
                $this->returnBookFromUserInput();
                break;
            case '5':
                exit("Terima kasih!\n");
            default:
                echo "Pilihan tidak valid. Silakan coba lagi.\n";
                break;
        }

        $this->interactiveMenu(); // Kembali menampilkan menu setelah aksi selesai
    }

    // Fungsi untuk menambahkan buku baru berdasarkan input pengguna
    private function addBookFromUserInput()
    {
        $title = readline("Masukkan judul buku: ");
        $author = readline("Masukkan nama penulis: ");
        $year = readline("Masukkan tahun terbit: ");
        $book = new Book($title, $author, $year);
        $this->addBook($book);
    }

    // Fungsi untuk meminjam buku berdasarkan input pengguna
    private function borrowBookFromUserInput()
    {
        $title = readline("Masukkan judul buku yang ingin dipinjam: ");
        $book = $this->findBookByTitle($title);
        if ($book !== null) {
            $book->borrowBook();
        } else {
            echo "Buku tidak ditemukan.\n";
        }
    }

    // Fungsi untuk mengembalikan buku berdasarkan input pengguna
    private function returnBookFromUserInput()
    {
        $title = readline("Masukkan judul buku yang ingin dikembalikan: ");
        $book = $this->findBookByTitle($title);
        if ($book !== null) {
            $book->returnBook();
        } else {
            echo "Buku tidak ditemukan.\n";
        }
    }

    // Fungsi untuk mencari buku berdasarkan judul
    private function findBookByTitle($title)
    {
        foreach ($this->books as $book) {
            if (strtolower($book->getTitle()) === strtolower($title)) {
                return $book;
            }
        }
        return null;
    }
}

// Contoh penggunaan
$library = new Library();

// Menambahkan beberapa buku ke perpustakaan
$book1 = new Book("Laskar Pelangi", "Andrea Hirata", 2005);
$book2 = new Book("Ayat Ayat Cinta", "Habiburrahman El Shirazy", 2004);
$book3 = new Book("Bumi Manusia", "Pramoedya Ananta Toer", 1980);
$library->addBook($book1);
$library->addBook($book2);
$library->addBook($book3);

// Menampilkan menu interaktif
$library->interactiveMenu();
