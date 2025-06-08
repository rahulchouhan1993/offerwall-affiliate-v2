@extends('layouts.default')
@section('content')

<div class="p-[15px] md:p-[35px]">
    <div class="flex items-center justify-between gap-[20px] mt-[20px]">
        <div class="flex flex-col justify-between items-start gap-[5px] w-[100%] bg-[#fff] rounded-[5px] md:rounded-[10px] p-[15px]">
            <div class="flex flex-row items-center justify-between w-full gap-[5px] mb-[15px]">
                <h2 class="text-[16px] text-[#1A1A1A] font-[500] ">
                    Payment Methods
                </h2>
                <button type="button" onclick="openModal()" class="bg-[#4EF953] px-[20px] py-[5px] rounded-[4px] text-[14px] font-[500] text-[#fff] text-center cursor-pointer">Add</button>
            </div>
            <div class="w-[100%] overflow-x-auto tableScroll">
                <table class="w-[100%] border-collapse border-spacing-0 rounded-[10px] border-separate border border-[#E6E6E6]">
                    <tr>
                        <th
                            class="bg-[#F6F6F6] rounded-tl-[10px] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left  whitespace-nowrap ">
                            Serial Number</th>
                        <th class="bg-[#F6F6F6] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left  whitespace-nowrap">
                            Payment Method</th>
                        <th class="bg-[#F6F6F6] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left  whitespace-nowrap">
                            Bank Name</th>
                        <th class="bg-[#F6F6F6] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left  whitespace-nowrap">
                            Branch</th>
                        <th class="bg-[#F6F6F6] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left  whitespace-nowrap">IFSC</th>
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
                            <label class="relative cursor-pointer">
                                <input type="checkbox" name="payment" value="option1" class="sr-only peer" checked>
                                <div class="w-10 h-5 rounded-full bg-gray-300 peer-checked:bg-[#4EF953] transition-colors duration-300"></div>
                                <div class="absolute left-0 top-0 w-5 h-5 bg-white border rounded-full shadow transform peer-checked:translate-x-5 transition-transform duration-300"></div>
                              </label>
                        </td>
                        <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-center  whitespace-nowrap ">
                            <button
                                ><svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 5H3C2.46957 5 1.96086 5.21071 1.58579 5.58579C1.21071 5.96086 1 6.46957 1 7V16C1 16.5304 1.21071 17.0391 1.58579 17.4142C1.96086 17.7893 2.46957 18 3 18H12C12.5304 18 13.0391 17.7893 13.4142 17.4142C13.7893 17.0391 14 16.5304 14 16V15" stroke="#4EF953" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13 3L16 6M17.385 4.585C17.7788 4.19115 18.0001 3.65698 18.0001 3.1C18.0001 2.54302 17.7788 2.00885 17.385 1.615C16.9912 1.22115 16.457 0.999893 15.9 0.999893C15.343 0.999893 14.8088 1.22115 14.415 1.615L6 10V13H9L17.385 4.585Z" stroke="#4EF953" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    
                                </svg>
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
            
        </div>

    </div>
</div>

<!-- Modal -->
<div id="myModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white w-full max-w-md mx-auto p-6 rounded-lg shadow-lg relative">
      <h2 class="text-xl font-semibold ">Add Payment Methods</h2>
      <div class="modal_body py-[20px]">
        <p class="text-[14px] text-[#898989]">Choose Method</p>
        <select name="methods" id="" class="w-full bg-transparent border-[1px] border-[solid] border-[#e9e9e9] h-[45px] rounded-[5px] text-[14px] text-[#4D4D4D] p-[10px] !outline-none focus:!outline-none">
            <option value="">Bank Transfer</option>
            <option value="">Credit Card</option>
            <option value="">Debit Card</option>
            <option value="">UPI</option>
        </select>
      </div>
      <div class="flex justify-end space-x-2 mt-4">
        <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
        <button class="px-4 py-2 bg-[#4EF953] text-white rounded">Confirm</button>
      </div>
      <button onclick="closeModal()" class="absolute top-1 right-2 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
    </div>
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
  </script>

@stop