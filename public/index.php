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
    </head>
    <body>
        <?php
        foreach ($period as $month => $weeks) {
        ?>
            <h3><?php echo $month; ?></h3>
        <table>
            <thead>
                <tr>
                    <th>Sunday</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach ($weeks as $days) {
                    echo '<tr>';

                    foreach ($days as $day) {
                        echo '<td>' . $day . '</td>';
                    }

                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        <?php
        }
        ?>
    </body>
</html>
