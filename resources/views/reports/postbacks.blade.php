@extends('layouts.default')
@section('content')
@php
   use Illuminate\Support\Facades\Http;
@endphp
<div class="bg-[#f2f2f2] p-[15px] lg:p-[35px]">
    <div class="bg-[#fff] p-[15px] md:p-[20px] rounded-[10px] mb-[20px]">
       <div class="flex items-center justify-between gap-[25px] w-[100%]  mb-[15px]">
          <h2 class="text-[20px] text-[#1A1A1A] font-[600]">Overview</h2>
          <button class="w-[100px] md:w-[110px] lg:w-[140px] bg-[#D272D2] px-[20px] py-[10px] w-[100px] rounded-[4px] text-[14px] font-[500] text-[#fff] text-center" id="exportCsvBtn">Export</button>
       </div>
       <form method="get" id="postbackForm">

        <div class="w-full flex flex-col gap-[10px]">
            

            <div class="w-[100%] flex flex-col lg:flex-row items-start lg:items-center justify-start gap-[10px]">
                <label class="min-w-[160px] w-[100%] md:w-[10%] text-[14px] font-[500] text-[#898989] ">Range:</label>
                <input type="text" name="range"  class="dateRange-report w-[100%] bg-[#F6F6F6] px-[15px] py-[12px] text-[12px] font-[600] text-[#4D4D4D] border-[1px] border-[#E6E6E6] rounded-[4px] hover:outline-none focus:outline-none" placeholder="Date" value="{{ $requestedParams['range'] ?? '' }}">
            </div>
        
            <div class="w-[100%] flex flex-col lg:flex-row items-start lg:items-center justify-start gap-[10px]">
                <label class="min-w-[160px] w-[100%] md:w-[10%] text-[14px] font-[500] text-[#898989] ">Apps:</label>
                <select name="appid" class="appendAffiliateApps w-[100%] xl:w-[90%] bg-[#F6F6F6] px-[15px] py-[12px] text-[14px] font-[600] text-[#4D4D4D] border-[1px] border-[#E6E6E6] rounded-[4px] hover:outline-none focus:outline-none">
                   <option value="" >Select</option>
                   @if($allAffiliatesApp && $allAffiliatesApp->isNotEmpty())
                      @foreach ($allAffiliatesApp as $affiliateApp)
                         <option value="{{ $affiliateApp->id }}" @if(isset($requestedParams['appid'])==$affiliateApp->id) selected @endif>{{ $affiliateApp->appName }}</option>
                      @endforeach
                   @endif
                </select>
            </div>


        <div class="w-[100%] flex items-center flex-wrap justify-start lg:flex-nowrap gap-[10px]">
                <label class="min-w-[160px] w-[10%] text-[14px] font-[500] text-[#898989] ">Filter by:</label>
                <div class="w-[100%] xl:w-[90%] flex flex-wrap xl:flex-nowrap  items-center gap-[5px] md:gap-[8px] lg:gap-[10px] xl:gap-[15px]">
                   <div class="relative w-[100%] xl:w-[80%] flex flex-wrap xl:flex-nowrap items-center gap-[10px]">
                   <div class="flex flex-wrap md:flex-nowrap items-start gap-[10px] w-[100%] xl:w-[33%]">
                <div class="w-[100%]">
                    <select name="status" class="filterByStatus bg-[#F6F6F6] px-[15px] py-[12px] text-[12px] font-[500] text-[#808080] border-[1px] border-[#E6E6E6] rounded-[4px] hover:outline-none focus:outline-none">
                        <option value="">Select</option>
                        <option value="200" @if(isset($requestedParams['status']) && $requestedParams['status']==200) selected @endif>Success</option>
                        <option value="500" @if(isset($requestedParams['status']) && $requestedParams['status']==500) selected @endif>Failed</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-wrap md:flex-nowrap items-start gap-[10px] w-[100%] xl:w-[33%]">
                <div class="w-[100%]">
                    <select class="search-postback-filter w-[100%] bg-[#F6F6F6] px-[15px] py-[12px] text-[14px] font-[600] text-[#4D4D4D] border-[1px] border-[#E6E6E6] rounded-[4px] hover:outline-none focus:outline-none" name="offer">
                        <option value="">Select Offer </option>
                        @foreach ($allOffers as $offerKey => $offerName)
                        <option value="{{ $offerKey }}"@if(isset($requestedParams['offer']) && $requestedParams['offer']==$offerKey) selected @endif>{{ $offerName }}</option>
                     @endforeach
                    </select>
                </div>
            </div>
            <div class="flex flex-wrap md:flex-nowrap items-start gap-[10px] w-[100%] xl:w-[33%]">
                <div class="w-[100%]">
                    <input type="text" name="goal"  class="goal-postback-filter w-[100%] bg-[#F6F6F6] px-[15px] py-[12px] text-[12px] font-[500] text-[#808080] border-[1px] border-[#E6E6E6] rounded-[4px] hover:outline-none focus:outline-none" placeholder="Goal Name" value="{{ $requestedParams['goal'] ?? '' }}">
                </div>
            </div>
                   </div>
                   <div class="w-[100%] xl:w-[20%] flex items-center justify-start xl:justify-between gap-[10px]">
                    <button class="w-[80px] md:w-[90px] lg:w-[100px] xl:w-[130px] 2xl:w-[140px] bg-[#D272D2] px-[3px] py-[12px] w-[100px] rounded-[4px] text-[14px] font-[500] text-[#fff] text-center">Apply</button>
                        <a href="{{ route('report.postbacks') }}" class="w-[80px] md:w-[90px] lg:w-[100px] xl:w-[130px] 2xl:w-[140px] bg-[#F5EAF5] px-[20px] py-[10px] w-[100px] border border-[#FED5C3] rounded-[4px] text-[14px] font-[500] text-[#D272D2] text-center">Clear</a>
                   </div>
                </div></div>
             </div>




    </form>
    @php
      $exportedData = [
            'heading' => [
               '0' => 'Postback URL',
               '1' => 'Conversion Id',
               '2' => 'Offer',
               '3' => 'Goal',
               '4' => 'Status',
               '5' => 'Payouts',
               '6' => 'Goal',
               '7' => 'Payout',
               '8' => 'HTTP code',
               '9' => 'Error',
               '10' => 'Date',
               '11' => 'Id',
            ],
            'data' => []
         ]; 
       @endphp
       <div class="flex flex-col justify-between items-center gap-[5px] w-[100%] mt-[30px] ">
          <div class="w-[100%] overflow-x-scroll tableScroll">
             <table class="w-[100%] border-collapse border-spacing-0 rounded-[10px] border-separate border border-[#E6E6E6]">
                <tr>
                   <th class="bg-[#F6F6F6] rounded-tl-[10px] text-[10px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap ">Postback URL</th>
                   <th class="bg-[#F6F6F6] rounded-tl-[10px] text-[10px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap ">Conversion ID</th>
                   <th class="bg-[#F6F6F6] rounded-tl-[10px] text-[10px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap ">Offer</th>
                   <th class="bg-[#F6F6F6] rounded-tl-[10px] text-[10px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap ">Goal</th>
                   <th class="bg-[#F6F6F6] rounded-tl-[10px] text-[10px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap ">Status</th>
                   <th class="bg-[#F6F6F6] rounded-tl-[10px] text-[10px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap ">Payouts</th>
                   
                   <th class="bg-[#F6F6F6] rounded-tl-[10px] text-[10px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap ">HTTP code</th>
                   <th class="bg-[#F6F6F6] rounded-tl-[10px] text-[10px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap ">Error</th>
                   <th class="bg-[#F6F6F6] rounded-tl-[10px] text-[10px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap ">Date</th>
                   <th class="bg-[#F6F6F6] rounded-tl-[10px] text-[10px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap ">ID</th>
                </tr>
                @if($allPostbacks->isNotEmpty()) 
                @foreach ($allPostbacks as $key => $postBacks)
                @php
                  $url = $advertiserDetails->affise_endpoint . "offer/".$postBacks->offer_id;
                  $response = HTTP::withHeaders([
                        'API-Key' => $advertiserDetails->affise_api_key,
                  ])->get($url);
                  if ($response->successful()) {
                     $offerDetail = $response->json();
                     $offerName = $offerDetail['offer']['title'];
                  }else{
                     $offerName = 'N/A';
                  }
                @endphp
                <tr>
                   <td class="text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap  border-b-[1px] border-b-[#E6E6E6]">{{  $postBacks->postback_url ?? 'N/A' }}</td>
                   @php $exportedData['data'][$key]['postback'] = $postBacks->postback_url ?? 'N/A'; @endphp
                   <td class=" whitespace-normal breakword text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  border-b-[1px] border-b-[#E6E6E6] ">{{ $postBacks->conversion_id }}</td>
                   @php $exportedData['data'][$key]['conversion_id'] = $postBacks->conversion_id ?? '0'; @endphp
                   <td class=" whitespace-normal breakword text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  border-b-[1px] border-b-[#E6E6E6] ">{{ $offerName }}</td>
                   @php $exportedData['data'][$key]['offerName'] = $offerName ?? 'N/A'; @endphp
                   <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap border-b-[1px] border-b-[#E6E6E6]">{{ $postBacks->goal }}</td>
                   @php $exportedData['data'][$key]['goal'] = $postBacks->goal ?? 'N/A'; @endphp
                   @if($postBacks->http_code=='200')
                   <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap border-b-[1px] border-b-[#E6E6E6]">
                      <div class="inline-flex bg-[#F3FEE7] border border-[#BCEE89] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#6EBF1A] text-center uppercase">Success</div>
                   </td>
                   @php $exportedData['data'][$key]['status'] = 'Success'; @endphp
                   @else
                   <td class=" whitespace-normal breakword text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left border-b-[1px] border-b-[#E6E6E6]">
                     <div class="inline-flex bg-[#FFE7ED] border border-[#FFA6BC] rounded-[5px] px-[8px] py-[4px] text-[10px] font-[600] text-[#F23765] text-center uppercase">Failed</div>
                   </td>
                   @php $exportedData['data'][$key]['status'] = 'Failed'; @endphp
                   @endif
                   <td class=" whitespace-normal breakword text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left border-b-[1px] border-b-[#E6E6E6]">{{ $postBacks->payout ?? 'N/A'; }}</td>
                   @php $exportedData['data'][$key]['payout'] = $postBacks->payout ?? 'N/A'; @endphp
                   <td class=" whitespace-normal breakword text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left border-b-[1px] border-b-[#E6E6E6]">{{ $postBacks->http_code ?? 'N/A'; }}</td>
                   @php $exportedData['data'][$key]['http_code'] = $postBacks->http_code ?? 'N/A'; @endphp
                   <td class=" whitespace-normal breakword text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left border-b-[1px] border-b-[#E6E6E6]">{{  $postBacks->error ?? 'N/A' }}</td>
                   @php $exportedData['data'][$key]['error'] =  $postBacks->error ?? 'N/A' ; @endphp
                   <td class=" whitespace-normal breakword text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left border-b-[1px] border-b-[#E6E6E6]">{{ date('d M Y', $postBacks->ceated_at) }}</td>
                   @php $exportedData['data'][$key]['ceated_at'] = $postBacks->ceated_at ?? 'N/A'; @endphp
                   <td class=" whitespace-normal breakword text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left border-b-[1px] border-b-[#E6E6E6]">{{ $postBacks->id }}</td>
                   @php $exportedData['data'][$key]['id'] = $postBacks->id ?? 'N/A'; @endphp
                </tr>
                @endforeach
                @endif
             </table>
         </div>
         <div class="w-[100%] flex flex-col gap-[10px] md:gap-[0] md:flex-row justify-between mt-[30px]w-[100%] flex flex-col gap-[10px] md:gap-[0] md:flex-row justify-between mt-[30px]">
            <h2 class="text-[14px] text-[#808080] font-[500]">Showing {{ $allPostbacks->firstItem() }} to {{ $allPostbacks->lastItem() }} of {{ $allPostbacks->total() }} records</h2>
            @if ($allPostbacks->lastPage() > 1)
                <div class="inline-flex gap-[8px]">
                    {{-- Previous Page --}}
                    @if ($allPostbacks->onFirstPage())
                        <a href="javascript:void(0);" class="group inline-flex gap-[8px] items-center bg-[#F5EAF5] border border-[#FED5C3] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#D272D2] text-center hover:bg-[#D272D2] hover:text-[#fff]"> <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 1L1 5L5 9" stroke="#D272D2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:stroke-[#fff] "></path>
                    </svg>  Previous</span>
                    @else
                        <a href="{{ $allPostbacks->previousPageUrl() }}" class="group inline-flex gap-[8px] items-center bg-[#F5EAF5] border border-[#FED5C3] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#D272D2] text-center hover:bg-[#D272D2] hover:text-[#fff]"> <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 1L1 5L5 9" stroke="#D272D2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:stroke-[#fff] "></path>
                    </svg> Previous</a>
                    @endif

                    {{-- Page Numbers --}}
                    @for ($i = 1; $i <= $allPostbacks->lastPage(); $i++)
                        @if ($i == $allPostbacks->currentPage())
                            <a href="javascript:void(0);" class="btn-active btn inline-flex gap-[8px] items-center bg-[#fff] border border-[#E6E6E6] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#808080] text-center hover:bg-[#D272D2] hover:text-[#fff]">{{ $i }}</a>
                        @else
                            <a href="{{ $allPostbacks->url($i) }}" class="btn inline-flex gap-[8px] items-center bg-[#fff] border border-[#E6E6E6] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#808080] text-center hover:bg-[#D272D2] hover:text-[#fff]">{{ $i }}</a>
                        @endif
                    @endfor

                    {{-- Next Page --}}
                    @if ($allPostbacks->hasMorePages())
                        <a class="group inline-flex gap-[5px] items-center bg-[#F5EAF5] border border-[#FED5C3] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#D272D2] text-center hover:bg-[#D272D2] hover:text-[#fff]" href="{{ $allPostbacks->nextPageUrl() }}">Next <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L5 5L1 9" stroke="#D272D2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:stroke-[#fff] "></path>
                    </svg></a>
                    @else
                        <a href="#" class="group inline-flex gap-[5px] items-center bg-[#F5EAF5] border border-[#FED5C3] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#D272D2] text-center hover:bg-[#D272D2] hover:text-[#fff]">Next <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L5 5L1 9" stroke="#D272D2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:stroke-[#fff] "></path>
                    </svg></a>
                    @endif
                </div>
            @endif
         </div>
       </div>
    </div>
</div>
<script>
    var startDate = "{{ $requestedParams['strd'] }}"
    var endDate = "{{ $requestedParams['endd'] }}"
    $('.filterByStatus').select2({
        placeholder: "Select status",
        allowClear: true // Adds a clear (X) button
    });
    $('#postbackForm').on('submit',function(){
        $('.loader-fcustm').show();
    });
    $('.search-postback-filter').select2({
        placeholder: "Select an offer",
        allowClear: true // Adds a clear (X) button
    });

    $(document).ready(function() {
        $('.appendAffiliateApps').select2({
            placeholder: "Select an app",
            allowClear: true // Adds a clear (X) button
        });

        $('.dateRange-report').daterangepicker({
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            autoUpdateInput: true, 
            startDate: startDate,  // Default start date (7 days ago)
            endDate: endDate,
            opens: 'right'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
   });

   $("#exportCsvBtn").click(function () {
    let exportData = @json($exportedData); 
    $.ajax({
        url: "{{ route('report.export') }}",
        type: "POST",
        data: {
            exportType: 'postback',
            exportData: exportData,
            _token: "{{ csrf_token() }}"
        },
        xhrFields: {
            responseType: 'blob' 
        },
        success: function (data) {
            let blob = new Blob([data], { type: "text/csv" });
            let link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = "report.csv";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
        error: function () {
            alert("Error exporting data!");
        }
        });
    });
   
</script>
@stop