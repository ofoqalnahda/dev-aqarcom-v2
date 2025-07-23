<?php

namespace App\Component\Ad\Infrastructure\Repository;

use App\Component\Ad\Application\Repository\AdRepository;
use App\Component\Ad\Data\Entity\Ad\Ad;
use App\Component\Ad\Infrastructure\Http\Request\CheckAdLicenseRequest;
use Illuminate\Contracts\Auth\Authenticatable;

class AdRepositoryEloquent implements AdRepository
{
    public function create(array $data)
    {
        return Ad::create($data);
    }

    public function update($id, array $data)
    {
        $user = Ad::find($id);
        if ($user) {
            $user->update($data);
        }
        return $user;
    }

    public function delete($id): bool
    {
        $user = Ad::find($id);
        if ($user) {
            return $user->delete();
        }
        return false;
    }

    public function findByLicenseNumber(string $license_number): mixed
    {
        return '';
    }

    public function CheckIsExitAd(int|string $license_number): mixed
    {
        $ad = Ad::with('user:id,name')->where('license_number',$license_number)->first();
        if ($ad) {
            return $ad;
        }
        return null;
    }

    public function CheckAdLicense(CheckAdLicenseRequest $request, ?Authenticatable $user): array
    {
        $adLicenseNumber=$request->input('license_number');
        $data= $this->GetApiPlatform(1,$user->identity_number,$adLicenseNumber);
        if (!$data['Status']){
            $data= $this->GetApiPlatform(2,$user->commercial_number,$adLicenseNumber);
        }
        return $data;

    }
    static function GetApiPlatform(int $idType ,int|string $advertiserId,int|string $adLicenseNumber )
    {
        $data=[];
        $ClientId = env('X_IBM_CLIENT_ID');
        $ClientSecret = env('X_IBM_CLIENT_SECRET');
        $URL = env('X_IBM_CLIENT_URL');
        $url = $URL."/v2/brokerage/AdvertisementValidator?adLicenseNumber={$adLicenseNumber}&advertiserId={$advertiserId}&idType={$idType}";
        $headers = [
            "Accept: application/json",
            "Content-Type: application/json",
            "RefId: 1",
            "X-IBM-Client-Id: {$ClientId}",
            "X-IBM-Client-Secret: {$ClientSecret}"
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPGET, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
        $response_json = json_decode($response, true);
        $data['Status']=false;
        if(isset($response_json['Header'])){
            if( $response_json['Header']['Status']['Code']== 200){
                $data['Status']=$response_json['Body']['result']['isValid'];
                $data['message']=$response_json['Header']['Status']['Description'] != "OK"?: $response_json['Body']['result']['message'] ;
                $data['Body']=$response_json['Body'] ;
            }
        }
        return $data;
    }
}
