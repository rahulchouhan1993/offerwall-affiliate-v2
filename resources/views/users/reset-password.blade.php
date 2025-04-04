@extends('layouts.login')
@section('content')
<!-- <p>You will find this file in resources/views/users/login.blade.php</p> -->
<div class="flex flex-wrap lg:flex-nowrap justify-center w-[100%] max-[1920px] items-stretch gap-[0]">
    <div class="loginBx flex items-center flex-wrap md:flex-nowrap justify-center w-[100%] px-[20px] py-[50px] md:px-[30px] md:py-[60px]  lg:px-[20px] lg:py-[65px]   ">
        <div class="max-w-[450px] w-[100%] px-[20px] py-[35px] md:px-[40px] md:py-[65px] bg-[#fff] rounded-[10px] md:rounded-[15px]">
        <div class="logo1 flex items-center justify-center mb-[20px] md:mb-[50px]">
                <a href="#">
                    <img src="images/logo.png" alt="logo">
                </a>
            </div>
            <script>
                @if (session('success'))
                    toastr.success("{{ session('success') }}");
                @endif
            
                @if (session('error'))
                    toastr.error("{{ session('error') }}");
                @endif
            </script>
            <h2 class="text-[22px] text-center leading-[30px] md:text-[28px] md:leading-[30px] lg:text-[30px] lg:leading-[32px] font-[700] text-[#090B13]"> Enter your registered email with us!!</h2>
            <div class="mt-[30px] md:mt-[45px] lg:mt-[55px]">
                <form method="post">
                    @csrf
                <div class="flex flex-col gap-[25px]  ">
                    <div class="">
                        <div class="text-[16px] font-[600] text-[#1A1A1A] mb-[8px]">Email</div>
                        <div class="relative">
                            <input type="email" placeholder="Email" name="email"
                                class="block w-[100%] border-[1px] border-[#00000021] rounded-[7px] px-[15px] pr-[55px] py-[15px] bg-[#F6F6F6] hover:outline-none focus:outline-none">
                            <div class="absolute top-[16px] right-[22px]">
                            <i class="ri-mail-fill text-[#BFBFBF]"></i>

                            </div>
                        </div>
                    </div>
                </div> 
                <div class="text-right mt-[8px]">
                    <a id="resetPass" href="/" class="text-[14px] text-[#4EF953] font-[500]">Back To login</a>
                </div>
                <div class="mt-[30px]">
                    <button type="submit" class="w-[100%] bg-[#4EF953] px-[10px] py-[15px] text-[18px] text-[#210D0F] font-[500] text-center rounded-[8px] hover:bg-[#000] hover:text-[#fff]">
                    Request New Password
                    </button>
                </div>
                </form>
                <div class="flex items-center justify-between gap-[15px] mt-[60px]">
                    <div class="w-[48%] h-[1px] bg-[#ccc]"></div>
                    <div class="text-[14px] font-[500] text-[#898989]">OR</div>
                    <div class="w-[48%] h-[1px] bg-[#ccc]"></div>
                </div>
                <div class="mt-[50px] text-[14px] font-[500] text-[#898989] text-center">
                Don’t have an account? 
                    <a href="https://offerwallxxx.com/" class="text-[#4EF953] underline hover:text-[#000] hover:no-underline ">
                    Sign Up
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="w-[100%]  lg:w-[55%] max-w-[1070px]">
        <img class="w-[100%] max-w-[100%] h-[100%] " src="images/loginbanner.jpg" alt="">
    </div> -->
</div>
<script>
    function resetPass() {
    var element = document.getElementById("loginForm");
    element.classList.add("hide");

    var element = document.getElementById("resetpassword");
    element.classList.remove("hide");
    }
</script> 
@stop