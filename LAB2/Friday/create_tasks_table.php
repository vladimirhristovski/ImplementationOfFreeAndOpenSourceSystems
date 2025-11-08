<?php
$db = new SQLite3(__DIR__ . '/database/task_db.sqlite');

$createTableQuery = <<<SQL
CREATE TABLE IF NOT EXISTS tasks (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    due_date DATE NOT NULL,
    priority TEXT NOT NULL,
    status TEXT NOT NULL
);
SQL;

if ($db->exec($createTableQuery)) {
    echo "Table created successfully.";
} else {
    echo "Error creating table: " . $db->lastErrorMsg();
}

$db->close();