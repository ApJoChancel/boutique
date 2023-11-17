<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Page Title' }}</title>

    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="h-screen overflow-hidden flex items-center justify-center" style="background: #edf2f7;">
    <div class="bg-blue-400 h-screen w-screen">
        <div class="flex flex-col items-center flex-1 h-full justify-center px-4 sm:px-0">
            <div class="flex rounded-lg shadow-lg w-full sm:w-3/4 lg:w-1/2 bg-white sm:mx-0" style="height: 500px">
                <div class="flex flex-col w-full md:w-1/2 p-4">
                    <div class="flex flex-col flex-1 justify-center mb-8">
                        <h1 class="text-4xl text-center font-thin">Bienvenue</h1>
                        <div class="w-full mt-4">
                            {{ $slot }}
                        </div>
                    </div>
                    <div id="maposition"></div>
                </div>
                <div class="hidden md:block md:w-1/2 rounded-r-lg" style="background: url('https://images.unsplash.com/photo-1515965885361-f1e0095517ea?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=3300&q=80'); background-size: cover; background-position: center center;"></div>
            </div>
        </div>
    </div>
    @livewireScripts
    <script>
        navigator.geolocation.getCurrentPosition(succesGeo,erreurGeo,{maximumAge:120000});
        
        function succesGeo(position)
        {
            var latitude = document.getElementById('latitude');
            var longitude = document.getElementById('longitude');
            latitude.value = position.coords.latitude;
            longitude.value = position.coords.longitude;
            
            var latYaounde = 3.89372420310974;
            var longYaounde = 11.5228548049927;
            
            var latDouala = 4.05276870727539;
            var longDouala = 9.70424365997314;
            
            // var infopos = "position déterminée : <br>"; 

            // infopos += "Latitude : " +latitude.value + "<br>";
            // infopos += "Longitude : " +longitude.value + "<br>";
            // infopos += "Distance Yaounde : " +
            //     getDistanceBetweenPoints(latitude.value, longitude.value, latYaounde, longYaounde) + "<br>";
            // infopos += "Distance Douala : " +
            //     getDistanceBetweenPoints(latitude.value, longitude.value, latDouala, longDouala) + "<br>";
            // infopos += "Distance Autre : " +
            //     getDistanceBetweenPoints(3.873659, 11.515614, latYaounde, longYaounde) + "<br>";
            // document.getElementById('maposition').innerHTML = infopos;
        }

        function erreurGeo(error)
        {
            var info = "Erreur lors de la géolocalisation : ";
            switch(error.code) {
                case error.TIMEOUT:
                    info += "Timeout !";
                     break;
                case error.PERMISSION_DENIED:
                    info += "Vous n’avez pas donné la permission";
                    break;
                case error.POSITION_UNAVAILABLE:
                    info += "La position n’a pu être déterminée";
                    break;
                case error.UNKNOWN_ERROR:
                    info += "Erreur inconnue";
                    break;
            }
            document.getElementById("maposition").innerHTML = info;
        }

        function getDistanceBetweenPoints(latitude1, longitude1, latitude2, longitude2)
        {
            let theta = longitude1 - longitude2;
            let distance = 60 * 1.1515 * (180/Math.PI) * Math.acos(
                Math.sin(latitude1 * (Math.PI/180)) * Math.sin(latitude2 * (Math.PI/180)) +
                Math.cos(latitude1 * (Math.PI/180)) * Math.cos(latitude2 * (Math.PI/180)) *
                Math.cos(theta * (Math.PI/180))
            );
            //EN km
            // return Math.round(distance * 1.609344, 2);
            //EN m
            return Math.round(distance * 1609.344, 2);
        }
    </script>
</body>
</html>