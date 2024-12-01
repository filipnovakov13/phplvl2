<?php

class ArrivalsLogger {
    private $filePath;

    public function __construct() {
        $this->filePath = __DIR__ . '/../data/arrivals.json';
    }

    public function logArrival($studentName, $isLate) {
        $arrivals = $this->getArrivals();

        $status = $isLate ? 'Late' : 'On time';
        $currentDateTime = date("jS F Y, H:i:s P T");

        $arrivals[] = [
            'studentName' => $studentName,
            'time' => $currentDateTime,
            'status' => $status,
        ];

        file_put_contents($this->filePath, json_encode($arrivals, JSON_PRETTY_PRINT));
        if ($status == "On time") {
        echo "<div class=\"success\">Arrival logged: $studentName - $status<br></div>";
        } else {
            echo "<div class=\"late\">Arrival logged: $studentName - $status<br></div>";
        }
    }

    public function getArrivals() {
        if (file_exists($this->filePath)) {
            return json_decode(file_get_contents($this->filePath), true) ?: [];
        }

        return [];
    }

    private function isLate() {
        $currentHour = (int) date("H");
        $currentMinute = (int) date("i");

        return $currentHour > 8 || ($currentHour === 8 && $currentMinute > 0);
    }

    private function checkLateNightArrival() {
        $currentHour = (int) date("H");

        if ($currentHour >= 20 && $currentHour < 24) {
            die("<div class=\"error\">Error: Late-night arrivals (between 20:00 and midnight) cannot be logged.<br></div>");
        }
    }

    public function logStudentArrival($studentName) {

        $this->checkLateNightArrival();
        $isLate = $this->isLate();
        $this->logArrival($studentName, $isLate);
    }
}
