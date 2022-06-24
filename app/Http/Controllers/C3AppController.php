<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class C3AppController extends Controller
{
    public function getAllApps()
    {
        // C3PHOST=https://c3p-dev.staging.digital.nod.nuance.com
        // ORGNAME=asos
        // APPNAME=va
        // URLPARAMS="?tenantId=portalClientId&env=dev"
        //URL=https://c3p-dev.staging.digital.nod.nuance.com/v1/apps/asos?tenantId=portalClientId&env=dev
        //CURLOUT=`curl --request GET -H "Authorization: Bearer $ACCESS" $URL`
        // URL=https://auth-us1.digital.nuance.com/oauth-server/oauth/token
        // CURLOUT=`curl -X POST -H 'Accept: application/json' -H 'Content-Type: application/x-www-form-urlencoded' -H "Authorization: Basic $CLIENTAUTH" --data-urlencode "username=${NDEPUSER}" --data-urlencode "password=${NDEPPASS}" --data-urlencode "grant_type=password" $URL`
        // NDEPUSER=dtaylor
        // NDEPPASS=Biscuits23!@
        $this->getAccessToken();
        return view('c3apps');
    }

    private function getAccessToken()
    {
        $response = Http::accept('application/json')
        ->withBasicAuth('portalClientId', 'portalClientSecret')
        ->asForm()->post('https://webhook.site/667f191a-e975-47e2-b419-5e1e55d78662', [
            'grant_type' => 'password',
            'username' => 'dtaylor',
            'password' => 'Biscuits23!@',
        ]);

        dd($response->json());
    }
}
