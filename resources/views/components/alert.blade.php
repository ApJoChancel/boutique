<div class="container" id="alertbox">
    <div class="container flex items-center text-sm font-bold px-4 py-3 relative" role="alert" style="background-color: {{ $color }};height:40px;color:white">
        <p>{{ $alert }}</p>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 closealertbutton">
            <svg class="fill-current h-6 w-6" role="button" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <title>Fermer</title>
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
            </svg>
        </span>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"
	integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous">
	</script>

    <script>
        $(".closealertbutton").click(function (e) {
            // $('.alertbox')[0].hide()
            // e.preventDefault();
            pid = $(this).parent().parent().hide(500)
            //console.log(pid)
            // $(".alertbox", this).hide()
        })
    </script>