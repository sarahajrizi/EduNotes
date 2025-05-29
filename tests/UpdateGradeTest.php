<?php

use PHPUnit\Framework\TestCase;

class UpdateGradeTest extends TestCase
{
    protected $conn;
    protected $notaId;

    protected function setUp(): void
    {
        $this->conn = new mysqli("127.0.0.1", "root", "", "edunotes", 3307);
        if ($this->conn->connect_error) {
            die("Lidhja dështoi: " . $this->conn->connect_error);
        }

        // Shto notën fillestare për testim
        $insert = "INSERT INTO notat (nxenesi_id, lenda_id, nota1, periudha) 
                   VALUES (999, 1, 5, 'Periudha 2')";
        mysqli_query($this->conn, $insert);

        // Ruaj ID e notës së fundit të futur
        $this->notaId = mysqli_insert_id($this->conn);
    }

    public function testUpdateNota1()
    {
        // Bëj UPDATE nga 5 në 4
        $update = "UPDATE notat SET nota1 = 4 WHERE id = $this->notaId";
        $result = mysqli_query($this->conn, $update);

        $this->assertTrue($result);

        // Verifiko që është përditësuar
        $check = mysqli_query($this->conn, "SELECT nota1 FROM notat WHERE id = $this->notaId");
        $row = mysqli_fetch_assoc($check);

        $this->assertEquals(4, (int) $row['nota1']);
    }

    protected function tearDown(): void
    {
        // Fshi notën pas testit
        mysqli_query($this->conn, "DELETE FROM notat WHERE id = $this->notaId");
        $this->conn->close();
    }
}
