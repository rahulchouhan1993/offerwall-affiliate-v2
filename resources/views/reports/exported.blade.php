@extends('layouts.default')
@section('content')
<div class="bg-[#f2f2f2] p-[15px] lg:p-[35px]">
        <div class="bg-[#fff] p-[15px] md:p-[20px] rounded-[10px] mb-[20px]">
            <div class="flex items-center justify-between gap-[25px] w-[100%]  mb-[15px]">
                <h2 class="text-[20px] text-[#1A1A1A] font-[600]">All export Files</h2>
               
            </div>

            <div class="flex items-center justify-between flex-wrap lg:flex-nowrap gap-[10px]">
               

                <div class="inline-flex w-[100%] md:w-auto items-center gap-[10px]">
                    <input type="text" name="" id="" class="w-[100%] md:w-[250] lg:w-[290] xl:w-[300px] bg-[#F6F6F6] px-[15px] py-[10px] text-[12px] font-[500] text-[#808080] border-[1px] border-[#E6E6E6] rounded-[4px] hover:outline-none focus:outline-none" placeholder="Search file here">
                    <button class="w-[100px] md:w-[100px] lg:w-[107px] bg-[#D272D2] px-[20px] py-[10px] w-[100px] rounded-[4px] text-[14px] font-[500] text-[#fff] text-center">Search</button>
                </div>
            </div>



            <div class="flex flex-col justify-between items-center gap-[5px] w-[100%] mt-[30px] ">
                
                <div class="w-[100%] overflow-x-scroll tableScroll">
                    <table class="w-[100%] border-collapse border-spacing-0 rounded-[10px] border-separate border border-[#E6E6E6]">
                        <tr>
                            <th class="w-[95px] bg-[#F6F6F6] rounded-tl-[10px] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-center whitespace-nowrap "></th>
                            <th class="bg-[#F6F6F6] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap">Export Date</th>
                            <th class="bg-[#F6F6F6] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap">Report Type</th>
                            <th class="bg-[#F6F6F6] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap">Exported report</th>
                        </tr>

                        <tr>
                            <td class="border-b-[1px] border-b-[#E6E6E6] max-w-[95px] text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-center whitespace-normal "><svg class="m-auto" width="21" height="26" viewBox="0 0 21 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.7 9.1V1.95L18.85 9.1M2.6 0C1.157 0 0 1.157 0 2.6V23.4C0 24.0896 0.273928 24.7509 0.761522 25.2385C1.24912 25.7261 1.91044 26 2.6 26H18.2C18.8896 26 19.5509 25.7261 20.0385 25.2385C20.5261 24.7509 20.8 24.0896 20.8 23.4V7.8L13 0H2.6Z" fill="#D272D2"/>
                                </svg>
                                </td>
                            <td class="border-b-[1px] border-b-[#E6E6E6] text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap ">Dec 20. 2024</td>
                            <td class="border-b-[1px] border-b-[#E6E6E6] text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap ">PDF</td>
                            <td class="border-b-[1px] border-b-[#E6E6E6] text-[14px] font-[500] text-[#5E72E4] px-[10px] py-[10px] text-left whitespace-nowrap ">Reports001.pdf</td>
                           
                        </tr>

                        <tr>
                            <td class="border-b-[1px] border-b-[#E6E6E6] max-w-[200px] text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-center whitespace-normal "><svg class="m-auto" width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.8942 1.768L17.3017 0H4.7606C3.8558 0 3.5061 0.6708 3.5061 1.1947V5.9137H5.265V2.1489C5.265 1.9487 5.434 1.7797 5.629 1.7797H14.6029C14.8005 1.7797 14.8993 1.8148 14.8993 1.9773V8.2433H21.2862C21.5371 8.2433 21.6346 8.3733 21.6346 8.5631V23.8641C21.6346 24.1839 21.5046 24.232 21.3096 24.232H5.629C5.5323 24.2296 5.4403 24.1898 5.37239 24.121C5.30449 24.0521 5.26598 23.9595 5.265 23.8628V22.464H3.5178V24.6675C3.4944 25.4475 3.9104 26 4.7606 26H22.178C23.088 26 23.3987 25.3409 23.3987 24.7403V6.7431L22.9437 6.2491L18.8942 1.768ZM16.6868 1.976L17.1899 2.5402L20.5647 6.2491L20.7506 6.474H17.3017C17.0417 6.474 16.877 6.43067 16.8077 6.344C16.7384 6.25907 16.6981 6.12343 16.6868 5.9371V1.976ZM15.2698 13.8671H21.2199V15.6013H15.2685L15.2698 13.8671ZM15.2698 10.4013H21.2199V12.1342H15.2685L15.2698 10.4013ZM15.2698 17.3342H21.2199V19.0684H15.2685L15.2698 17.3342ZM0 7.3138V21.1809H13.6045V7.3138H0ZM6.8029 15.379L5.9709 16.6504H6.8029V18.2H2.6208L5.655 13.637L2.9666 9.5342H5.213L6.8042 11.921L8.3941 9.5342H10.6392L7.9456 13.637L10.9837 18.2H8.6528L6.8029 15.379Z" fill="#75B237"/>
                                </svg>
                                
                                </td>
                            <td class="border-b-[1px] border-b-[#E6E6E6] text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap ">Dec 20. 2024</td>
                            <td class="border-b-[1px] border-b-[#E6E6E6] text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap ">PDF</td>
                            <td class="border-b-[1px] border-b-[#E6E6E6] text-[14px] font-[500] text-[#5E72E4] px-[10px] py-[10px] text-left whitespace-nowrap ">Reports001.pdf</td>
                           
                        </tr>

                        <tr>
                            <td class="max-w-[200px] text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-center whitespace-normal "><svg class="m-auto" width="21" height="26" viewBox="0 0 21 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.5 14.3H14.3C14.6683 14.3 14.9773 14.1752 15.2269 13.9256C15.4765 13.676 15.6009 13.3675 15.6 13C15.5991 12.6325 15.4743 12.324 15.2256 12.0744C14.9769 11.8248 14.6683 11.7 14.3 11.7H6.5C6.13167 11.7 5.82313 11.8248 5.5744 12.0744C5.32567 12.324 5.20087 12.6325 5.2 13C5.19913 13.3675 5.32393 13.6764 5.5744 13.9269C5.82487 14.1774 6.1334 14.3017 6.5 14.3ZM6.5 18.2H14.3C14.6683 18.2 14.9773 18.0752 15.2269 17.8256C15.4765 17.576 15.6009 17.2675 15.6 16.9C15.5991 16.5325 15.4743 16.224 15.2256 15.9744C14.9769 15.7248 14.6683 15.6 14.3 15.6H6.5C6.13167 15.6 5.82313 15.7248 5.5744 15.9744C5.32567 16.224 5.20087 16.5325 5.2 16.9C5.19913 17.2675 5.32393 17.5764 5.5744 17.8269C5.82487 18.0774 6.1334 18.2017 6.5 18.2ZM6.5 22.1H10.4C10.7683 22.1 11.0773 21.9752 11.3269 21.7256C11.5765 21.476 11.7009 21.1675 11.7 20.8C11.6991 20.4325 11.5743 20.124 11.3256 19.8744C11.0769 19.6248 10.7683 19.5 10.4 19.5H6.5C6.13167 19.5 5.82313 19.6248 5.5744 19.8744C5.32567 20.124 5.20087 20.4325 5.2 20.8C5.19913 21.1675 5.32393 21.4764 5.5744 21.7269C5.82487 21.9774 6.1334 22.1017 6.5 22.1ZM2.6 26C1.885 26 1.27313 25.7456 0.7644 25.2369C0.255666 24.7282 0.000866667 24.1159 0 23.4V2.6C0 1.885 0.2548 1.27313 0.7644 0.7644C1.274 0.255667 1.88587 0.000866667 2.6 0H11.9275C12.2742 0 12.6048 0.0650001 12.9194 0.195C13.234 0.325 13.51 0.509167 13.7475 0.7475L20.0525 7.0525C20.2908 7.29083 20.475 7.5673 20.605 7.8819C20.735 8.1965 20.8 8.5267 20.8 8.8725V23.4C20.8 24.115 20.5456 24.7273 20.0369 25.2369C19.5282 25.7465 18.9159 26.0009 18.2 26H2.6ZM11.7 7.8C11.7 8.16833 11.8248 8.4773 12.0744 8.7269C12.324 8.9765 12.6325 9.10087 13 9.1H18.2L11.7 2.6V7.8Z" fill="#4D64E7"/>
                                </svg>
                                
                                
                                </td>
                            <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap ">Dec 20. 2024</td>
                            <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap ">PDF</td>
                            <td class="text-[14px] font-[500] text-[#5E72E4] px-[10px] py-[10px] text-left whitespace-nowrap ">Reports001.pdf</td>
                           
                        </tr>
                    </table>
                </div>


                <div class="w-[100%] flex flex-col gap-[10px] md:gap-[0] md:flex-row justify-between mt-[30px]">
                    <h2 class="text-[14px] text-[#808080] font-[500]">Showing 1 to 4 of 4 entries</h2>
                    <div class="inline-flex gap-[8px]">
                        <a href="#"
                            class="group inline-flex gap-[8px] items-center bg-[#F5EAF5] border border-[#FED5C3] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#D272D2] text-center hover:bg-[#D272D2] hover:text-[#fff]">
                            <svg width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 1L1 5L5 9" stroke="#D272D2" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" class="group-hover:stroke-[#fff] " />
                            </svg> Previous</a>

                        <a href="#"
                            class="inline-flex gap-[8px] items-center bg-[#fff] border border-[#E6E6E6] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#808080] text-center hover:bg-[#D272D2] hover:text-[#fff]">1</a>

                        <a href="#"
                            class="inline-flex gap-[8px] items-center bg-[#fff] border border-[#E6E6E6] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#808080] text-center hover:bg-[#D272D2] hover:text-[#fff]">2</a>

                        <a href="#"
                            class="inline-flex gap-[8px] items-center bg-[#fff] border border-[#E6E6E6] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#808080] text-center hover:bg-[#D272D2] hover:text-[#fff]">3</a>


                        <a href="#"
                            class="group inline-flex gap-[5px] items-center bg-[#F5EAF5] border border-[#FED5C3] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#D272D2] text-center hover:bg-[#D272D2] hover:text-[#fff]">
                            Next <svg width="6" height="10" viewBox="0 0 6 10" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L5 5L1 9" stroke="#D272D2" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" class="group-hover:stroke-[#fff] " />
                            </svg> </a>


                    </div>
                </div>
            </div>

        </div>


    


    </div>
@stop