<?php

namespace App\Component\Ad\Infrastructure\Repository;

use App\Component\Ad\Application\Repository\AdRepository;
use App\Component\Ad\Data\Entity\Ad\Ad;
use App\Component\Ad\Domain\Enum\MainType;
use App\Component\Ad\Infrastructure\Http\Request\CheckAdLicenseRequest;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AdRepositoryEloquent implements AdRepository
{


    public function create(MainType $mainType, $request, $user): mixed
    {
        $property_utilities=[];
        switch ($mainType) {
            case 'sell':
                $cacheKey = 'ad_platform_view_' . $request->license_number;
                $ad_platform=null;
                if (Cache::has($cacheKey)) {
                   $ad_platform=Cache::get($cacheKey);
                }

                $property_utilities=$ad_platform->property_utilities;
                $slug=self::CreateSlug(Str::slug($ad_platform->ad_type->title.'-'.$ad_platform->address));
                $data=[
                    'slug' => $slug,
                    'main_type' => $mainType,
                    'license_number'=>$request->license_number,
                    'user_id'=>$user->id,
                    'ad_type_id'=>$ad_platform->ad_type->id,
                    'region_id'=>$ad_platform->region->id,
                    'city_id'=>$ad_platform->city->id,
                    'neighborhood_id'=>$ad_platform->neighborhood->id,
                    'estate_type_id'=>$ad_platform->estate_type->id,
                    'usage_type_id'=>$ad_platform->usage_type->id,
                    'status'=>true,
                    'is_special'=>$request->is_special,
                    'is_story'=>$request->is_story,
                    'address'=>$ad_platform->address,
                    'lng'=>$ad_platform->lng,
                    'lat'=>$ad_platform->lat,
                    'price'=>$ad_platform->price,
                    'property_price'=>$ad_platform->property_price,
                    'area'=>$ad_platform->area,
                    'description'=>$request->description,
                    "is_constrained"=>$ad_platform->is_constrained,
                    "is_pawned"=>$ad_platform->is_pawned,
                    "is_halted"=>$ad_platform->is_halted,
                    "is_testament"=>$ad_platform->is_testament,
                    'street_width'=>$ad_platform->street_width,
                    'number_of_rooms'=>$ad_platform->number_of_rooms,
                    'deed_number'=>$ad_platform->deed_number,
                    'property_face'=>$ad_platform->property_face,
                    'plan_number'=>$ad_platform->plan_number,
                    'land_number'=>$ad_platform->land_number,
                    'ad_license_url'=>$ad_platform->ad_license_url,
                    'ad_source'=>$ad_platform->ad_source,
                    'title_deed_type_name'=>$ad_platform->title_deed_type_name,
                    'location_description'=>$ad_platform->location_description,
                    'property_age'=>$ad_platform->property_age,
                    'rer_constraints'=>$ad_platform->rerConstraints,
                    'creation_date'=>$ad_platform->creation_date,
                    'end_date'=>$ad_platform->end_date
                    ];
                break;
            case 'buy':
                $data=[
                    'main_type' => $mainType,


                ];
                break;
        }
        $ad= Ad::create($data);
        $ad->propertyUtilities()->sync($property_utilities ?? []);
        if ($request->has('main_image')) {
            $ad->addMediaFromRequest('main_image')->toMediaCollection('main_image');
        }
        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $ad->addMedia($image)->toMediaCollection('images');
            }
        }
        if ($request->has('video')) {
            $ad->addMediaFromRequest('video')->toMediaCollection('video');
        }
        return $ad;
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
    private static function CreateSlug($slug,$number=0)
    {
        if(Ad::where('slug',$slug)->exit()){
            return  self::CreateSlug($slug,$number+1);
        }
        return $number != 0 ? $slug.'-'.$number:$slug;
    }
}
