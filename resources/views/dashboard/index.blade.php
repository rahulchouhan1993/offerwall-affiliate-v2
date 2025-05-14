@extends('layouts.default')
@section('content')
<div class="px-[15px] py-[15px]  md:px-[20px] md:py-[20px] lg:px-[30px] lg:py-[30px]">
    <form method="get">
        <div x-data="select" class="flex flex-wrap md-flex-nowrap items-start gap-[15px] justify-end mb-[25px]" @click.outside="open = false">
            <div class="relative w-[100%] sm:w-[200px]">
                <input name="range" class="date-range-profit w-[100%] bg-[#F6F6F6] px-[12px] py-[12px] text-[13px] font-[600] text-[#4D4D4D] border-[1px] border-[#E6E6E6] rounded-[4px] hover:outline-none focus:outline-none" type="text" value="{{ request('range') }}">
            </div>
            
            <div class="relative">
                <button type="submit" class="w-[100px] md:w-[110px] lg:w-[140px] bg-[#4EF953] px-[20px] py-[10px] w-[100px] rounded-[4px] text-[14px] font-[500] text-[#000] text-center">Filter</button>
            </div>
        </div>
    </form>
    <div class="flex flex-wrap md:flex-nowrap items-center gap-[15px] mb-[30px]">
        <div class="graybg flex flex-col justify-center bg-[#4EF953] items-start gap-[5px] w-[100%] sm:w-[200px] md:w-[265px] lg:w-[365px] h-[130px]  rounded-[7px] lg:rounded-[10px]  px-[15px] py-[15px] md:px-[20px] md:py-[20px] xl:px-[30px] xl:py-[30px] activeApps">
            <h2 class="text-[18px] font-[500] text-[#080C0F]">Active Apps</h2>
            <h3 class="text-[25px] lg:text-[25px] xl:text-[38px] lg:text-[25px] xl:text-[38px] font-[700] text-[#080C0F]">{{ $activeApps ?? 0 }}</h3>
        </div>
        <div class="pinkbg flex flex-col justify-center bg-[#4EF953] items-start gap-[5px] w-[100%] sm:w-[200px] md:w-[265px] lg:w-[365px] h-[130px]  rounded-[7px] lg:rounded-[10px]  px-[15px] py-[15px] md:px-[20px] md:py-[20px] xl:px-[30px] xl:py-[30px] activeApps">
            <h2 class="text-[18px] font-[500] text-[#000]">Revenue</h2>
            <h3 class="text-[25px] lg:text-[25px] xl:text-[38px] font-[700] text-[#000]">$ {{ $totalPayouts ?? 0 }}</h3>
        </div>
    </div>

    <div class="bg-[#fff] px-[15px] py-[15px] lg:px-[30px] lg:py-[30px] rounded-[8px] lg:rounded-[10px]">
        <div class="w-full">
            <canvas id="roundedLineChart"></canvas>
        </div>
    </div>
</div> 
<script>
    $(function () {
        var startDate = "{{ $requestedParams['strd'] }}"
        var endDate = "{{ $requestedParams['endd'] }}"
        $('.date-range-profit').daterangepicker({
            ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            autoUpdateInput: true, 
            startDate: startDate, 
            endDate: endDate,
            opens: 'right'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('roundedLineChart').getContext('2d');
    let myChart; // Store chart instance globally

    function fetchChartData() {
        const dateRange = $('.date-range-profit').val();

        fetch(`{{ route('chart.data') }}?date_range=${encodeURIComponent(dateRange)}`)
            .then(response => response.json())
            .then(data => {
                // ✅ Destroy previous chart if it exists
                if (myChart) {
                    myChart.destroy();
                }

                // ✅ Create new chart
                myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels, // Months
                        datasets: [
                            {
                                label: 'Conversions',
                                data: data.conversionData, // Conversion Data
                                borderColor: '#3BDC40', // Deep Purple Border
                                backgroundColor: '#75FF76', // Soft Purple Fill
                                borderWidth: 2,
                                tension: 0.4, // Smooth line effect
                                fill: true,
                                pointRadius: 5,
                                pointBackgroundColor: '#75FF76'
                            },
                            {
                                label: 'Clicks',
                                data: data.clickData, // Clicks Data
                                borderColor: '#8CCEE2', // Red Border
                                backgroundColor: '#7BB7C9',
                                borderWidth: 2,
                                tension: 0.4,
                                fill: true,
                                pointRadius: 5,
                                pointBackgroundColor: '#7BB7C9'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            },
                            tooltip: {
                                enabled: true
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Months'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Count'
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching chart data:', error));
    }

    // Fetch chart data initially
    fetchChartData();

    // ✅ Re-fetch chart data when filters (date range) change
    $('.date-range-profit').on('change', function () {
        //fetchChartData();
    });
});
</script>
@stop