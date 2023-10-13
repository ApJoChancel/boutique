<?php

    if(!function_exists('formatNombre')){
        function formatNombre(string $nombre, string $separateur = ' '): string
        {
            return number_format($nombre, 0, ',', $separateur);
        }
    }
