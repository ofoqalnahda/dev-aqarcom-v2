<?php

namespace App\Component\Ad\Infrastructure\Http\Handler;


use App\Component\Ad\Application\Mapper\AdMapperInterface;
use App\Component\Ad\Application\Mapper\EstateTypeMapperInterface;
use App\Component\Ad\Application\Mapper\PropertyUtilityMapperInterface;
use App\Component\Ad\Application\Mapper\AdTypeMapperInterface;
use App\Component\Ad\Application\Mapper\UsageTypeMapperInterface;
use App\Component\Ad\Application\Service\AdServiceInterface;
use App\Component\Ad\Application\Service\EstateTypeServiceInterface;
use App\Component\Ad\Application\Service\AdTypeServiceInterface;
use App\Component\Ad\Application\Service\PropertyUtilityServiceInterface;
use App\Component\Ad\Application\Service\UsageTypeServiceInterface;
use App\Component\Ad\Domain\Enum\MainType;
use App\Component\Settings\Application\Mapper\PackageMapperInterface;
use App\Component\Settings\Application\Service\PackageServiceInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/ads/get-data-filter',
    operationId: "GetDataFilter",
    summary: "Get data filter",
    tags: ['Filter'],
    responses: [
        new OA\Response(response: 200, description: 'Packages retrieved successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', properties: [

                    new OA\Property(property: 'price', properties: [
                        new OA\Property(property: 'max', type: 'integer'),
                        new OA\Property(property: 'min', type: 'integer'),
                    ]),
                    new OA\Property(property: 'area', properties: [
                        new OA\Property(property: 'max', type: 'float'),
                        new OA\Property(property: 'min', type: 'float'),
                    ]),

                    new OA\Property(property: 'ad_type', type: 'array', items: new OA\Items(ref: '#/components/schemas/AdTypeViewModel')),
                    new OA\Property(property: 'estate_type', type: 'array', items: new OA\Items(ref: '#/components/schemas/EstateTypeViewModel')),
                    new OA\Property(property: 'usage_type', type: 'array', items: new OA\Items(ref: '#/components/schemas/UsageTypeViewModel')),
                    new OA\Property(property: 'property_utility', type: 'array', items: new OA\Items(ref: '#/components/schemas/PropertyUtilityViewModel')),

                ], type: 'object'),
            ],
            type: 'object'
        )),
    ]
)]
class GetDataFilterHandler extends Handler
{
    protected AdServiceInterface $adService;
    protected AdTypeServiceInterface $adTypeService;
    protected AdTypeMapperInterface $adTypeMapper;

    protected EstateTypeServiceInterface $estateTypeService;
    protected EstateTypeMapperInterface $estateTypeMapper;

    protected UsageTypeServiceInterface $usageTypeService;
    protected UsageTypeMapperInterface $usageTypeMapper;

    protected PropertyUtilityServiceInterface $propertyUtilityService;
    protected PropertyUtilityMapperInterface $propertyUtilityMapper;



    public function __construct(
        AdServiceInterface $adService,
        AdTypeServiceInterface $adTypeService,
        EstateTypeServiceInterface $estateTypeService,
        UsageTypeServiceInterface $usageTypeService,
        PropertyUtilityServiceInterface $propertyUtilityService,
        AdTypeMapperInterface $adTypeMapper,
        EstateTypeMapperInterface $estateTypeMapper,
        UsageTypeMapperInterface $usageTypeMapper,
        PropertyUtilityMapperInterface $propertyUtilityMapper

    ) {
        $this->adService = $adService;
        $this->adTypeService = $adTypeService;
        $this->estateTypeService = $estateTypeService;
        $this->usageTypeService = $usageTypeService;
        $this->propertyUtilityService = $propertyUtilityService;

        $this->adTypeMapper = $adTypeMapper;
        $this->estateTypeMapper = $estateTypeMapper;
        $this->usageTypeMapper = $usageTypeMapper;
        $this->propertyUtilityMapper = $propertyUtilityMapper;

    }

    public function __invoke(Request $request): JsonResponse
    {
        // Get all packages grouped by type
        $date = $this->adService->getDataForFilter();

        $ad_type_data = $this->adTypeService->getByType('sell');
        $date['ad_type']=$this->adTypeMapper->toViewModelCollection($ad_type_data);



        $estate_type_data = $this->estateTypeService->index();
        $date['estate_type']=$this->estateTypeMapper->toViewModelCollection($estate_type_data);

        $usage_type_data = $this->usageTypeService->index();
        $date['usage_type']=$this->usageTypeMapper->toViewModelCollection($usage_type_data);


        $property_utility_data = $this->propertyUtilityService->index();
        $date['property_utility']=$this->propertyUtilityMapper->toViewModelCollection($property_utility_data);

        return response()->json([
            'status' => 'success',
            'message' => '',
            'data' => $date,
        ]);
    }
}
