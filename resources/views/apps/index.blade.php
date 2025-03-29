@extends('layouts.default')
@section('content')
<div class="bg-[#f2f2f2] p-[15px] lg:p-[35px]">
    <div class="bg-[#fff] p-[15px] md:p-[20px] rounded-[10px] mb-[20px]">
       <div class="flex items-center justify-between gap-[25px] w-[100%]  mb-[15px]">
          <h2 class="text-[20px] text-[#1A1A1A] font-[600]">My Apps</h2>
          <a href="{{ route('apps.add') }}" class="flex items-center justify-center gap-[13px] w-[130px] lg:w-[149px] bg-[#49fb53] px-[20px] py-[10px] w-[100px] rounded-[4px] text-[14px] font-[500] text-[#000] text-center">
             <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.375 0.375C7.72 0.375 8 0.655 8 1V6.375H13.375C13.5408 6.375 13.6997 6.44085 13.8169 6.55806C13.9342 6.67527 14 6.83424 14 7C14 7.16576 13.9342 7.32473 13.8169 7.44194C13.6997 7.55915 13.5408 7.625 13.375 7.625H8V13C8 13.1658 7.93415 13.3247 7.81694 13.4419C7.69973 13.5592 7.54076 13.625 7.375 13.625C7.20924 13.625 7.05027 13.5592 6.93306 13.4419C6.81585 13.3247 6.75 13.1658 6.75 13V7.625H1.375C1.20924 7.625 1.05027 7.55915 0.933058 7.44194C0.815848 7.32473 0.75 7.16576 0.75 7C0.75 6.83424 0.815848 6.67527 0.933058 6.55806C1.05027 6.44085 1.20924 6.375 1.375 6.375H6.75V1C6.75 0.655 7.03 0.375 7.375 0.375Z" fill="#000"/>
             </svg>
             New App
            </a>
       </div>
       <div class="flex flex-col justify-between items-center gap-[5px] w-[100%] mt-[30px] ">
          <div class="w-[100%] overflow-x-scroll tableScroll">
             <table class="w-[100%] border-collapse border-spacing-0 rounded-[10px] border-separate border border-[#E6E6E6]">
                <tr>
                   <th class="bg-[#F6F6F6] rounded-tl-[10px] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap ">Name</th>
                   <th class="bg-[#F6F6F6] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap">Approval Status</th>
                   <th class="bg-[#F6F6F6] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap">App Status</th>
                   <th class="bg-[#F6F6F6] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-left whitespace-nowrap">Created</th>
                   <th class="w-[130px] bg-[#F6F6F6] text-[14px] font-[500] text-[#1A1A1A] px-[10px] py-[13px] text-right whitespace-nowrap">Actions</th>
                </tr>
                @if($allApps && $allApps->isNotEmpty())
                @foreach ($allApps as $apps)
                <tr>
                    <td class="max-w-[500px] text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-normal ">
                       <strong>{{ $apps->appName }}</strong>
                       <p class="whitespace-normal text-[12px] text-[#808080]">{{ $apps->appUrl }}</p>
                    </td>
                    @if( $apps->status==1)
                    <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap ">
                        <a href="javascript:void(0);" class="inline-flex bg-[#F3FEE7] border border-[#BCEE89] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#6EBF1A] text-center uppercase">Aprroved</a>
                     </td>
                    @else
                    <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap ">
                        <a href="javascript:void(0);" class="inline-flex bg-[#fee7e7] border border-[#ee8989] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#bf1a1a] text-center uppercase">Not Approved</a>
                     </td>
                    @endif

                    @if( $apps->affiliate_status==1)
                    <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap ">
                        <a href="{{ route('apps.status',['id'=>$apps->id]) }}" class="inline-flex bg-[#F3FEE7] border border-[#BCEE89] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#6EBF1A] text-center uppercase">Active</a>
                     </td>
                    @else
                    <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap ">
                        <a href="{{ route('apps.status',['id'=>$apps->id]) }}" class="inline-flex bg-[#fee7e7] border border-[#ee8989] rounded-[5px] px-[10px] py-[4px] text-[12px] font-[600] text-[#bf1a1a] text-center uppercase">Archived</a>
                     </td>
                    @endif
                    
                    <td class="text-[14px] font-[500] text-[#808080] px-[10px] py-[10px] text-left whitespace-nowrap ">{{ date('d M Y',strtotime($apps->created_at)) }}</td>
                    <td class="w-[130px] text-[14px] font-[500] text-[#5E72E4] px-[10px] py-[10px] text-left whitespace-nowrap ">
                       <div class="flex items-center justify-end gap-[10px]">
                          <a title="Edit" href="{{ route('apps.add',['id'=>$apps->id]) }}" class="flex items-center justify-center w-[35px] bg-[#49fb53] py-[10px] w-[100px] border border-[#49fb53] rounded-[4px] text-[14px] font-[500] text-[#000] text-center">
                           <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 16 16" fill="none">
                              <path d="M8.29289 3.70711L1 11V15H5L12.2929 7.70711L8.29289 3.70711Z" fill="#000"/>
                              <path d="M9.70711 2.29289L13.7071 6.29289L15.1716 4.82843C15.702 4.29799 16 3.57857 16 2.82843C16 1.26633 14.7337 0 13.1716 0C12.4214 0 11.702 0.297995 11.1716 0.828428L9.70711 2.29289Z" fill="#000"/>
                           </svg> 
                           </a>
                           @if( $apps->status==1 && $apps->affiliate_status==1)
                           <a title="Integration" href="{{ route('apps.integration',['id'=>$apps->id]) }}" class="flex items-center justify-center w-[35px] bg-[#49fb53] py-[10px] w-[100px] border border-[#49fb53] rounded-[4px] text-[14px] font-[500] text-[#000] text-center">
                           <svg xmlns="http://www.w3.org/2000/svg"  width="14" height="14" viewBox="0 0 16 16" fill="none">
                              <path d="M8.01005 0.858582L6.01005 14.8586L7.98995 15.1414L9.98995 1.14142L8.01005 0.858582Z" fill="#D272D2"/>
                              <path d="M12.5 11.5L11.0858 10.0858L13.1716 8L11.0858 5.91422L12.5 4.5L16 8L12.5 11.5Z" fill="#D272D2"/>
                              <path d="M2.82843 8L4.91421 10.0858L3.5 11.5L0 8L3.5 4.5L4.91421 5.91422L2.82843 8Z" fill="#D272D2"/>
                              </svg>
                           </a>
                           <a title="Template" href="{{ route('apps.template',['id'=>$apps->id]) }}" class="flex items-center justify-center w-[35px] bg-[#FFF3ED] py-[10px] w-[100px] border border-[#FED5C3] rounded-[4px] text-[14px] font-[500] text-[#D272D2] text-center">
                             <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" >
                              <path fill-rule="evenodd" clip-rule="evenodd" d="M16 2H0V14H16V2ZM3 6C3.55228 6 4 5.55228 4 5C4 4.44772 3.55228 4 3 4C2.44772 4 2 4.44772 2 5C2 5.55228 2.44772 6 3 6ZM7.5 5C7.5 5.55228 7.05228 6 6.5 6C5.94772 6 5.5 5.55228 5.5 5C5.5 4.44772 5.94772 4 6.5 4C7.05228 4 7.5 4.44772 7.5 5ZM10 6C10.5523 6 11 5.55228 11 5C11 4.44772 10.5523 4 10 4C9.44771 4 9 4.44772 9 5C9 5.55228 9.44771 6 10 6Z" fill="#D272D2"/>
                              </svg>
                            </a>
                            @endif
                       </div>
                    </td>
                 </tr>
                @endforeach
                @endif
             </table>
          </div>
       </div>
    </div>
 </div>
@stop