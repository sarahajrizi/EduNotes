<?php

use PHPUnit\Framework\TestCase;

class CommentsTest extends TestCase
{
    protected $conn;

    protected function setUp(): void
    {
        $this->conn = new mysqli("127.0.0.1", "root", "", "edunotes", 3307);
        if ($this->conn->connect_error) {
            die("Lidhja deshtoi: " . $this->conn->connect_error);
        }
    }

    public function testInsertPergjithshemComment()
    {
        $nxenesi_id = 999;
        $mesuesi_id = 888;
        $lenda_id = null; // për koment përgjithshëm
        $pershkrimi = "Ky është një koment test nga PHPUnit";
        $lloji_komentit = "Përgjithshëm";

        // Fut koment
        $query = "INSERT INTO komentet (nxenesi_id, mesuesi_id, lenda_id, pershkrimi, lloji_komentit) 
                  VALUES ($nxenesi_id, $mesuesi_id, NULL, '$pershkrimi', '$lloji_komentit')";
        $result = mysqli_query($this->conn, $query);

        $this->assertTrue($result);

        // Kontrollo që ekziston
        $verify = mysqli_query($this->conn, 
            "SELECT * FROM komentet 
             WHERE nxenesi_id = $nxenesi_id 
             AND mesuesi_id = $mesuesi_id 
             AND lloji_komentit = '$lloji_komentit' 
             AND pershkrimi = '$pershkrimi'"
        );

        $this->assertEquals(1, mysqli_num_rows($verify));

        // Pastrim pas testit
        mysqli_query($this->conn, 
            "DELETE FROM komentet 
             WHERE nxenesi_id = $nxenesi_id 
             AND mesuesi_id = $mesuesi_id 
             AND pershkrimi = '$pershkrimi'"
        );
    }

    protected function tearDown(): void
    {
        $this->conn->close();
    }
}