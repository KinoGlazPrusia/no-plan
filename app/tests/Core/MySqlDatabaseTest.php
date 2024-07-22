<?php
namespace Tests\Core;

use PHPUnit\Framework\TestCase;
use App\Core\Infrastructure\Database\MySqlDatabase;

class MySqlDatabaseTest extends TestCase {
    private MySqlDatabase $db;

    public function setUp(): void {
        $this->db = new MySqlDatabase();
    }

    public function testDatabaseCanStablishConnection(): void
    {
        $this->assertTrue($this->db->connect());
    }
}