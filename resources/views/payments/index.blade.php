@extends('layouts.default')
@section('content')

<div class="p-[15px] md:p-[35px]"> 
    {{-- <div class="bg-[#fff] p-[10px] md:p-[15px] md:p-[20px] rounded-[5px] md:rounded-[10px] mb-[20px]">
        <div class="flex gap-[10px] md:gap-[25px] w-[100%] ">
            <input type="text" name="" id=""
                class="w-[100%] bg-[#F6F6F6] px-[15px] py-[12px] text-[12px] font-[500] text-[#808080] border-[1px] border-[#E6E6E6] rounded-[4px] hover:outline-none focus:outline-none"
                placeholder="Search file here">
            <button
                class="bg-[#4EF953] px-[20px] py-[12px] w-[100px] rounded-[4px] text-[14px] font-[500] text-[#fff] text-center">Search</button>
        </div>
    </div> --}}


    <div class="flex items-stretch justify-between flex-wrap md:flex-nowrap gap-[20px]">
        <div class="flex flex-col gap-[5px] w-[100%] md:w-[100%] bg-[#fff] rounded-[5px] md:rounded-[10px] p-[15px]">
            <h2 class="mb-[2px] text-[20px] text-[#1A1A1A] font-[600] ">
                Your Payment Terms
            </h2>
            <p class="text-[14px] font-[500] text-[#898989] mb-[20px]">Once you have reached the minimum amount and the
                specified time has elapsed, the balance will be directly sent to your HereWPay account.</p>
            <div
                class="flex items-center gap-[20px] p-[15px] bg-[#4ef9532e] border-[1px] border-[#4ef95370] rounded-[8px] h-[100px]">
                <div class="flex items-center justify-center rounded-[100px] w-[60px] h-[60px] bg-[#fff]">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13.6414 0.573633C13.7547 0.525051 13.8767 0.5 14 0.5C14.1234 0.5 14.2454 0.525051 14.3587 0.573633L26.7441 5.88244L14 11.3442L1.25599 5.88244L13.6414 0.573633ZM0.345703 7.47363V21.4375C0.345703 21.8016 0.564173 22.1293 0.897339 22.2749L13.0898 27.5V12.9354L0.345703 7.47363ZM14.9103 12.9354L27.6544 7.47363V21.4375C27.6546 21.6157 27.6024 21.7901 27.5043 21.939C27.4062 22.0879 27.2666 22.2047 27.1028 22.2749L14.9103 27.5V12.9354Z"
                            fill="#4EF953" />
                    </svg>
                </div>
                <div class="flex flex-col gap-[1px]">
                    <h2 class="text-[16px] font-[500] text-[#898989] mb-[0]">NET</h2>
                    <h3 class="text-[24px] font-[700] text-[#1A1A1A]">30</h3>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-[10px] w-[100%] md:w-[100%] bg-[#fff] rounded-[5px] md:rounded-[10px] p-[15px]">
            <h2 class="text-[20px] text-[#1A1A1A] font-[600] mb-[15px] ">
                Earnings
            </h2>
            <div
                class="flex items-center justify-between gap-[20px] p-[15px] bg-[#4ef9532e] border-[1px] border-[#4ef95370] rounded-[8px] h-[60px]">
                <h2 class="text-[16px] font-[500] text-[#898989] mb-[0]">Balance</h2>
                <h3 class="text-[24px] font-[700] text-[#1A1A1A]">30</h3>
            </div>

            <div
                class="flex items-center justify-between gap-[20px] p-[15px] bg-[#4ef9532e] border-[1px] border-[#4ef95370] rounded-[8px] h-[60px]">
                <h2 class="text-[16px] font-[500] text-[#898989] mb-[0]">Total Paid</h2>
                <h3 class="text-[24px] font-[700] text-[#1A1A1A]">$350</h3>
            </div>
        </div>
    </div>



    <div class="flex items-center justify-between gap-[20px] mt-[20px]">
        <div class="flex justify-between items-start md:items-center flex-col md:flex-row gap-[15px] w-[100%] bg-[#fff] rounded-[5px] md:rounded-[10px] p-[15px]">
            <div class="flex flex-col gap-[5px]">
                <h2 class="mb-[2px] text-[20px] text-[#1A1A1A] font-[600] ">
                    NOW Payments Integration
                </h2>
                <p class="text-[14px] font-[500] text-[#898989] mb-[10px]">NOWPayments a cryptocurrency payment gateway
                    for accepting Bitcoin, Ethereum, stablecoins and over 160 other cryptos</p>
                <button class="flex items-center justify-center w-[170px] md:w-[170px] px-[4px] py-[12px] md:px-[15px] md:py-[12px] rounded-[5px] bg-[#4EF953]  hover:bg-[#000] text-[12px] md:text-[14px] font-[500] text-[#fff] hover:text-[#fff]">Enter
                    NowPayments</button>
            </div>

            <div class="w-[250px] flex items-center ">
                <img src="/images/payment.png" alt="img">
            </div>
        </div>

    </div>


    <div class="flex items-center justify-between gap-[20px] mt-[20px]">
        <div class="flex flex-col justify-between items-start gap-[5px] w-[100%] bg-[#fff] rounded-[5px] md:rounded-[10px] p-[15px]">
            <div class="flex flex-row items-center justify-between w-full gap-[5px] mb-[10px]">
                <h2 class="text-[20px] text-[#1A1A1A] font-[600] ">
                    Bills/Invoices
                </h2>
                <!-- Filters -->
                <div class="flex flex-wrap items-center gap-[10px]">
                    <!-- Date Range -->
                    <input type="date" class="h-[37px] text-[14px] border border-[#E6E6E6] rounded-[5px] px-[10px] py-[6px] text-[#1A1A1A] !outline-none focus:!outline-none">
                    <span class="text-[#808080] text-[14px]">to</span>
                    <input type="date" class="h-[37px] text-[14px] border border-[#E6E6E6] rounded-[5px] px-[10px] py-[6px] text-[#1A1A1A] !outline-none focus:!outline-none">

                    <!-- Status Dropdown -->
                    <select class="h-[37px] text-[14px] border border-[#E6E6E6] rounded-[5px] px-[10px] py-[6px] text-[#1A1A1A] !outline-none focus:!outline-none">
                        <option value="">Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="w-[100%] overflow-x-auto tableScroll">
                <table class="w-[100%] border-collapse border-spacing-0 rounded-[10px] border-separate border border-[#E6E6E6]">
                    <tr>
                        <th
                            class="bg-[#F6F6F6] rounded-tl-[10px] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left  whitespace-nowrap ">
                            Invoice Number</th>
                        <th class="bg-[#F6F6F6] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left  whitespace-nowrap">
                            Description</th>
                        <th class="bg-[#F6F6F6] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left  whitespace-nowrap">
                            Invoice Date</th>
                        <th class="bg-[#F6F6F6] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left  whitespace-nowrap">
                            Amount</th>
                        <th class="bg-[#F6F6F6] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left  whitespace-nowrap">Due
                            Date</th>
                        <th class="bg-[#F6F6F6] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left  whitespace-nowrap">
                            Payment Date</th>
                        <th class="bg-[#F6F6F6] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left  whitespace-nowrap">
                            Status</th>
                        <th
                            class="bg-[#F6F6F6] rounded-tr-[10px] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left  whitespace-nowrap">
                            Action</th>
                    </tr>

                    <tr>
                        <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  whitespace-nowrap ">Bill-00660455</td>
                        <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  whitespace-nowrap ">SEP 2024 Activity</td>
                        <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  whitespace-nowrap ">Sep 30, 2024</td>
                        <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  whitespace-nowrap ">USD 7.94</td>
                        <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  whitespace-nowrap ">Nov 30, 2024</td>
                        <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  whitespace-nowrap ">Nov 30, 2024</td>
                        <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  whitespace-nowrap ">
                            <div
                                class="inline-flex bg-[#F3FEE7] border border-[#BCEE89] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#6EBF1A] text-center uppercase">
                                Paid</div>
                        </td>
                        <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left  whitespace-nowrap ">
                            <button
                                class="inline-flex bg-[#4ef9532e] border border-[#4ef95370] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#6EBF1A] text-center uppercase"><svg
                                    width="12" height="16" viewBox="0 0 12 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.75 1C6.75 0.585786 6.41421 0.25 6 0.25C5.58579 0.25 5.25 0.585786 5.25 1H6.75ZM5.46967 15.5303C5.76256 15.8232 6.23744 15.8232 6.53033 15.5303L11.3033 10.7574C11.5962 10.4645 11.5962 9.98959 11.3033 9.6967C11.0104 9.40381 10.5355 9.40381 10.2426 9.6967L6 13.9393L1.75736 9.6967C1.46447 9.40381 0.989592 9.40381 0.696699 9.6967C0.403806 9.98959 0.403806 10.4645 0.696699 10.7574L5.46967 15.5303ZM5.25 1V15H6.75V1H5.25Z"
                                        fill="#4EF953" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="w-[100%] flex items-center justify-between flex-col gap-[15px] md:flex-row mt-[30px]">
                <h2 class="text-[14px] text-[#808080] font-[500]">Showing 1 to 4 of 4 entries</h2>
                <div class="inline-flex gap-[8px]">
                    <a href="#"
                        class="group inline-flex gap-[8px] items-center bg-[#4ef9532e] border border-[#4ef95370] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#4EF953] text-center hover:bg-[#4EF953] hover:text-[#fff]">
                        <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 1L1 5L5 9" stroke="#4EF953" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" class="group-hover:stroke-[#fff] " />
                        </svg> Previous</a>

                    <a href="#"
                        class="inline-flex gap-[8px] items-center bg-[#fff] border border-[#E6E6E6] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#808080] text-center hover:bg-[#4EF953] hover:text-[#fff]">1</a>

                    <a href="#"
                        class="inline-flex gap-[8px] items-center bg-[#fff] border border-[#E6E6E6] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#808080] text-center hover:bg-[#4EF953] hover:text-[#fff]">2</a>

                    <a href="#"
                        class="inline-flex gap-[8px] items-center bg-[#fff] border border-[#E6E6E6] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#808080] text-center hover:bg-[#4EF953] hover:text-[#fff]">3</a>


                    <a href="#"
                        class="group inline-flex gap-[5px] items-center bg-[#4ef9532e] border border-[#4ef95370] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#4EF953] text-center hover:bg-[#4EF953] hover:text-[#fff]">
                        Next <svg width="6" height="10" viewBox="0 0 6 10" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L5 5L1 9" stroke="#4EF953" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" class="group-hover:stroke-[#fff] " />
                        </svg> </a>


                </div>
            </div>
        </div>

    </div>









</div>

@stop