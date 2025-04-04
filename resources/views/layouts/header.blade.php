@php
    use App\Models\Setting;
    $settingDetails = Setting::find(1);
@endphp
<div class="fixed w-[100%] h-[50px] md:h-[80px] lg:h-[80px] top-[0] z-[9] w-[100%] bg-[#fff]   flex items-center gap-[0]">
    <div class="flex items-center w-[200px] md:w-[230px] 2xl:w-[290px] bg-[#210D0F] py-[15px] px-[15px] md:py-[30px] md:px-[30px] lg:py-[30px] lg:px-[30px] head-logo">
        <img src="/images/logo.png" alt="img">
    </div>
    <div class="w-[100%] flex  items-center justify-between gap-[15px] font-[600] py-[15px] px-[7px] sm:px-[10px] md:py-[30px] md:px-[30px] lg:py-[30px] lg:px-[30px] head-w-cal">
        <div class="flex items-center  gap-[5px] md:gap-[10px] xl:gap-[15px]">
            <button id="menuToggle" class="p-[0]"><i class="ri-menu-line  text-[#4EF953] text-[20px] md:text-[25px]"></i></button>
            <h2 class="text-[#1A1A1A] text-[14px] md:text-[17px]  lg:text-[18px]  font-[600]">{{ $pageTitle }}</h2>
        </div>
        <div class="flex items-center  gap-[2px] sm:gap-[8px]">
        <div class="flex items-center gap-[2px] sm:gap-[8px] text-[15px] text-[#000]">
                <button class="flex items-center gap-[4px]">    
                <i class="ri-refresh-line text-[#49FB53]"></i>
                <span class="text-[0] sm:text-[15px]">Update States</span>
                </button>
            </div>

            <div class="m-1 hs-dropdown relative inline-flex gap-[5px]">
                <div class="flex items-center gap-[5px] mr-[8px]"><div><i class="ri-customer-service-2-line"></i></div> <a href="mailto:{{ $settingDetails->support_email }}" class="text-[0px] sm:text-[15px] text-[#000]"><span class="hidden md:flex">{{ $settingDetails->support_email }}</span></a></div>
                <button id="hs-dropdown-toggle" type="button"
                    class="hs-dropdown-toggle py-[4px] pl-[4px] pr-[15px] md:pr-[34px] 2xl:pl-[6px] 2xl:pr-[40px]  inline-flex items-center gap-x-2 1border 1border-[#E6E6E6] rounded-[60px] 1bg-[#F6F6F6] text-[13px] lg:text-[13px] 2xl:text-[16px] font-[600] text-[#1A1A1A] 1shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                    aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                    <img src="/images/usericon.png" alt="img" class="rouded-[60px] w-30px h-[30px] 2xl:w-40px 2xl:h-[40px]">
                    {{ auth()->user()->name }} 
                    <svg class="absolute right-[5px] md:right-[15px]" width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L5 5L9 1" stroke="#A1A1A1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                </button>

                <!-- Dropdown Menu -->
                <div id="hs-dropdown-menu"
                    class="px-[8px] py-[8px] min-w-[150px] hs-dropdown-menu transition-all duration-300 opacity-0 hidden bg-white rounded-[8px] absolute top-[40px] right-0 z-10 mt-2 shadow-[0_0px_13px_-3px_rgba(0,0,0,0.3)]"
                    role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-toggle">
                    <div class="p-1 space-y-0.5">
            

                        <a class="flex items-center gap-x-3.5 py-[10px] px-[10px] text-[13px] text-[#4D4D4D] font-[600] hover:bg-[#f2f2f2] focus:outline-none focus:bg-[f2f2f2]"
                            href="{{ route('dashboard.setting') }}"><i class="ri-settings-5-line"></i> Settings</a>

                        
                        <a class="flex items-center gap-x-3.5 py-[10px] px-[10px] text-[13px] text-[#67899A] font-[600] hover:bg-[#f2f2f2] focus:outline-none focus:bg-[f2f2f2]"
                            href="{{ route('users.logout') }}"><i class="ri-logout-box-r-line"></i> Sign Out</a>

                    </div>
                </div>
            </div>

            <script>
            document.getElementById('hs-dropdown-toggle').addEventListener('click', function() {
                var dropdownMenu = document.getElementById('hs-dropdown-menu');

                // Toggle visibility of the dropdown with transition
                if (dropdownMenu.classList.contains('hidden')) {
                    dropdownMenu.classList.remove('hidden');
                    setTimeout(() => {
                        dropdownMenu.classList.add('opacity-100'); // Fade in
                        dropdownMenu.style.maxHeight = dropdownMenu.scrollHeight + "px"; // Slide down
                    }, 10); // Delay for transition
                } else {
                    dropdownMenu.classList.remove('opacity-100');
                    dropdownMenu.style.maxHeight = 0; // Slide up
                    setTimeout(() => {
                        dropdownMenu.classList.add('hidden'); // Hide after animation
                    }, 300); // Match the duration of the transition
                }
            });
            </script>

        </div>
    </div>
</div>