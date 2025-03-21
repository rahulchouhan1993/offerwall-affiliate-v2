@extends('layouts.default')
@section('content')
<div class="bg-[#f2f2f2] p-[15px] lg:p-[35px]">
    <div class="flex flex-col lg:flex-row justify-between items-start gap-[15px] w-[100%] ">
        <div class="w-[100%] lg:w-[100%] bg-[#fff] p-[15px] md:p-[20px] rounded-[10px]">
            <div class="flex flex-wrap md:flex-nowrap items-center justify-between gap-[10px] mb-[20px]">
                <h2 class="w-full lg:w-auto text-[20px] text-[#1A1A1A] font-[600]">Postback</h2>
            </div>
            <form method="POST"> @csrf
            <div class="flex gap-[25px] flex-wrap md:flex-nowrap justify-between">
                <div class="w-full md-w-[30%] flex flex-col gap-[15px]">
                    <div class="w-full flex items-start flex-wrap gap-[6px] w-full">
                        <label class=" w-[100%] text-[14px] font-[500] text-[#898989] ">App</label>
                        <div class="w-[100%] flex flex-wrap xl:flex-nowrap  items-center gap-[5px] md:gap-[8px] lg:gap-[10px] xl:gap-[15px]">
                            <div class="relative w-[100%] flex flex-wrap xl:flex-nowrap items-center gap-[10px]">
                                <select name="app_id"
                                    class="selectAppPostback w-[100%] bg-[#F6F6F6] px-[15px] py-[12px] text-[14px] font-[600] text-[#4D4D4D] border-[1px] border-[#E6E6E6] rounded-[4px] hover:outline-none focus:outline-none">
                                    <option value="">Select an app</option>
                                    @if($allApps->isNotEmpty())
                                    @foreach ($allApps as $app)
                                    <option value="{{ $app->id }}">{{ $app->appName }}</option>
                                    @endforeach
                                    
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex items-start flex-wrap gap-[6px] w-full">
                        
                            <label class=" w-[100%] text-[14px] font-[500] text-[#898989] ">Payout</label>
                            <input type="text" name="payout" class="goal-postback-filter w-[100%] bg-[#F6F6F6] px-[15px] py-[12px] text-[12px] font-[500] text-[#808080] border-[1px] border-[#E6E6E6] rounded-[4px] hover:outline-none focus:outline-none" placeholder="0.00" value="">
                       
                    </div>
                    <div class="flex gap-[10px] md:gap-[20px]">
                        <button type="submit" class="w-[100px] md:w-[110px] lg:w-[140px] bg-[#D272D2] px-[20px] py-[10px] w-[100px] rounded-[4px] text-[14px] font-[500] text-[#fff] text-center">Save</button>
                    </div>
                </div>
                </form>
                <div class="w-full md-w-[70%] mt-[25px]">
                    <div class=" overflow-x-scroll tableScroll">
                        <table class="w-[100%] border-collapse border-spacing-0 rounded-[10px] border-separate border border-[#E6E6E6]">
                            <tbody>
                                <tr>
                                    <th class=" bg-[#F6F6F6] rounded-tl-[10px] text-[12px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap ">App</th>
                                    <th class=" bg-[#F6F6F6] rounded-tl-[10px] text-[12px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap ">Payout</th>
                                    <th class=" bg-[#F6F6F6] rounded-tl-[10px] text-[12px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap ">IP</th>
                                    <th class=" bg-[#F6F6F6] rounded-tl-[10px] text-[12px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap ">Postback Status</th>
                                    <th class=" bg-[#F6F6F6] rounded-tl-[10px] text-[12px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap text-right">Details</th>
                                </tr>
                                @if($allPostbacks->isNotEmpty())
                                @foreach ($allPostbacks as $postback)
                                <tr>
                                    <td class="text-[12px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap  border-b-[1px] border-b-[#E6E6E6]">{{ $postback->apps->appName }}</td>

                                    <td class=" text-[12px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap  border-b-[1px] border-b-[#E6E6E6]">{{ $postback->payout }}</td>

                                    <td class="text-[12px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap  border-b-[1px] border-b-[#E6E6E6]">{{ $postback->ip }}</td>

                                    <td class=" text-[12px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap  border-b-[1px] border-b-[#E6E6E6]">{{ $postback->status }}</td>

                                    <td class=" text-[12px] font-[500] text-[#808080] px-[10px] py-[10px]  whitespace-nowrap  border-b-[1px] border-b-[#E6E6E6]">
                                        <div class="flex items-center justify-end gap-[10px]">
                                            <a id="{{ $postback->id }}" title="View Details" href="javascript:void(0);" class="getErrorDetails flex items-center justify-center w-[35px] bg-[#FFF3ED] py-[10px] w-[100px] border border-[#FED5C3] rounded-[4px] text-[14px] font-[500] text-[#D272D2] text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 16 16" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8L3.07945 4.30466C4.29638 2.84434 6.09909 2 8 2C9.90091 2 11.7036 2.84434 12.9206 4.30466L16 8L12.9206 11.6953C11.7036 13.1557 9.90091 14 8 14C6.09909 14 4.29638 13.1557 3.07945 11.6953L0 8ZM8 11C9.65685 11 11 9.65685 11 8C11 6.34315 9.65685 5 8 5C6.34315 5 5 6.34315 5 8C5 9.65685 6.34315 11 8 11Z" fill="#D272D2"/>
                                            </svg> 
                                            </a>
                                        </div>
                                    </td>
                                </tr>   
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.selectAppPostback').select2({
        placeholder: "Select an app",
        allowClear: true // Adds a clear (X) button
    });
</script>
<div id="errorDetailsModal" class="hidden fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
    <div class="bg-white p-5 rounded-lg shadow-lg w-[90%] max-w-[700px]">
        <h2 class="text-lg font-semibold mb-4">Postback Details</h2>
        <div id="errorDetailsContent" class="overflow-x-auto" ></div>
        <button onclick="$('#errorDetailsModal').addClass('hidden');" class="mt-4 bg-[#D272D2] text-white px-4 py-2 rounded">Close</button>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.getErrorDetails').click(function() {
        let postbackId = $(this).attr('id'); 

        if (!postbackId) {
            alert("Invalid postback ID");
            return;
        }

        let url = "{{ route('postbackerror', ['id' => '__ID__']) }}".replace('__ID__', postbackId);

        $.ajax({
            url: url,
            method: "GET",
            success: function(response) {
                let tableContent = `
                    <table class="w-full border border-collapse">
                        <tr>
                            <th class="min-w-[130px] border px-4 py-2 text-right text-[14px] font-[600]  text-[#000]">Postback URL</th>
                            <td class="border px-4 py-2 text-[13px] font-[400] text-[#000]">${response.postback_url}</td>
                        </tr>
                        <tr>
                            <th class="min-w-[130px] border px-4 py-2 text-right text-[14px] font-[600]  text-[#000]">HTTP Code</th>
                            <td class="border px-4 py-2 text-[13px] font-[400] text-[#000]">${response.http_code}</td>
                        </tr>
                        <tr>
                            <th class="min-w-[130px] border px-4 py-2 text-right text-[14px] font-[600]  text-[#000]">Error Message</th>
                            <td class="border px-4 py-2 text-[13px] font-[400] text-[#000]">${response.error_message}</td>
                        </tr>
                    </table>`;

                $('#errorDetailsContent').html(tableContent); // Insert table content
                $('#errorDetailsModal').removeClass('hidden'); // Show modal
            },
            error: function(xhr) {
                let tableContent = `
                    <table class="w-full border border-collapse">
                        <tr>
                            <th class="min-w-[130px] border px-4 py-2 text-right text-[14px] font-[600]  text-[#000]">Postback URL</th>
                            <td class="border px-4 py-2 text-[13px] font-[400] text-[#000]">N/A</td>
                        </tr>
                        <tr>
                            <th class="min-w-[130px] border px-4 py-2 text-right text-[14px] font-[600]  text-[#000]">HTTP Code</th>
                            <td class="border px-4 py-2 text-[13px] font-[400] text-[#000]">N/A</td>
                        </tr>
                        <tr>
                            <th class="min-w-[130px] border px-4 py-2 text-right text-[14px] font-[600]  text-[#000]">Error Message</th>
                            <td class="border px-4 py-2 text-[13px] font-[400] text-[#000]">${xhr.responseJSON?.error_message || "Failed to load details."}</td>
                        </tr>
                    </table>`;

                $('#errorDetailsContent').html(tableContent);
                $('#errorDetailsModal').removeClass('hidden');
            }
        });
    });


        // Close modal on button click
        $('#closeModal').click(function() {
            $('#errorDetailsModal').addClass('hidden');
        });

        // Close modal when clicking outside of the modal
        $(document).click(function(event) {
            if ($(event.target).closest("#errorDetailsModal div").length === 0) {
                $('#errorDetailsModal').addClass('hidden');
            }
        });
    });
</script>
@stop