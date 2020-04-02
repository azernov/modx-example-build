<?php
$time = $input;

$months = array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
$monthsShort = array('янв','фев','мар','апр','май','июн','июл','авг','сен','окт','ноя','дек');

$day = date('d',$time);
$monthNumber = date('n',$time);
$year = date('Y',$time);
$hour = date('H',$time);
$minute = date('i',$time);

return str_replace(array("{day}","{monthName}","{monthShort}","{month}","{year}","{hour}","{minute}"),array($day,$months[$monthNumber-1],$monthsShort[$monthNumber-1],$monthNumber,$year,$hour,$minute),$options);