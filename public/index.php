<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Carbon\Carbon;

$period = [];
$week = 0;
$dayOfWeek = 0;

for ($month = 1; $month <= 12; $month++) {
    $start = Carbon::createFromFormat('m', $month)->startOfMonth();
    $end = Carbon::createFromFormat('m', $month)->endOfMonth();
    $monthName = $start->monthName;

    while ($start->lte($end)) {
        $period[$monthName][$week][$start->dayOfWeek] = $start->day;

        $start->addDay();
        if (count($period[$monthName][$week]) > 6 || $start->dayOfWeek == 0) {
            for ($i = 0; $i <= 6; $i++) {
                if (! isset($period[$monthName][$week][$i])) {
                    $period[$monthName][$week][$i] = null;
                }
            }

            ksort($period[$monthName][$week]);

            $week++;
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>2023 Calendar &raquo; ohchiko</title>

        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        <?php
        foreach ($period as $month => $weeks) {
        ?>
            <div style="page-break-after: always; display: flex; flex-direction: column; max-height: 148mm; padding: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 1rem;">
                    <figure>
                        <q>Sometimes, there is some times.</q>
                        <figcaption>Somebody, at time.</figcaption>
                    </figure>
                    <h1><?php echo $month; ?></h1>
                </div>
                <div class="table">
                    <div class="thead">
                        <div class="tr">
                            <div class="th">Sunday</div>
                            <div class="th">Monday</div>
                            <div class="th">Tuesday</div>
                            <div class="th">Wednesday</div>
                            <div class="th">Thursday</div>
                            <div class="th">Friday</div>
                            <div class="th">Saturday</div>
                        </div>
                    </div>

                    <div class="tbody">
                        <?php
                        foreach ($weeks as $days) {
                            echo '<div class="tr">';

                            foreach ($days as $day) {
                                echo '<div class="td">' . $day . '</div>';
                            }

                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </body>
</html>
