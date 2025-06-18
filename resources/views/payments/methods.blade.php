@extends('layouts.default')
@section('content')

    <div class="p-[15px] md:p-[35px]">
        <div class="flex items-center justify-between gap-[20px] mt-[20px]">
            <div
                class="flex flex-col justify-between items-start gap-[5px] w-[100%] bg-[#fff] rounded-[5px] md:rounded-[10px] p-[15px]">
                <div class="flex flex-row items-center justify-between w-full gap-[5px] mb-[15px]">
                    <h2 class="text-[16px] text-[#1A1A1A] font-[500] ">
                        Payment Methods
                    </h2>
                    @if($allPaymentMethods->isEmpty())
                    <a href="{{ route('add.method') }}" 
                        class="bg-[#4EF953] px-[20px] py-[5px] rounded-[4px] text-[14px] font-[500] text-[#000] text-center cursor-pointer">Add</a>
                    @endif
                </div>
                <div class="w-[100%] overflow-x-auto tableScroll">
                    <table
                        class="w-[100%] border-collapse border-spacing-0 rounded-[10px] border-separate border border-[#E6E6E6]">
                        <tr>
                            <th
                                class="bg-[#7FB5CB] rounded-tl-[10px] text-[14px] font-[500] text-[#fff] px-[10px] py-[13px] text-left  whitespace-nowrap ">
                                Payment Method </th>
                            <th
                                class="bg-[#7FB5CB] text-[14px] font-[500] text-[#fff] px-[10px] py-[13px] text-left  whitespace-nowrap">
                                Account Name</th>
                            <th
                                class="bg-[#7FB5CB] text-[14px] font-[500] text-[#fff] px-[10px] py-[13px] text-left  whitespace-nowrap">
                                Account Number</th>
                            <th
                                class="bg-[#7FB5CB] text-[14px] font-[500] text-[#fff] px-[10px] py-[13px] text-left  whitespace-nowrap">
                                ABA Routing Number</th>
                            {{-- <th class="bg-[#7FB5CB] text-[14px] font-[500] text-[#fff] px-[10px] py-[13px] text-left  whitespace-nowrap">
                            Status</th> --}}
                            <th
                                class="bg-[#7FB5CB] rounded-tr-[10px] text-[14px] font-[500] text-[#fff] px-[10px] py-[13px] text-left  whitespace-nowrap">
                                Action</th>
                        </tr>

                        @if ($allPaymentMethods->isNotEmpty())
                            @foreach ($allPaymentMethods as $key => $paymentMethod)
                                <tr>
                                    <td id="method-name-{{ $paymentMethod->id }}"
                                        value="{{ $paymentMethod->payment_method }}"
                                        class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  whitespace-nowrap ">
                                        @if ($paymentMethod->payment_method == '1')
                                            Wise Payment - {{ $paymentMethod->account_type }}
                                        @elseif ($paymentMethod->payment_method == '2')
                                            Crypto - {{ $paymentMethod->wallet_address }}
                                        @else
                                            Paypal - {{ $paymentMethod->paypal_email }}
                                        @endif
                                    </td>
                                    <td value="{{ $paymentMethod->account_name }}"
                                        id="method-account-name-{{ $paymentMethod->id }}"
                                        class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  whitespace-nowrap ">
                                        {{ $paymentMethod->account_name ?? 'N/A' }}</td>
                                    <td value="{{ $paymentMethod->iban }}" id="method-iban-{{ $paymentMethod->id }}"
                                        class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  whitespace-nowrap ">
                                        {{ $paymentMethod->iban ?? 'N/A' }}</td>
                                    <td value="{{ $paymentMethod->routing_number }}"
                                        id="method-routing-{{ $paymentMethod->id }}"
                                        class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  whitespace-nowrap ">
                                        {{ $paymentMethod->routing_number ?? 'N/A' }}</td>
                                    
                                    <td
                                        class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-center  whitespace-nowrap ">
                                        <a href="{{ route('add.method',['id'=>$paymentMethod->id]) }}" class="edit-method"><svg width="19"
                                                height="19" viewBox="0 0 19 19" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4 5H3C2.46957 5 1.96086 5.21071 1.58579 5.58579C1.21071 5.96086 1 6.46957 1 7V16C1 16.5304 1.21071 17.0391 1.58579 17.4142C1.96086 17.7893 2.46957 18 3 18H12C12.5304 18 13.0391 17.7893 13.4142 17.4142C13.7893 17.0391 14 16.5304 14 16V15"
                                                    stroke="#4EF953" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M13 3L16 6M17.385 4.585C17.7788 4.19115 18.0001 3.65698 18.0001 3.1C18.0001 2.54302 17.7788 2.00885 17.385 1.615C16.9912 1.22115 16.457 0.999893 15.9 0.999893C15.343 0.999893 14.8088 1.22115 14.415 1.615L6 10V13H9L17.385 4.585Z"
                                                    stroke="#4EF953" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>

                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>

            </div>

        </div>
    </div>


    <script>
        

        $(document).on('change', '.status-method', function() {
            $('#updateid').val($(this).attr('rec-id'));
            $('#update-status-form').submit();
        })

        
    </script>
    <form method="POST" id="update-status-form" action="{{ route('update.method.status') }}">
        @csrf
        <input type="hidden" name="updateid" id="updateid" vlaue="0">
    </form>

@stop
