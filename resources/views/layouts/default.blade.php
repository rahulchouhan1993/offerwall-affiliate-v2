<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="Googlebot-News" content="noindex, nnofollow">
	    <meta name="googlebot" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>XXX-Affiliate | {{ $pageTitle }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts -->
        <link rel="icon" type="image/x-icon" href="/images/favicon.png">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"rel="stylesheet"/>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js']) 
        @endif
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="loader-fcustm fixed inset-0 flex flex-col items-center justify-center bg-white bg-opacity-75 backdrop-blur-md z-50">
            <div class="w-10 h-10 border-4 border-[#D272D2] border-t-transparent rounded-full animate-spin"></div>
            <p class="mt-4 text-lg font-semibold text-[#D272D2]">Loading...</p>
        </div>
        <script>
            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif
        
            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif
        </script>
        @include('layouts.header')
        <div class="pt-[50px] md:pt-[80px] flex dashboardMain">
            @include('layouts.sidebar')
            <div class="dashboardContainer bg-[#F2F2F2]  pb-[100px]">
                @yield('content')
                @include('layouts.footer')
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const button = document.getElementById('menuToggle');

                button.addEventListener('click', function() {
                    document.body.classList.toggle('active');
                });
            });

            document.addEventListener("DOMContentLoaded", function() {
                window.onload = function() {
                    $('.loader-fcustm').fadeOut(1000)
                };
            });
            $(document).ready(function() {
                $('.sel2fld').select2({
                    placeholder: "Select an option",
                    allowClear: true // Adds a clear (X) button
                });
            });
            
            $(function() {
                $('.dateRange').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(6, 'days'),  // Default start date (7 days ago)
                    endDate: moment(),  
                    opens: 'right'
                }, function(start, end, label) {
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                });
            });
        </script>

        <!-- Tabbing -->
        <script>
  const buttons = document.querySelectorAll('.tab-button');
  const contents = document.querySelectorAll('.tab-content');

  function activateTab(index) {
    // Hide all contents
    contents.forEach(content => content.classList.add('hidden'));
    contents[index].classList.remove('hidden');

    // Remove active styles from all buttons
    buttons.forEach(btn => btn.classList.remove('border-blue-500', 'bg-[#d272d2]', 'text-[#fff]', 'font-semibold'));

    // Add active styles to the clicked button
    buttons[index].classList.add('border-blue-500', 'bg-[#d272d2]', 'text-[#fff]', 'font-semibold');
  }

  // Initialize first tab as active
  activateTab(0);

  buttons.forEach((button, index) => {
    button.addEventListener('click', () => activateTab(index));
  });
</script>
    </body>
</html>