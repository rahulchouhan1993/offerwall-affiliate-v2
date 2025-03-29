@extends('layouts.default')
@section('content')
@php
   use Illuminate\Support\Facades\Http;
@endphp

<div class="bg-[#f2f2f2] p-[15px] md:p-[35px]">
    <div class="bg-[#fff] p-[15px] md:p-[20px] rounded-[10px] mb-[20px]">
       <div class="flex items-center justify-between gap-[25px] w-[100%]  mb-[15px]">
          <h2 class="text-[20px] text-[#1A1A1A] font-[600]">Overview</h2>
          <button
             class="w-[140px] bg-[#49FB53] px-[20px] py-[10px] w-[100px] rounded-[4px] text-[14px] font-[500] text-[#000] text-center" id="exportCsvBtn">Export</button>
       </div>
       <div class="flex flex-col items-center justify-center gap-[15px]">
         <form method="get" id="filterConversions">
          <div class="w-full flex flex-col gap-[10px]">
            <div class="w-[100%] flex flex-col lg:flex-row items-start lg:items-center justify-start gap-[10px]">
               <label class="min-w-[160px] w-[100%] md:w-[10%] text-[14px] font-[500] text-[#898989] ">Apps:</label>
               <select name="appid" class="appendAffiliateApps w-[100%] lg:w-[90%] bg-[#F6F6F6] px-[15px] py-[12px] text-[14px] font-[400] text-[#4D4D4D] border-[1px] border-[#E6E6E6] rounded-[4px] hover:outline-none focus:outline-none">
                  <option value="" >Select</option>
                  @if($allAffiliatesApp && $allAffiliatesApp->isNotEmpty())
                     @foreach ($allAffiliatesApp as $affiliateApp)
                        <option value="{{ $affiliateApp->id }}" @if(isset($requestedParams['appid']) && $requestedParams['appid'] == $affiliateApp->id) selected @endif>{{ $affiliateApp->appName }}</option>
                     @endforeach
                  @endif
               </select>
            </div>
             <div class="w-[100%] flex flex-col lg:flex-row items-start lg:items-center justify-start gap-[10px]">
                <label class="min-w-[160px] w-[100%] md:w-[10%] text-[14px] font-[500] text-[#898989] ">Range:</label>
                <input type="text" name="range" class="dateRange-report w-[100%] bg-[#F7F7F7] px-[15px] py-[12px] text-[12px] font-[600] text-[#000] 1border-[1px] 1border-[#E6E6E6] rounded-[10px] hover:outline-none focus:outline-none" placeholder="2024-12-10" value="{{ $requestedParams['range'] }}">
             </div>
             <div class="w-[100%] flex flex-col lg:flex-row items-start lg:items-center justify-start gap-[10px]">
                <label class="min-w-[160px] w-[10%] text-[14px] font-[500] text-[#898989] ">Country:</label>
                <select name="country" class="countryOptions w-[100%] lg:w-[90%] bg-[#] px-[15px] py-[12px] text-[14px] font-[600] text-[#4D4D4D] border-[1px] border-[#E6E6E6] rounded-[4px] hover:outline-none focus:outline-none">
                  <option value="">Select</option>
                  @foreach ($allCountry as $countryName =>$countryCode)
                     <option value="{{ $countryCode }}" @if(isset($requestedParams['country']) && $requestedParams['country'] == $countryCode) selected @endif>{{ $countryName }}</option>
                  @endforeach
                </select>
             </div>
             <div class="w-[100%] flex items-center flex-wrap justify-start lg:flex-nowrap gap-[10px]">
                <label class="min-w-[160px] w-[10%] text-[14px] font-[500] text-[#898989] ">Filter by:</label> 
                <div class="w-[100%] xl:w-[90%] flex flex-wrap xl:flex-nowrap  items-center gap-[5px] md:gap-[8px] lg:gap-[10px] xl:gap-[15px]">
                   <div class="relative w-[100%] xl:w-[80%] flex flex-wrap xl:flex-nowrap items-center gap-[10px]">
                      <select name="offer"
                         class="offerOption w-[100%] xl:w-[25%] bg-[#F6F6F6] px-[15px] py-[12px] text-[14px] font-[600] text-[#4D4D4D] border-[1px] border-[#E6E6E6] rounded-[4px] hover:outline-none focus:outline-none">
                         <option value="">Select</option>
                         @foreach ($allOffers as $offerKey => $offerName)
                           <option value="{{ $offerKey }}" @if(isset($requestedParams['offer']) && $requestedParams['offer'] == $offerKey) selected @endif>{{ $offerName }}</option>
                        @endforeach
                      </select>
                      <select name="os"
                         class="osOption w-[100%] xl:w-[25%] bg-[#F6F6F6] px-[15px] py-[12px] text-[14px] font-[600] text-[#4D4D4D] border-[1px] border-[#E6E6E6] rounded-[4px] hover:outline-none focus:outline-none">
                         <option value="">Select</option>
                         @if($allOs->isNotEmpty())
                         @foreach($allOs as $osList)
                         <option value="{{ $osList }}" @if(isset($requestedParams['os']) && $requestedParams['os'] == $osList) selected @endif>{{ $osList }}</option>
                         @endforeach
                         @endif
                      </select>
                      {{-- <select name="status"
                         class="conversionstatusOption w-[100%] xl:w-[25%] bg-[#F6F6F6] px-[15px] py-[12px] text-[14px] font-[600] text-[#4D4D4D] border-[1px] border-[#E6E6E6] rounded-[4px] hover:outline-none focus:outline-none">
                         <option value="">Select</option>
                         <option value="1" @if($requestedParams['status'] ?? '' == '1') selected @endif>Confirmed</option>
                         <option value="2" @if($requestedParams['status'] ?? '' == '2') selected @endif>Pending</option>
                         <option value="3" @if($requestedParams['status'] ?? '' == '3') selected @endif>Declined</option>
                         <option value="5" @if($requestedParams['status'] ?? '' == '5') selected @endif>Hold</option>
                      </select> --}}
                      <input name="goal" class="w-[100%] xl:w-[25%] bg-[#F6F6F6] px-[15px] py-[12px] text-[14px] font-[600] text-[#4D4D4D] border-[1px] border-[#E6E6E6] rounded-[4px] hover:outline-none focus:outline-none" placeholder="Goal" value="{{ $requestedParams['goal'] ?? '' }}">
                      {{-- <input name="smartlink" class="w-[100%] xl:w-[25%] bg-[#F6F6F6] px-[15px] py-[12px] text-[14px] font-[600] text-[#4D4D4D] border-[1px] border-[#E6E6E6] rounded-[4px] hover:outline-none focus:outline-none" placeholder="Smart Link" value="{{ $filterOptions['smartLink'] }}"> --}}
                   </div>
                   <div class="w-[100%] xl:w-[20%] flex items-center justify-start xl:justify-between gap-[10px]">
                      <button
                         class="w-[140px] bg-[#49FB53] px-[20px] py-[11px] w-[100px] rounded-[4px] text-[14px] font-[500] text-[#000] text-center">Apply</button>
                      <a href="{{ route('report.conversions') }}"
                         class="w-[140px] bg-[#536861] px-[20px] py-[11px] w-[100px] border border-[#F5EAF5] rounded-[4px] text-[14px] font-[500] text-[#fff] text-center">Clear</a>
                   </div>
                </div>
             </div>
          </div>
         </form>
       </div>
      @php
      $exportedData = [
            'heading' => [
               '0' => 'Click Id',
               '1' => 'Conversion Id',
               '2' => 'Click Date',
               '3' => 'Conversion Date',
               '4' => 'Status',
               '5' => 'Offer',
               '6' => 'Goal',
               '7' => 'Payout',
               '8' => 'Country',
               '9' => 'IP',
               '10' => 'OS',
               '11' => 'Device',
               '12' => 'Mobile ISP',
               '13' => 'User Agent',
            ],
            'data' => []
         ]; 
       @endphp
       <div class="flex flex-col justify-between items-center gap-[5px] w-[100%] mt-[30px] ">
          <div class="w-[100%] overflow-x-scroll tableScroll">
             <table
                class="w-[100%] border-collapse border-spacing-0 rounded-[10px] border-separate border border-[#E6E6E6]">
                <tr>
                  <th
                      class="bg-[#7FB5CB] rounded-tl-[10px] text-[10px] font-[500] text-[#fff] px-[10px] py-[13px] text-left whitespace-nowrap ">
                      Click Id
                   </th>
                   <th
                      class=" whitespace-normal breakword bg-[#7FB5CB]  text-[10px] text-center font-[500] text-[#fff] px-[10px] py-[13px] text-left">
                      Conversion Id
                   </th>
                   <th
                      class="bg-[#7FB5CB] text-[10px] font-[500] text-[#fff] px-[10px] py-[13px] text-left whitespace-nowrap ">
                      Click Date
                   </th>
                   <th
                      class="bg-[#7FB5CB] text-[10px] font-[500] text-[#fff] px-[10px] py-[13px] text-left whitespace-nowrap ">
                      Conversion Date
                   </th>
                   <th
                      class="bg-[#7FB5CB] text-[10px] font-[500] text-[#fff] px-[10px] py-[13px] text-left whitespace-nowrap">
                      Status
                   </th>
                   <th
                      class=" whitespace-normal breakword bg-[#7FB5CB] text-[10px] font-[500] text-[#fff] px-[10px] py-[13px] text-left">
                      Offer
                   </th>
                   <th
                      class=" whitespace-normal breakword bg-[#7FB5CB] text-[10px] font-[500] text-[#fff] px-[10px] py-[13px] text-left">
                      Goal
                   </th>
                   <th
                      class=" whitespace-normal breakword bg-[#7FB5CB] text-[10px] font-[500] text-[#fff] px-[10px] py-[13px] text-left">
                      Payout
                   </th>
                   <th
                      class="bg-[#7FB5CB] text-[10px] font-[500] text-[#fff] px-[10px] py-[13px] text-left whitespace-nowrap">
                      Country
                   </th>
                   <th
                      class="bg-[#7FB5CB] text-[10px] font-[500] text-[#fff] px-[10px] py-[13px] text-left whitespace-nowrap">
                      IP
                   </th>
                   <th
                      class="bg-[#7FB5CB] text-[10px] font-[500] text-[#fff] px-[10px] py-[13px] text-left whitespace-nowrap">
                      OS
                   </th>
                   <th
                      class="bg-[#7FB5CB] text-[10px] font-[500] text-[#fff] px-[10px] py-[13px] text-left whitespace-nowrap">
                      Device
                   </th>
                   <th
                      class="bg-[#7FB5CB] text-[10px] font-[500] text-[#fff] px-[10px] py-[13px] text-left whitespace-nowrap">
                      Mobile ISP
                   </th>
                   <th
                      class="bg-[#7FB5CB] rounded-tr-[10px] text-[10px] font-[500] text-[#fff] px-[10px] py-[13px] text-left whitespace-nowrap">
                      User Agent
                   </th>
                </tr>
                @if($allConversions->isNotEmpty())
                @foreach ($allConversions as $key => $conversion)
                <tr>
                   <td
                      class="text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap border-b-[1px] border-b-[#E6E6E6]">
                      {{ $conversion->click_id }}
                      @php $exportedData['data'][$key]['click_id'] = $conversion->click_id ?? '0'; @endphp
                   </td>
                   <td title="AU - Ipsos iSay (TOI) [Responsive]" 
                      class="  whitespace-normal breakword text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left border-b-[1px] border-b-[#E6E6E6] ">
                      {{ $conversion->conversion_id }}
                      @php $exportedData['data'][$key]['conversion_id'] = $conversion->conversion_id ?? '0'; @endphp
                   </td>
                   <td
                      class="text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left border-b-[1px] border-b-[#E6E6E6] ">
                      {{ $conversion->click_time }}
                      @php $exportedData['data'][$key]['click_time'] = $conversion->click_time ?? '0'; @endphp
                   </td>
                   <td
                      class="text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  border-b-[1px] border-b-[#E6E6E6]">
                      {{ $conversion->created_at }}
                      @php $exportedData['data'][$key]['created_at'] = $conversion->created_at ?? '0'; @endphp
                   </td>
                   <td
                      class="text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap border-b-[1px] border-b-[#E6E6E6]">
                      <div class="inline-flex bg-[#F3FEE7] border border-[#BCEE89] rounded-[5px]  px-[8px] py-[4px] text-[10px] font-[600] text-[#6EBF1A] text-center uppercase">Confirmed</div>
                      @php $exportedData['data'][$key]['status'] = 'Confirmed'; @endphp
                      {{-- @if($conversion['status']=='confirmed')
                      <div class="inline-flex bg-[#F3FEE7] border border-[#BCEE89] rounded-[5px]  px-[8px] py-[4px] text-[10px] font-[600] text-[#6EBF1A] text-center uppercase">
                        {{ $conversion['status'] }} </div>
                      @else
                      <div class="inline-flex bg-[#fee7e7] border border-[#ee8989] rounded-[5px]  px-[8px] py-[4px] text-[10px] font-[600] text-[#bf1a1a] text-center uppercase">
                        {{ $conversion['status'] }} </div>
                      @endif --}}
                      
                   </td>
                   @php
                        $url = $advertiserDetails->affise_endpoint.'offer/'.$conversion->offer_id;
                        $response = HTTP::withHeaders([
                           'API-Key' => $advertiserDetails->affise_api_key,
                        ])->get($url);
                        if ($response->successful()) {
                           $offerDetails = $response->json();
                           $conversion->offer_id = ucfirst($offerDetails['offer']['title']);
                        }
                   @endphp
                   <td
                      class="text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap border-b-[1px] border-b-[#E6E6E6]">
                      {{ $conversion->offer_id }}
                      @php $exportedData['data'][$key]['offer_id'] = $conversion->offer_id ?? '0'; @endphp
                   </td>
                     @php
                        $goalConv = ($conversion->goal == '') ? '--' : $conversion->goal;
                     @endphp
                   <td
                      class="text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap border-b-[1px] border-b-[#E6E6E6]">
                       {{ $goalConv }}
                       @php $exportedData['data'][$key]['goal'] = $goalConv ?? '--'; @endphp
                   </td>
                   <td
                      class="text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap border-b-[1px] border-b-[#E6E6E6]">
                       $ {{ $conversion->payout }}
                       @php $exportedData['data'][$key]['payout'] = '$ '.$conversion->payout ?? 'N/A'; @endphp
                   </td>
                   <td
                      class="text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap border-b-[1px] border-b-[#E6E6E6] ">
                       {{ $conversion->country_name }}
                       @php $exportedData['data'][$key]['country_name'] = $conversion->country_name ?? 'N/A'; @endphp
                   </td>
                   <td
                      class="text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap border-b-[1px] border-b-[#E6E6E6]">
                       {{ $conversion->ip }}
                       @php $exportedData['data'][$key]['ip'] = $conversion->ip ?? 'N/A'; @endphp
                   </td>
                   <td
                      class="text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap border-b-[1px] border-b-[#E6E6E6] ">
                       {{ $conversion->device_os }}
                       @php $exportedData['data'][$key]['device_os'] = $conversion->device_os ?? 'N/A'; @endphp
                   </td>
                   <td
                      class="text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap border-b-[1px] border-b-[#E6E6E6]">
                       {{ $conversion->device_type ?? 'Unknown' }}
                       @php $exportedData['data'][$key]['device_type'] = $conversion->device_type ?? 'Unknown'; @endphp
                   </td>
                   <td
                      class="text-[10px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap border-b-[1px] border-b-[#E6E6E6]">
                      {{ $conversion->isp ?? 'Unknown' }}
                      @php $exportedData['data'][$key]['isp'] = $conversion->isp ?? 'Unknown'; @endphp
                   </td>
                   <td
                      class="text-[10px] font-[500] text-[#808080] text-center px-[10px] py-[10px] text-left  border-b-[1px] border-b-[#E6E6E6]">
                      {{ $conversion->ua }}
                      @php $exportedData['data'][$key]['ua'] = $conversion->ua ?? 'N/A'; @endphp
                   </td>
                </tr>
                @endforeach
                @endif
             </table>
          </div>
          
         <div class="w-[100%] flex flex-col gap-[10px] md:gap-[0] md:flex-row justify-between mt-[30px]w-[100%] flex flex-col gap-[10px] md:gap-[0] md:flex-row justify-between mt-[30px]">
            <h2 class="text-[14px] text-[#808080] font-[500]">Showing {{ $allConversions->firstItem() }} to {{ $allConversions->lastItem() }} of {{ $allConversions->total() }} records</h2>
            @if ($allConversions->lastPage() > 1)
    <div class="inline-flex gap-[8px]">
        {{-- Previous Page --}}
        @if ($allConversions->onFirstPage())
            <a href="javascript:void(0);" class="group inline-flex gap-[8px] items-center bg-[#F5EAF5] border border-[#FED5C3] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#D272D2] text-center hover:bg-[#D272D2] hover:text-[#fff]"> <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M5 1L1 5L5 9" stroke="#D272D2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:stroke-[#fff] "></path>
           </svg>  Previous</span>
        @else
            <a href="{{ $allConversions->previousPageUrl() }}" class="group inline-flex gap-[8px] items-center bg-[#F5EAF5] border border-[#FED5C3] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#D272D2] text-center hover:bg-[#D272D2] hover:text-[#fff]"> <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M5 1L1 5L5 9" stroke="#D272D2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:stroke-[#fff] "></path>
           </svg> Previous</a>
        @endif

        {{-- Page Numbers --}}
        @for ($i = 1; $i <= $allConversions->lastPage(); $i++)
            @if ($i == $allConversions->currentPage())
                <a href="javascript:void(0);" class="btn-active btn inline-flex gap-[8px] items-center bg-[#fff] border border-[#E6E6E6] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#808080] text-center hover:bg-[#D272D2] hover:text-[#fff]">{{ $i }}</a>
            @else
                <a href="{{ $allConversions->url($i) }}" class="btn inline-flex gap-[8px] items-center bg-[#fff] border border-[#E6E6E6] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#808080] text-center hover:bg-[#D272D2] hover:text-[#fff]">{{ $i }}</a>
            @endif
        @endfor

        {{-- Next Page --}}
        @if ($allConversions->hasMorePages())
            <a class="group inline-flex gap-[5px] items-center bg-[#F5EAF5] border border-[#FED5C3] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#D272D2] text-center hover:bg-[#D272D2] hover:text-[#fff]" href="{{ $allConversions->nextPageUrl() }}">Next <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
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
    $(document).ready(function() {
      $('.offerOption').select2({
         placeholder: "Select an offer",
         allowClear: true // Adds a clear (X) button
      });
      $('.countryOptions').select2({
         placeholder: "Select country",
         allowClear: true // Adds a clear (X) button
      });
      $('.osOption').select2({
         placeholder: "Select OS",
         allowClear: true // Adds a clear (X) button
      });
      $('.conversionstatusOption').select2({
         placeholder: "Select status",
         allowClear: true // Adds a clear (X) button
      });
      $('.appendAffiliateApps').select2({
         placeholder: "Select an app",
         allowClear: true // Adds a clear (X) button
      });

      $("#exportCsvBtn").click(function () {
         let exportData = @json($exportedData); 
         $.ajax({
               url: "{{ route('report.export') }}",
               type: "POST",
               data: {
                  exportType: 'conversion',
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
   $('#filterConversions').on('submit',function(){
      $('.loader-fcustm').show();
   })
   
</script>
@stop