<?php

use PHPUnit\Framework\TestCase;

class GradesTest extends TestCase
{
    protected $conn;

    protected function setUp(): void
    {
        $this->conn = new mysqli("127.0.0.1", "root", "", "edunotes", 3307);
        if ($this->conn->connect_error) {
            die("Lidhja deshtoi: " . $this->conn->connect_error);
        }
    }

    public function testInsertAllGradesSuccessfully()
    {
        $nxenesi_id = 999; // test nxënës
        $lenda_id = 1;
        $nota1 = 5;
        $nota2 = 4;
        $nota_perfundimtare = 5;
        $periudha = 'Periudha 2';

        // Sigurohemi që nxënësi test ekziston
        mysqli_query($this->conn, "INSERT IGNORE INTO nxenesit (id, emri, mbiemri) VALUES (999, 'Test', 'Nxenesi')");

        // Shto notën
        $query = "INSERT INTO notat (nxenesi_id, lenda_id, nota1, nota2, nota_perfundimtare, periudha) 
                  VALUES ($nxenesi_id, $lenda_id, $nota1, $nota2, $nota_perfundimtare, '$periudha')";
        $result = mysqli_query($this->conn, $query);

        $this->assertTrue($result);

        // Kontrollojm që ekziston me të gjitha notat
        $verify = mysqli_query(
            $this->conn,
            "SELECT * FROM notat 
             WHERE nxenesi_id = $nxenesi_id AND lenda_id = $lenda_id 
             AND nota1 = $nota1 AND nota2 = $nota2 AND nota_perfundimtare = $nota_perfundimtare"
        );

        $this->assertEquals(1, mysqli_num_rows($verify));

        // Pastrohet pas testit
        mysqli_query($this->conn, "DELETE FROM notat WHERE nxenesi_id = $nxenesi_id AND lenda_id = $lenda_id");
    }

    protected function tearDown(): void
    {
        $this->conn->close();
    }
}
