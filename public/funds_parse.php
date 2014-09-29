<?php
#print_r($_SERVER);
#print_r(date("d.m.Y H:i:s"));
#ini_set();
#echo date("Y-m-d H:i:s");
#exit;
/**
 * Format of the file must be CP1251
 */
require __DIR__.'/../bootstrap/autoload.php';
$app = require_once __DIR__.'/../bootstrap/start.php';
$app->run();

setlocale(LC_ALL, 'ru_RU.UTF-8');

#$result = DB::transaction(function() use ($app) {

    ## TRUNCATE
    ArchiveFund::truncate();

    $fund = 0;
    #$lines = file('funds_last.csv', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $lines = file('list-new.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    #Helper::dd(count($lines));

    echo "<table border='1'>";
    $i = 0;
    $current_company_id = NULL;
    $cci = NULL;

    foreach ($lines as $l => $line) {

        ++$i;

        unset($input);

        #Helper::dd($line);
        #list($fund_num, $dates, $org) = explode(';', $line);
        $array = explode(';', $line);
        $fund_num = @$array[0];
        $dates = @$array[1];
        $org = @$array[2];

        $fund_num = trim($fund_num);
        $dates = trim($dates);
        $org = trim($org);

        $fund_num = iconv("CP1251", "UTF-8//IGNORE", $fund_num);
        $org = iconv("CP1251", "UTF-8//IGNORE", $org);

        #Helper::dd("$fund_num, $dates, $org");

        $fund = $fund_num != '' ? $fund_num : $fund;
        if ($fund_num == '') {
            $current_company_id = $cci;
        } else {
            $cci = $i;
            $current_company_id = NULL;
        }
        #$fund = is_numeric($fund_num) ? $fund_num : $fund;
        #$fund = $fund_num ? $fund_num : $fund;
        #$fund_num = mb_convert_encoding($fund_num,'utf8','utf-16');

        #$fund_num = mb_convert_encoding($fund_num, 'utf-8', 'cp1251');

        #var_dump($fund_num); echo " -> ";
        #dd( is_numeric($fund_num) ) ;

        if(
            !$fund_num && !$dates && !$org
            || $fund_num > 751
        )
            continue;

        ## DATES
        $class = 'red';
        $date_start = false;
        $date_stop = false;

        ## 1980-1990
        if (preg_match("~^([\d]{4})\-([\d]{4})$~is", $dates, $matches) && @$matches[1] && @$matches[2]) {
            $date_start = $matches[1] . '-01-01';
            $date_stop = $matches[2] . '-12-31';
            $class = 'green';
            #continue;
        ## 1980
        } else if (preg_match("~^([\d]{4})$~is", $dates, $matches) && @$matches[1]) {
            $date_start = $matches[1] . '-01-01';
            $date_stop = $matches[1] . '-12-31';
            $class = 'green';
            #continue;
        } else if (!$dates || preg_match("~^[\-\?]+?$~is", $dates)) {
            $class = 'green';
            #continue;
        }

        ## ECHO
        echo "<tr class='{$class}'>
            <td>#" . ($i) . "</td>
            <td>{$fund}</td>
            <td>{$current_company_id}</td>
            <td nowrap>{$dates}</td>
            <td nowrap>{$date_start} - {$date_stop}</td>
            <td nowrap>{$org}</td>
        </tr>";

        $input = array(
            'id' => $i,
            'fund_number' => $fund,
            #'name' => mb_convert_encoding($org, 'cp1251', 'utf-8'),
            'name' => $org,
            'current_company_id' => $current_company_id,
            'date_start' => $date_start,
            'date_stop' => $date_stop,
            'parsed' => (int)($date_start && $date_stop),
        );

        ## CREATE

        unset($record);
        $record = ArchiveFund::create($input);

        #$record = ArchiveFund::firstOrCreate($input);

        #$record = new ArchiveFund();
        #$record->save($input);
        #$record->update($input);
        #$last_insert_id = $record->insertGetId($input);
        usleep(500);

        #ArchiveFund::insertGetId()

        #sleep(1);
        #*/

        #/*
        echo "<tr><td colspan='10'>";
        var_dump($input);
        echo "<br/>";
        #print_r($result);
        Helper::ta($record);
        echo "</td></tr>";
        #*/
        #Helper::dd($input);

        unset($record);
    }

#});

echo "</table>";

Helper::d(DB::getQueryLog());

?>
<style>
    .green {background-color:#afa}
    .red {background-color:#faa}
</style>