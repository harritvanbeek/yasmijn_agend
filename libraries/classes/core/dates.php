<?php 
namespace classes\core;

defined('_BOANN') or header("Location:{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["SERVER_NAME"]}");

class dates {
    
    public function translateDays(){
        $this->array = [
            "Monday"            => "Maandag",
            "Tuesday"           => "Dinsdag",
            "Wensday"           => "Woensdag",
            "Thursday"          => "Donderdag",
            "Friday"            => "Vrijdag",
            "Saturday"          => "Zaterdag",
            "Sunday"            => "Zondag",
        ];

        return $this->array;
    }

    public function translateMonth(){
        $this->array = [
            "January"               => "Januari",
            "February"              => "Februari",
            "March"                 => "Maart",
            "April"                 => "April",
            "May"                   => "Mei",
            "June"                  => "Juni",
            "July"                  => "Juli",
            "August"                => "Augustus",
            "September"             => "September",
            "October"               => "Oktober",
            "November"              => "November",
            "December"              => "December",
        ];

        return $this->array;
    }
        //afkortingen
    public function translateDays_short(){
            $this->array = [
                "Mon"            => "Ma",
                "Tue"           => "Di",
                "Wed"           => "Wo",
                "Thu"          => "Do",
                "Fri"            => "Vr",
                "Sat"          => "Za",
                "Sun"            => "Zo",
            ];
    
            return $this->array;
    }
    
    public function translateMonth_short(){
            $this->array = [
                "Jan"               => "Jan",
                "Feb"              => "Feb",
                "Mar"                 => "Mrt",
                "Apr"                 => "Apr",
                "May"                   => "Mei",
                "June"                  => "Jun",
                "July"                  => "Jul",
                "Aug"                => "Aug",
                "Sep"             => "Sept",
                "Oct"               => "Okt",
                "Nov"              => "Nov",
                "Dec"              => "Dec",
            ];

        return $this->array;
    }
}