<?php

$layoutDate = "%d-%d-01";

$currentYear = date('Y', time());

$currentMonth = date('n', time());

$monthDayCount = date('t', time());

$startMonthDate = sprintf($layoutDate, $currentYear, $currentMonth);    //Set month begin

$startMonthDay = date('w', strtotime($startMonthDate));     //Get the first day of month

$startMonthDay--;                                           //Want to day begins from 0 to 6

print("\nCurrent Month - July\n\n");

print("Mon\tTue\tWed\tThu\tFri\tSat\tSun\n");

for( $i = 0; $i < $startMonthDay; $i++ )
    print("\t");                                            //indent

for($day = 1; $day < $monthDayCount + 1 ; ++$day)
{
    if( !( ($day + $startMonthDay - 1) % 7) )               //If end of the week, next line
        print "\n";
    print "$day\t";
}

print("\n\n");

$date = date('D d/m/Y', time());

print "Current Date - $date\n";