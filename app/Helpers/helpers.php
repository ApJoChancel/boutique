<?php
    if(!function_exists('formatNombre')){
        function formatNombre(string $nombre, string $separateur = ' '): string
        {
            return number_format($nombre, 0, ',', $separateur);
        }
    }

    if(!function_exists('formatDateLong')){
        function formatDateLong(string $date_str): string
        {
            $semaine = [
                "Dim",
                "Lun",
                "Mar",
                "Mer",
                "Jeu", 
                "ven",
                "sam"
            ];
            $mois = [
                1 => "jan",
                "fév",
                "mar",
                "avr",
                "mai",
                "jui",
                "jui",
                "aoû",
                "sep",
                "oct",
                "nov",
                "déc"
            ];
            $sem = date('w', strtotime($date_str));
            $jour = date('j', strtotime($date_str));
            $mo = date('n', strtotime($date_str));
            $an = date('Y', strtotime($date_str));
            return "{$semaine[$sem]} {$jour} {$mois[$mo]} {$an}";
        }
    }

    if(!function_exists('formatDateCourte')){
        function formatDateCourte(string $date_str): string
        {
            $semaine = [
                "Dim",
                "Lun",
                "Mar",
                "Mer",
                "Jeu", 
                "ven",
                "sam"
            ];
            $mois = [
                1 => "jan",
                "fév",
                "mar",
                "avr",
                "mai",
                "jui",
                "jui",
                "aoû",
                "sep",
                "oct",
                "nov",
                "déc"
            ];
            $jour = date('j', strtotime($date_str));
            $mo = date('n', strtotime($date_str));
            $an = date('Y', strtotime($date_str));
            return "{$jour} {$mois[$mo]} {$an}";
        }
    }
