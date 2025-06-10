@extends('layouts.default')
@section('content')

<div class="p-[15px] md:p-[35px]">
    <div class="flex items-center justify-between gap-[20px] mt-[20px]">
        <div class="flex flex-col justify-between items-start gap-[5px] w-[100%] bg-[#fff] rounded-[5px] md:rounded-[10px] p-[15px]">
            <div class="flex flex-row items-center justify-between w-full gap-[5px] mb-[15px]">
                <h2 class="text-[16px] text-[#1A1A1A] font-[500] ">
                    Payment Methods
                </h2>
                <button type="button" onclick="openModal()" class="bg-[#4EF953] px-[20px] py-[5px] rounded-[4px] text-[14px] font-[500] text-[#000] text-center cursor-pointer">Add</button>
            </div>
            <div class="w-[100%] overflow-x-auto tableScroll">
                <table class="w-[100%] border-collapse border-spacing-0 rounded-[10px] border-separate border border-[#E6E6E6]">
                    <tr>
                        <th
                            class="bg-[#7FB5CB] rounded-tl-[10px] text-[14px] font-[500] text-[#fff] px-[10px] py-[13px] text-left  whitespace-nowrap ">
                            Payment Method	</th>
                        <th class="bg-[#7FB5CB] text-[14px] font-[500] text-[#fff] px-[10px] py-[13px] text-left  whitespace-nowrap">
                            Account Name</th>
                        <th class="bg-[#7FB5CB] text-[14px] font-[500] text-[#fff] px-[10px] py-[13px] text-left  whitespace-nowrap">
                            IBAN</th>
                        <th class="bg-[#7FB5CB] text-[14px] font-[500] text-[#fff] px-[10px] py-[13px] text-left  whitespace-nowrap">
                            ABA Routing Number</th>
                        <th class="bg-[#7FB5CB] text-[14px] font-[500] text-[#fff] px-[10px] py-[13px] text-left  whitespace-nowrap">SWIFT / BIC</th>
                        {{-- <th class="bg-[#7FB5CB] text-[14px] font-[500] text-[#fff] px-[10px] py-[13px] text-left  whitespace-nowrap">
                            Status</th> --}}
                        <th
                            class="bg-[#7FB5CB] rounded-tr-[10px] text-[14px] font-[500] text-[#fff] px-[10px] py-[13px] text-left  whitespace-nowrap">
                            Action</th>
                    </tr>

                    @if($allPaymentMethods->isNotEmpty())
                @foreach ($allPaymentMethods as $key => $paymentMethod) 
                    <tr>
                        <td id="method-name-{{ $paymentMethod->id }}" value="{{ $paymentMethod->payment_method }}" class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  whitespace-nowrap ">@if($paymentMethod->payment_method=='now-payment') Now Payment @elseif ($paymentMethod->payment_method=='wise-payment') Wise Payment @else N/A @endif</td>
                        <td value="{{ $paymentMethod->account_name }}" id="method-account-name-{{ $paymentMethod->id }}" class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  whitespace-nowrap ">{{ $paymentMethod->account_name }}</td>
                        <td value="{{ $paymentMethod->iban }}" id="method-iban-{{ $paymentMethod->id }}" class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  whitespace-nowrap ">{{ $paymentMethod->iban }}</td>
                        <td value="{{ $paymentMethod->routing_number }}" id="method-routing-{{ $paymentMethod->id }}" class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  whitespace-nowrap ">{{ $paymentMethod->routing_number }}</td>
                        <td value="{{ $paymentMethod->swift }}" id="method-swift-{{ $paymentMethod->id }}" class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  whitespace-nowrap ">{{ $paymentMethod->swift }}</td>
                        {{-- <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  whitespace-nowrap ">
                            <label class="relative cursor-pointer">
                                <input rec-id="{{ $paymentMethod->id }}" type="checkbox" name="payment" value="option1" class="status-method sr-only peer" @if($paymentMethod->status) checked @endif>
                                <div class="w-10 h-5 rounded-full bg-gray-300 peer-checked:bg-[#4EF953] transition-colors duration-300"></div>
                                <div class="absolute left-0 top-0 w-5 h-5 bg-white border rounded-full shadow transform peer-checked:translate-x-5 transition-transform duration-300"></div>
                            </label>
                        </td> --}}

                        <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-center  whitespace-nowrap ">
                            <button rec-id="{{ $paymentMethod->id }}"  class="edit-method"
                                ><svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 5H3C2.46957 5 1.96086 5.21071 1.58579 5.58579C1.21071 5.96086 1 6.46957 1 7V16C1 16.5304 1.21071 17.0391 1.58579 17.4142C1.96086 17.7893 2.46957 18 3 18H12C12.5304 18 13.0391 17.7893 13.4142 17.4142C13.7893 17.0391 14 16.5304 14 16V15" stroke="#4EF953" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13 3L16 6M17.385 4.585C17.7788 4.19115 18.0001 3.65698 18.0001 3.1C18.0001 2.54302 17.7788 2.00885 17.385 1.615C16.9912 1.22115 16.457 0.999893 15.9 0.999893C15.343 0.999893 14.8088 1.22115 14.415 1.615L6 10V13H9L17.385 4.585Z" stroke="#4EF953" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @endif
                </table>
            </div>
            
        </div>

    </div>
</div>

<!-- Modal -->
<div id="myModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <form method="POST" action="{{ route('payment.methods') }}">
        @csrf
        <input type="hidden" id="payment-method-id" name="rec_id" value="0">
        <div class="bg-white w-full max-w-md mx-auto p-6 rounded-lg shadow-lg relative">
        <h2 class="text-xl font-semibold ">Add Payment Method</h2>
        <div class="modal_body py-[20px]">
            <p class="text-[14px] text-[#898989]">Select Method</p>
            <select name="methods" class="method-name w-full bg-transparent border-[1px] border-[solid] border-[#e9e9e9] h-[45px] rounded-[5px] text-[14px] text-[#4D4D4D] p-[10px] !outline-none focus:!outline-none" required>
                <option value="">Select</option>
                <option value="now-payment">Now Payments</option>
                <option value="wise-payment">Wise Payments</option>
            </select>
        </div>
        <div class="modal_body py-[20px]">
            <p class="text-[14px] text-[#898989]">Name on account</p>
            <input class="method-account-name flex px-[15px] py-[15px] rounded-[5px] bg-[#F6F6F6] text-[14px] text-[#4D4D4D] font-[600] hover:outline-none focus:outline-none" type="text" name="account_name" required>
        </div>
         <div class="modal_body py-[20px]">
            <p class="text-[14px] text-[#898989]">IBAN</p>
            <input  class="method-iban flex px-[15px] py-[15px] rounded-[5px] bg-[#F6F6F6] text-[14px] text-[#4D4D4D] font-[600] hover:outline-none focus:outline-none" type="text" name="iban" required>
        </div>
         <div class="modal_body py-[20px]">
            <p class="text-[14px] text-[#898989]">ABA Routing number</p>
            <input  class="method-routing  flex px-[15px] py-[15px] rounded-[5px] bg-[#F6F6F6] text-[14px] text-[#4D4D4D] font-[600] hover:outline-none focus:outline-none" type="text" name="routing_number" required>
        </div>
        <div class="modal_body py-[20px]">
            <p class="text-[14px] text-[#898989]">SWIFT / BIC</p>
            <input  class="method-swift  flex px-[15px] py-[15px] rounded-[5px] bg-[#F6F6F6] text-[14px] text-[#4D4D4D] font-[600] hover:outline-none focus:outline-none" type="text" name="swift" required>
        </div>

        <div class="flex justify-end space-x-2 mt-4">
            <button type="button" onclick="closeModal()" class="px-4 py-2 bg-[#7FB5CB] w-[100px]  rounded-[4px] text-[14px] font-[500] text-[#000] text-center">Cancel</button>
            <button class="px-4 py-2 bg-[#49FB53] text-black rounded">Save</button>
        </div>
        <button onclick="closeModal()" class="absolute top-1 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
        </div>
    </form>
  </div>

<!-- Modal Script -->
<script>
    function openModal() {
      document.getElementById('myModal').classList.remove('hidden');
      document.getElementById('myModal').classList.add('flex');
    }
  
    function closeModal() {
      document.getElementById('myModal').classList.add('hidden');
      document.getElementById('myModal').classList.remove('flex');
    }

    $(document).on('change','.status-method',function(){
        $('#updateid').val($(this).attr('rec-id'));
        $('#update-status-form').submit();
    })

    $(document).on('click','.edit-method',function(){
        $('#payment-method-id').val($(this).attr('rec-id'));
        $('.method-name').val($('#method-name-'+$(this).attr('rec-id')).attr('value'));
        $('.method-account-name').val($('#method-account-name-'+$(this).attr('rec-id')).attr('value'));
        $('.method-iban').val($('#method-iban-'+$(this).attr('rec-id')).attr('value'));
        $('.method-routing').val($('#method-routing-'+$(this).attr('rec-id')).attr('value'));
        $('.method-swift').val($('#method-swift-'+$(this).attr('rec-id')).attr('value'));
        openModal();
    })
  </script>
    <form method="POST" id="update-status-form" action="{{ route('update.method.status') }}">
        @csrf
        <input type="hidden" name="updateid" id="updateid" vlaue="0">
    </form>

@stop