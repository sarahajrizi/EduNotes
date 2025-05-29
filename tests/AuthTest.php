<?php

use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
{
    protected $conn;

    protected function setUp(): void
    {
        // Lidhja me databazën sipas konfigurimit tënd (porti 3307)
        $this->conn = new mysqli("127.0.0.1", "root", "", "edunotes", 3307);

        if ($this->conn->connect_error) {
            die("Lidhja deshtoi: " . $this->conn->connect_error);
        }
    }

    public function testLoginSuccessReturnsUser()
    {
        // Këto të dhëna duhet të ekzistojnë saktë në databazë
        $email = 'test@prova.com';
        $fjalkalimi = 'test123';

        $query = "SELECT * FROM users WHERE email = '$email' AND fjalkalimi = '$fjalkalimi'";
        $result = mysqli_query($this->conn, $query);

        // Testo që gjendet saktësisht një përdorues
        $this->assertEquals(1, mysqli_num_rows($result));
    }

    public function testLoginFailsWithWrongPassword()
    {
        $email = 'test@prova.com';
        $fjalkalimi = 'gabim123';

        $query = "SELECT * FROM users WHERE email = '$email' AND fjalkalimi = '$fjalkalimi'";
        $result = mysqli_query($this->conn, $query);

        // Testo që s’gjendet përdorues me fjalëkalim të gabuar
        $this->assertEquals(0, mysqli_num_rows($result));
    }

    protected function tearDown(): void
    {
        $this->conn->close();
    }
}
