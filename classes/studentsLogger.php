<?php

class StudentsLogger {
    private static $filePath = __DIR__ . '/../data/students.json';

    public static function logStudent($studentName) {
        $students = self::getStudents();

        if (!isset($students[$studentName])) {
            $students[$studentName] = ['arrivalCount' => 0];
        }

        $students[$studentName]['arrivalCount']++;

        file_put_contents(self::$filePath, json_encode($students, JSON_PRETTY_PRINT));
        echo "<div class=\"success\">Student $studentName logged successfully.<br></div>";
    }

    public static function getStudents() {
        if (file_exists(self::$filePath)) {
            return json_decode(file_get_contents(self::$filePath), true) ?: [];
        }

        return [];
    }
}
