<?php

use PHPUnit\Framework\TestCase;

final class CsvFileTest extends TestCase
{
    private string $tempCsvPath;

    protected function setUp(): void
    {
        $writePath = __DIR__ . '/../writable';
        if (!is_dir($writePath)) {
            mkdir($writePath, 0755, true);
        }
        $this->tempCsvPath = $writePath . '/contacts-test-' . uniqid() . '.csv';
    }

    protected function tearDown(): void
    {
        if (is_file($this->tempCsvPath)) {
            @unlink($this->tempCsvPath);
        }
    }

    public function test_it_creates_csv_with_expected_header(): void
    {
        $handle = fopen($this->tempCsvPath, 'w');
        $this->assertNotFalse($handle, 'Unable to open temporary CSV for writing');
        fputcsv($handle, ['Name', 'Phone', 'Email']);
        fclose($handle);

        $this->assertFileExists($this->tempCsvPath);
        $read = fopen($this->tempCsvPath, 'r');
        $this->assertNotFalse($read, 'Unable to open temporary CSV for reading');
        $header = fgetcsv($read);
        fclose($read);

        $this->assertSame(['Name', 'Phone', 'Email'], $header);
    }

    public function test_it_appends_contact_rows_with_three_columns(): void
    {
        // Initialize file with header
        $handle = fopen($this->tempCsvPath, 'w');
        $this->assertNotFalse($handle);
        fputcsv($handle, ['Name', 'Phone', 'Email']);
        fclose($handle);

        // Append a couple of contacts
        $append = fopen($this->tempCsvPath, 'a');
        $this->assertNotFalse($append);
        fputcsv($append, ['Jane Smith', '555-123-4567', 'jane@example.com']);
        fputcsv($append, ['John Doe', '', 'john@example.com']);
        fclose($append);

        // Read back and verify structure
        $read = fopen($this->tempCsvPath, 'r');
        $this->assertNotFalse($read);
        $header = fgetcsv($read);
        $this->assertSame(['Name', 'Phone', 'Email'], $header);

        $rows = [];
        while (($row = fgetcsv($read)) !== false) {
            $rows[] = $row;
        }
        fclose($read);

        $this->assertCount(2, $rows);
        foreach ($rows as $row) {
            $this->assertCount(3, $row);
        }
        $this->assertSame('Jane Smith', $rows[0][0]);
        $this->assertSame('john@example.com', $rows[1][2]);
    }
}

<?php

use PHPUnit\Framework\TestCase;

final class CsvFileTest extends TestCase
{
    private string $tempCsvPath;

    protected function setUp(): void
    {
        $writePath = __DIR__ . '/../writable';
        if (!is_dir($writePath)) {
            mkdir($writePath, 0755, true);
        }
        $this->tempCsvPath = $writePath . '/contacts-test-' . uniqid() . '.csv';
    }

    protected function tearDown(): void
    {
        if (is_file($this->tempCsvPath)) {
            @unlink($this->tempCsvPath);
        }
    }

    public function test_it_creates_csv_with_expected_header(): void
    {
        $handle = fopen($this->tempCsvPath, 'w');
        $this->assertNotFalse($handle, 'Unable to open temporary CSV for writing');
        fputcsv($handle, ['Name', 'Phone', 'Email']);
        fclose($handle);

        $this->assertFileExists($this->tempCsvPath);
        $read = fopen($this->tempCsvPath, 'r');
        $this->assertNotFalse($read, 'Unable to open temporary CSV for reading');
        $header = fgetcsv($read);
        fclose($read);

        $this->assertSame(['Name', 'Phone', 'Email'], $header);
    }

    public function test_it_appends_contact_rows_with_three_columns(): void
    {
        // Initialize file with header
        $handle = fopen($this->tempCsvPath, 'w');
        $this->assertNotFalse($handle);
        fputcsv($handle, ['Name', 'Phone', 'Email']);
        fclose($handle);

        // Append a couple of contacts
        $append = fopen($this->tempCsvPath, 'a');
        $this->assertNotFalse($append);
        fputcsv($append, ['Jane Smith', '555-123-4567', 'jane@example.com']);
        fputcsv($append, ['John Doe', '', 'john@example.com']);
        fclose($append);

        // Read back and verify structure
        $read = fopen($this->tempCsvPath, 'r');
        $this->assertNotFalse($read);
        $header = fgetcsv($read);
        $this->assertSame(['Name', 'Phone', 'Email'], $header);

        $rows = [];
        while (($row = fgetcsv($read)) !== false) {
            $rows[] = $row;
        }
        fclose($read);

        $this->assertCount(2, $rows);
        foreach ($rows as $row) {
            $this->assertCount(3, $row);
        }
        $this->assertSame('Jane Smith', $rows[0][0]);
        $this->assertSame('john@example.com', $rows[1][2]);
    }
}


