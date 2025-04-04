<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Template;
use App\Models\TestPostback;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AppsController extends Controller
{
    public function index(){
        $pageTitle = 'Apps';
        $allApps = App::where('affiliateId',auth()->user()->id)->get();
        return view('apps.index',compact('pageTitle','allApps'));
    }

    public function add(Request $request, $id =null){
        $pageTitle = 'Apps';
        if($id>0){
            $appData = App::find($id);
        }else{
            $appData = new App();
        }
        
        if($request->isMethod('POST')){
            if($id==null){
                $appData->appId = md5(rand());
                $appData->secrect_key = md5(rand());
                $appData->affiliateId = auth()->user()->id;
                $appData->status = 0;
                $appData->affiliate_status = 1;
            }else{
                if($request->appurl!=$appData->appUrl){
                    $appData->status = 0;
                }
            }
            $appData->appName = $request->appname;
            $appData->appUrl = $request->appurl;
            $appData->currencyName = $request->currencyname;
            $appData->currencyNameP = $request->currencynamep;
            $appData->currencyValue = $request->currencyvalue;
            $appData->rounding = $request->rounding;
            $appData->postback = $request->postback;
            if($appData->save()){
                if($id>0){
                    return redirect()->route('apps.index')->with('success', 'App updated successfully!!');
                }else{
                    $defaultTemplate = Template::find(1);
                    $templateColor = new Template();
                    $templateColor->user_id = auth()->user()->id;
                    $templateColor->app_id = $appData->id;
                    $templateColor->headerBg = $defaultTemplate->headerBg;
                    $templateColor->headerMenuBg = $defaultTemplate->headerMenuBg;
                    $templateColor->headerActiveBg = $defaultTemplate->headerActiveBg;
                    $templateColor->headerActiveTextColor = $defaultTemplate->headerActiveTextColor;
                    $templateColor->headerNonActiveTextColor = $defaultTemplate->headerNonActiveTextColor;
                    $templateColor->bodyBg = $defaultTemplate->bodyBg;
                    $templateColor->offerBg = $defaultTemplate->offerBg;
                    $templateColor->offerText = $defaultTemplate->offerText;
                    $templateColor->offerButtonBg = $defaultTemplate->offerButtonBg;
                    $templateColor->offerButtonText = $defaultTemplate->offerButtonText;
                    $templateColor->offerBadgeBg = $defaultTemplate->offerBadgeBg;
                    $templateColor->offerBadgeText = $defaultTemplate->offerBadgeText;
                    $templateColor->footerBg = $defaultTemplate->footerBg;
                    $templateColor->footerText = $defaultTemplate->footerText;
                    $templateColor->save();
                    return redirect()->route('apps.index')->with('success', 'App added successfully!!');
                }
            }else{
                return redirect()->route('apps.index')->with('error', 'Sonething went wrong, please try again.');
            }
        }
        return view('apps.add',compact('pageTitle','appData','id'));
    }

    public function integration($id){
        $pageTitle = 'Integration';
        $appDetail = App::find($id);
        return view('apps.integration',compact('pageTitle','appDetail'));
    }

    public function updateStatus($id){
        $appDetail = App::find($id);
        $appDetail->affiliate_status = ($appDetail->affiliate_status==1) ? '0' : '1';
        $appDetail->save();

        return redirect()->back()->with('success','Status updated');
    }

    public function template(Request $request, $id){
        $settingsData = Setting::find(1);
        $appDetail = App::where('affiliateId',auth()->user()->id)->where('id',$id)->first();
        if(empty($appDetail)){
            return redirect()->route('dashboard.index')->with('error','Not valid request');
        }
        $pageTitle = $appDetail->appName.' Template';
        $templateColor = Template::where('app_id',$id)->first();
        if($request->isMethod('post')){
            $templateColor->headerBg = $request->headerBg;
            $templateColor->headerMenuBg = $request->headerMenuBg;
            $templateColor->headerActiveBg = $request->headerActiveBg;
            $templateColor->headerActiveTextColor = $request->headerActiveTextColor;
            $templateColor->headerNonActiveTextColor = $request->headerNonActiveTextColor;
            $templateColor->bodyBg = $request->bodyBg;
            $templateColor->offerBg = $request->offerBg;
            $templateColor->offerText = $request->offerText;
            $templateColor->offerButtonBg = $request->offerButtonBg;
            $templateColor->offerButtonText = $request->offerButtonText;
            $templateColor->offerBadgeBg = $request->offerBadgeBg;
            $templateColor->offerBadgeText = $request->offerBadgeText;
            $templateColor->footerBg = $request->footerBg;
            $templateColor->footerText = $request->footerText;
            $templateColor->save();
            return redirect()->back()->with('success','Template updated successfully');
        }
        return view('apps.template',compact('pageTitle','templateColor','appDetail','settingsData'));
    }

    public function documentations(){
        $pageTitle = 'Documentation';
        return view('apps.documentations',compact('pageTitle'));
    }

    public function testPostback(Request $request){
        $pageTitle = 'Test-Postback';
        $allApps = App::where('affiliateId',auth()->user()->id)->get();
        $allPostbacks = TestPostback::where('user_id',auth()->user()->id)->with('apps')->get();

        if($request->isMethod('post')){
            $appDetails = App::find($request->app_id);
            $postBackStatus = $this->sendPostback($appDetails->postback);
            $newPostback = new TestPostback();
            $newPostback->user_id = auth()->user()->id;
            $newPostback->app_id = $request->app_id;
            $newPostback->payout = $request->payout;
            $newPostback->ip = request()->ip();
            $newPostback->status = $postBackStatus['http_code'] ?? '500';
            $newPostback->error_detail = $postBackStatus['error'] ?? NULL;
            $newPostback->postback_url = $appDetails->postback;
            $newPostback->save();

            return redirect()->back()->with('success','Postback fired successfully');
        }
        
        return view('apps.test-postback',compact('pageTitle','allApps','allPostbacks'));
    }

    public function sendPostback($url){
        try {
            $response = Http::timeout(10)->get($url);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'error' => null,
                    'http_code' => $response->status(),
                    'response' => $response->body(),
                ];
            }

            return [
                'success' => false,
                'error' => "HTTP Error: " . $response->status(),
                'http_code' => $response->status(),
                'response' => $response->body(),
            ];
        } catch (\Illuminate\Http\Client\RequestException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'http_code' => $e->response ? $e->response->status() : 500,
                'response' => $e->response ? $e->response->body() : null,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'http_code' => 500,
                'response' => null,
            ];
        }
    }
}
