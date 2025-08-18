<?php

namespace App\Component\Ad\Infrastructure\Repository;

use App\Component\Ad\Application\Repository\AdRepository;
use App\Component\Ad\Data\Entity\Ad\Ad;
use App\Component\Ad\Data\Entity\Ad\AdType;
use App\Component\Ad\Data\Entity\Ad\EstateType;
use App\Component\Ad\Data\Entity\Geography\City;
use App\Component\Ad\Data\Entity\Geography\Neighborhood;
use App\Component\Ad\Data\Entity\Geography\Region;
use App\Component\Ad\Data\Entity\Geography\RegionMap;
use App\Component\Ad\Domain\Enum\MainType;
use App\Component\Ad\Infrastructure\Http\Request\CheckAdLicenseRequest;
use App\Component\Auth\Data\Entity\User\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Carbon\Carbon;
class AdRepositoryEloquent implements AdRepository
{


    public function create(MainType $mainType, $request, $user): mixed
    {
        $property_utilities=[];
        $data=[];
        switch ($mainType->value) {
            case 'sell':
                $cacheKey = 'ad_platform_view_' . $request['license_number'];
                $ad_platform=null;
                if (Cache::has($cacheKey)) {
                    $ad_platform=Cache::get($cacheKey);
                }
                $property_utilities=collect($ad_platform['property_utilities'])->pluck('id')->toArray();

                $slug=self::CreateSlug(Str::slug($ad_platform['ad_type']['name'].'-'.$ad_platform['estate_type']['name'].'-'.$ad_platform['address']));
                $data = [
                    'slug' => $slug,
                    'main_type' => $mainType,
                    'license_number' => $request['license_number'],
                    'user_id' => $user->id,
                    'ad_type_id' => $ad_platform['ad_type']['id'],
                    'region_id' => $ad_platform['region']['id'],
                    'city_id' => $ad_platform['city']['id'],
                    'neighborhood_id' => $ad_platform['neighborhood']['id'],
                    'estate_type_id' => $ad_platform['estate_type']['id'],
                    'usage_type_id' => $ad_platform['usage_type']['id'],
                    'status' => true,
                    'is_special' => $request['is_special'],
                    'is_story' => $request['is_story'],
                    'address' => $ad_platform['address'],
                    'lng' => $ad_platform['lng'],
                    'lat' => $ad_platform['lat'],
                    'price' => $ad_platform['price'],
                    'property_price' => $ad_platform['property_price'],
                    'area' => $ad_platform['area'],
                    'description' => $request['description'],
                    "is_constrained" => $ad_platform['is_constrained'],
                    "is_pawned" => $ad_platform['is_pawned'],
                    "is_halted" => $ad_platform['is_halted'],
                    "is_testament" => $ad_platform['is_testment'],
                    'street_width' => $ad_platform['street_width'],
                    'number_of_rooms' => $ad_platform['number_of_rooms'],
                    'deed_number' => $ad_platform['deed_number'],
                    'property_face' => $ad_platform['property_face'],
                    'plan_number' => $ad_platform['plan_number'],
                    'land_number' => $ad_platform['land_number'],
                    'ad_license_url' => $ad_platform['ad_license_url'],
                    'ad_source' => $ad_platform['ad_source'],
                    'title_deed_type_name' => $ad_platform['title_deed_type_name'],
                    'location_description' => $ad_platform['location_description'],
                    'property_age' => $ad_platform['property_age'],
                    'rer_constraints' => $ad_platform['rerConstraints'],
                    'creation_date' => Carbon::createFromFormat('d/m/Y', $ad_platform['creation_date']),
                    'end_date' => Carbon::createFromFormat('d/m/Y', $ad_platform['end_date'])
                ];

                break;
            case 'buy':

                $ad_type=AdType::where('id',$request['ad_type_id'])->first();
                $estate_type=EstateType::where('id',$request['estate_type_id'])->first();
                $city=City::where('id',$request['city_id'])->first();
                $neighborhood=Neighborhood::where('id',$request['neighborhood_id'])->first();

                $slug=self::CreateSlug(Str::slug('or-'.$ad_type->title.'-'.$estate_type->title.'-'.$city->name.'-'.$neighborhood->name));
                $data = [
                    'slug' => $slug,
                    'main_type' => $mainType,
                    'user_id' => $user->id,
                    'status' => true,
                    "ad_type_id"=> $request['ad_type_id'],
                    "estate_type_id"=> $request['estate_type_id'],
                    "region_id"=> $request['region_id'],
                    "city_id"=> $request['city_id'],
                    "neighborhood_id"=> $request['neighborhood_id'],
                    "price"=> $request['price']?? null,
                    "description"=> $request['description']
                    ];
                break;
        }
        $ad= Ad::create($data);
        $ad->propertyUtilities()->sync($property_utilities ?? []);
        return $ad;
    }

    public function update($id, array $data)
    {
        $ad = Ad::find($id);
        if ($ad) {
            $ad->update($data);
        }
        return $ad;
    }
    public function find($id)
    {
        return Ad::find($id);
    }
    public function delete($id): bool
    {
        $ad = Ad::find($id);
        if ($ad) {
            return $ad->delete();
        }
        return false;
    }

    public function findByLicenseNumber(string $license_number): mixed
    {
        return '';
    }

    public function CheckIsExitAd(int|string $license_number): mixed
    {
        $cacheKey = 'ad_check_' . $license_number;

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($license_number) {
            return Ad::query()
                ->join('users', 'users.id', '=', 'ads.user_id')
                ->where('ads.license_number', $license_number)
                ->select([
                    'ads.id',
                    'ads.license_number',
                    'ads.slug',
                    'users.id as user_id',
                    'users.name as user_name'
                ])
                ->first()?->toArray();
        });
    }

    public function CheckAdLicense(CheckAdLicenseRequest $request, ?Authenticatable $ad): array
    {
        $adLicenseNumber=$request->input('license_number');
        $data= $this->GetApiPlatform(1,$ad->identity_number,$adLicenseNumber);
        if (!$data['Status']){
            $data= $this->GetApiPlatform(2,$ad->commercial_number,$adLicenseNumber);
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
        $new_slug =$number != 0 ? $slug.'-'.$number:$slug;
        if(Ad::where('slug',$new_slug)->exists()){
            return  self::CreateSlug($slug,$number+1);
        }
        return $new_slug;
    }

    public function filter(MainType $mainType, array $filters,$withDist=false)
    {
        $validKeys = [
            'user_id',
            'is_special',
            'ad_type_id',
            'estate_type_id',
            'city_id',
            'region_id',
            'neighborhood_id',
            'usage_type_id',
            'main_type',
            'status',
            'number_of_rooms',
            'price',
            'min_price',
            'max_price',
            'area',
            'min_area',
            'max_area',
            'search',
            'region_map_id',
            'property_utilities',
        ];

        $query = Ad::Active();
        if ($withDist){
            $is_sort=isset($filters['sort_by']) && $filters['sort_by'] ==='nearest';
            $query= $query->WithDistanceFrom(is_sort:$is_sort);
        }

        $query->where('main_type', $mainType->value);
        $filters = array_filter($filters, fn($v) => $v !== null && $v !== '');

        foreach ($filters as $key => $value) {
            if (!in_array($key, $validKeys)) {
                continue;
            }

            if ($key === 'search') {
                $query->where(function ($q) use ($value) {
                    if (is_numeric($value)) {
                        $q->where('id', (int)$value);
                    } else {
                        $q->where('description', 'like', '%' . $value . '%');
                        $estateTypeIds = EstateType::whereTranslation('title', 'like', '%' . $value . '%')->pluck('id');
                        $adTypeIds = AdType::whereTranslation('title', 'like', '%' . $value . '%')->pluck('id');
                        $q->orWhereIn('estate_type_id', $estateTypeIds);
                        $q->orWhereIn('ad_type_id', $adTypeIds);
                    }
                });
                continue;
            }

            if (is_string($value) && str_contains($value, ',')) {
                $values = explode(',', $value);
                if (count($values) === 2) {
                    $query->whereBetween($key, [$values[0], $values[1]]);
                }
                continue;
            }

            if ($key === 'region_map_id') {
                $state = RegionMap::find($value);
                if ($state) {
                    $cityIds = City::where('region_map_id', $state->id)->pluck('id');
                    if (!empty($cityIds)) {
                        $query->whereIn('city_id', $cityIds);
                    }
                }
                continue;
            }
            if ($key === 'property_utilities') {
                $utilityIds = is_string($value) ? explode(',', $value) : (array)$value;
                $query->whereHas('propertyUtilities', function ($q) use ($utilityIds) {
                    $q->whereIn('property_utilities.id', $utilityIds);
                });

                continue;
            }

            if (in_array($key, ['min_price', 'min_area'])) {
                $column = str_replace('min_', '', $key);
                $query->where($column, '>=', $value);
                continue;
            }

            if (in_array($key, ['max_price', 'max_area'])) {
                $column = str_replace('max_', '', $key);
                $query->where($column, '<=', $value);
                continue;
            }

            $query->where($key, $value);
        }
        if (isset($filters['sort_by'])) {
            switch ($filters['sort_by']) {
                case 'lowest_price':
                    $query->orderBy('price', 'asc');
                    break;
                case 'highest_price':
                    $query->orderBy('price', 'desc');
                    break;
                case 'largest_area':
                    $query->orderBy('area', 'desc');
                    break;
                case 'smallest_area':
                    $query->orderBy('area', 'asc');
                    break;
            }
        }
        return $query;
    }

    public function getDataForFilter(): array
    {
        $ads = Ad::Active()->where('main_type', MainType::SELL);

        $maxPrice = $ads->max('price');
        $minPrice =  $ads->min('price');

        $maxArea =  $ads->max('area');
        $minArea =  $ads->min('area');

        return [
            'price' => [
                'min' => (int)$minPrice,
                'max' => (int)$maxPrice,
            ],
            'area' => [
                'min' =>round($minArea, 2),
                'max' =>round($maxArea, 2),
            ],
        ];
    }
    public function getStores()
    {

        return User::select('id', 'name')
            ->whereHas('ads', function ($q) {
                $q->where('is_story', 1)
                    ->where('status', 1);
            })
            ->with(['ads' => function ($query) {
                $query->select('id', 'status','slug','created_at', 'is_story', 'user_id')
                ->where('is_story', 1)->where('status', 1);
            }]);

    }

    public function findBySlug($slug)
    {
        return Ad::where('slug',$slug)->first();
    }
}
