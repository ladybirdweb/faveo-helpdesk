<?php

namespace App\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiExceptAuthController extends Controller
{
    public $api_controller;

    public function __construct(Request $request)
    {
        $this->request = $request;
        //$this->middleware('api');
    }

    /**
     * Check the url is valid or not.
     *
     * @return json
     */
    public function checkUrl()
    {
        //dd($this->request);
        try {
            $v = \Validator::make($this->request->all(), [
                'url' => 'required|url',
            ]);
            if ($v->fails()) {
                $error = $v->errors();

                return response()->json(compact('error'));
            }

            $url = $this->request->input('url');
            if (!Str::is('*/', $url)) {
                $url = Str::finish($url, '/');
            }

            $url = $url.'api/v1/helpdesk/check-url';
            //return $url;
            $result = $this->CallGetApi($url);
//            dd($result);
            return response()->json(compact('result'));
        } catch (\Exception $ex) {
            $error = $ex->getMessage();

            return $error;
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $ex) {
            return ['status' => 'fails', 'code' => $ex->getStatusCode()];
        }
    }

    /**
     * Success for currect url.
     *
     * @return string
     */
    public function urlResult()
    {
        try {
            $result = ['status' => 'success'];

            return $result;
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $ex) {
            return ['status' => 'fails', 'code' => $ex->getStatusCode()];
        }
    }

    /**
     * Call curl function for Get Method.
     *
     * @param type $url
     *
     * @return type int|string|json
     */
    public function callGetApi($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            //echo 'error:' . curl_error($curl);
        }

        return $response;
        curl_close($curl);
    }

    /**
     * Call curl function for POST Method.
     *
     * @param type $url
     * @param type $data
     *
     * @return type int|string|json
     */
    public function callPostApi($url, $data)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'error:'.curl_error($curl);
        }

        return $response;
        curl_close($curl);
    }
}
