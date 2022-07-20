<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Str;

class C3AppController extends Controller
{
    private $accessToken;
    private $expires;

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

        if ( ( $this->expires && $this->expires->isAfter( now() ) ) || $this->getAccessToken() ) {
            return view('c3apps', ['apps' => $this->getAppsArray()]);
        }
       
        return view('c3apps', ['apps' => []]);
    }

    private function getAppsArray() {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->accessToken,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get('https://c3p-dev.staging.digital.nod.nuance.com/v1/apps/asos?tenantId=portalClientId&env=dev');

        if ( $response->successful() ) {
            return $response->json();
        }

        return [];
    }

    private function getAccessToken()
    {
        $response = Http::accept('application/json')
        ->withHeaders([
            'Authorization' => 'Basic ' . base64_encode('portalUiClientId:portalUiClientSecret'),
        ])
        ->asForm()->post('https://auth-us1.digital.nuance.com/oauth-server/oauth/token', [
            'grant_type' => 'password',
            'username' => 'dtaylor',
            'password' => 'Biscuits23!@',
        ]);

        if ($response->successful() && $response->json()['access_token'] ) {
            $this->accessToken = $response->json()['access_token'];
            $this->expires = now()->addSeconds( $response->json()['expires_in'] );
            return true;
        }

        return false;
    }

    public function getAppStatus($app) {
        // URL=${C3PHOST}/v1/apps/${ORGNAME}/${APPNAME}/${ORGNAME}-${APPNAME}-${VERSION}/status${URLPARAMS}
        // echo GET $URL
        
        // CURLOUT=`curl --request GET -H "Authorization: Bearer $ACCESS" $URL`
        if ( ( $this->expires && $this->expires->isAfter( now() ) ) || $this->getAccessToken() ) {
            $appparts = explode('-', $app);
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$this->accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->get('https://c3p-dev.staging.digital.nod.nuance.com/v1/apps/'.$appparts[0].'/'.$appparts[1].'/'.$app.'/status?tenantId=portalClientId&env=dev');

            // dump( $response->json() );
            $array = $response->json();
            $array['url'] = 'https://c3p-dev.staging.digital.nod.nuance.com/v1/apps/'.$appparts[0].'/'.$appparts[1].'/'.$app.'/status?tenantId=portalClientId&env=dev';
            return json_encode( $array );
            if ( $response->successful() ) {
                if( $response->json()['deploymentStatus'] == 'SUCCESS') {
                    return 'deployed';
                } elseif ( $response->json()['imageBuildStatus'] == 'SUCCESS' ) {
                    return 'deploy failed';
                } else {
                    return 'failed';
                }
            }
        }

        return 'fail';
    }
}
