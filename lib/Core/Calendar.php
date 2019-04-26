<?php

namespace DND\Core;

class Calendar {

    private $time;
    private $day;
    private $month;
    private $year;
    private $moons;
    private $months;

    public function __construct() {
        $this->time = new \DateTime();
        $this->day = 1;
        $this->month = 1;
        $this->year = 1472;
        $this->moons = [
            '1' => [0 => 'increasing'],
            '2' => [0 => 'increasing']
        ];
        for ($i = 1; $i < 28; $i++) {
            if (0 <= $i && $i <= 3)
                $this->moons[1][$i] = 'full';
            if (3 < $i && $i <= 14)
                $this->moons[1][$i] = 'decreasing';
            if (14 < $i && $i <= 17)
                $this->moons[1][$i] = 'new';
            if (17 < $i && $i <= 28)
                $this->moons[1][$i] = 'increasing';

            if (0 <= $i && $i <= 4)
                $this->moons[2][$i] = 'increasing';
            if (4 < $i && $i <= 10)
                $this->moons[2][$i] = 'full';
            if (10 < $i && $i <= 14)
                $this->moons[2][$i] = 'decreasing';
            if (14 < $i && $i < 20)
                $this->moons[2][$i] = 'new';
        }

        $this->months = [
            '1' => 'Lenden',
            '2' => 'Unor',
            '3' => 'Duben',
            '4' => 'Dhen',
            '5' => 'Iowar',
            '6' => 'Ebrill',
            '7' => 'Midil',
            '8' => 'Hydref',
            '9' => 'Luglio',
            '10' => 'Awissu',
            '11' => 'Ludnar',
            '12' => 'Jannar',
            '13' => 'Oout',
            '14' => 'Desam'
        ];
    }

    function getTime() {
        if (!is_object($this->time))
            return array('hour' => 0, 'minute' => 0);
        return array('hour' => $this->time->format('H'), 'minute' => $this->time->format('i'));
    }

    function getDay() {
        return $this->day;
    }

    function getMonth() {
        return $this->month;
    }

    function getYear() {
        return $this->year;
    }

    function getMoons() {
        return $this->moons;
    }

    function getMonths() {
        return $this->months;
    }

    function setTime($hour, $minute) {
        if (!is_object($this->time))
            $this->time = new \DateTime;
        $this->time->setTime($hour, $minute, 0);
        return $this;
    }

    function setDay($day) {
        $this->day = $day;
        return $this;
    }

    function setMonth($month) {
        $this->month = $month;
        return $this;
    }

    function setYear($year) {
        $this->year = $year;
        return $this;
    }

    function setMoons($moons) {
        $this->moons = $moons;
        return $this;
    }

    function setMonths($months) {
        $this->months = $months;
        return $this;
    }

    public function addHour($hour = 1) {
        $td = $this->time->format('d');
        $this->time->modify('+ 1 hour');
        if ($td != $this->time->format('d')) { // Anderer Tag
            $this->addDay();
        }
    }

    public function addDay($days = 1) {
        if ($days == 0)
            return;
        if ($days < 0)
            throw new Exception("Days must be a number and larger or equal 0");

        $addMonths = floor($days / 30);
        $addReal = $days % 30;

        if ($addReal + $this->day > 30) {
            $addMonths++;
            $this->day = ($addReal + $this->day) % 30;
        } else {
            $this->day += $addReal;
        }
        $this->addMonth($addMonths);
    }

    public function addMonth($month = 1) {
        if ($month == 0)
            return;
        if ($month < 0)
            throw new Exception("Days must be a number and larger or equal 0");

        $addYears = floor($month / 14);
        $addReal = $month % 14;

        if ($addReal + $this->month > 14) {
            $addYears++;
            $this->month = ($addReal + $this->month) % 14;
        } else {
            $this->month += $addReal;
        }
        $this->addYear($addYears);
    }

    public function addYear($year = 1) {
        if ($year == 0)
            return;
        if ($year < 0)
            throw new Exception("Days must be a number and larger or equal 0");

        $this->year += $year;
    }

    public function subHour($hour = 1) {
        $td = $this->time->format('d');
        $this->time->modify('- 1 hour');
        if ($td != $this->time->format('d')) { // Anderer Tag
            $this->subDay();
        }
    }

    public function subDay($days = 1) {
        if ($days == 0)
            return;
        if ($days < 0)
            throw new Exception("Days must be a number and larger or equal 0");

        $subMonths = floor($days / 30); // Monate die Abgezogen werden
        $restAbzug = $days % 30;
        if ($restAbzug >= $this->day) {
            $subMonths++;
            $this->day = 30 - ($this->day - $restAbzug);
        } else {
            $this->day -= $restAbzug;
        }

        $this->subMonth($subMonths);
    }

    public function subMonth($month = 1) {
        if ($month == 0)
            return;
        if ($month < 0)
            throw new Exception("Month must be a number and larger or equal 0");

        $subYears = floor($month / 30); // Monate die Abgezogen werden
        $restAbzug = $month % 14;
        if ($restAbzug >= $this->month) {
            $subYears++;
            $this->month = 14 - ($this->month - $restAbzug);
        } else {
            $this->month -= $restAbzug;
        }

        $this->subYear($subYears);
    }

    public function subYear($year = 1) {
        if ($year == 0)
            return;
        if ($year < 0)
            throw new Exception("Year must be a number and larger or equal 0");

        $this->year -= $year;
    }

    public function getDate() {
        return [
            'time' => $this->time->format('H:i'),
            'day' => $this->day,
            'month' => $this->month,
            'monthWord' => $this->months[$this->month],
            'year' => $this->year,
            'moon1' => $this->getMoonState(1),
            'moon2' => $this->getMoonState(2)
        ];
    }

    public function getMoonState($moonNr = 1) {
        $cnt = count($this->moons[$moonNr]);
        $idx = (($this->day + ($this->month * 30)) % $cnt);

        return $this->moons[$moonNr][$idx];
    }

}
