<?php

require_once __DIR__ . '/classes/StudentsLogger.php';
require_once __DIR__ . '/classes/ArrivalsLogger.php';

require_once __DIR__ . '/templates/form.html';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['studentName'])) {
    $studentName = htmlspecialchars(trim($_POST['studentName']));

    // Log the student's arrival
    $arrivalsLogger = new ArrivalsLogger();
    $arrivalsLogger->logStudentArrival($studentName);

    // Log the student's record in students.json
    StudentsLogger::logStudent($studentName);

    // Display all students
    echo "<h3>All Students:</h3>";
    echo "<pre>";
    print_r(StudentsLogger::getStudents());
    echo "</pre>";

    // Display all arrivals
    echo "<h3>All Arrivals:</h3>";
    echo "<pre>";
    print_r($arrivalsLogger->getArrivals());
    echo "</pre>";
}
?>
