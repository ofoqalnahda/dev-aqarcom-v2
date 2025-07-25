<?php

namespace App\Component\Settings\Infrastructure\Http\Handler;

use App\Component\Settings\Application\Service\PackageServiceInterface;
use App\Component\Settings\Application\Mapper\PackageMapperInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/v1/settings/packages',
    tags: ['Settings'],
    parameters: [
        new OA\Parameter(
            name: 'type',
            description: 'Package type filter',
            in: 'query',
            required: false,
            schema: new OA\Schema(type: 'string', enum: ['individual', 'companies'])
        ),
    ],
    responses: [
        new OA\Response(response: 200, description: 'Packages retrieved successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', properties: [
                    new OA\Property(property: 'individual', type: 'array', items: new OA\Items(ref: '#/components/schemas/PackageViewModel')),
                    new OA\Property(property: 'companies', type: 'array', items: new OA\Items(ref: '#/components/schemas/PackageViewModel')),
                ], type: 'object'),
            ],
            type: 'object'
        )),
    ]
)]
class GetPackagesHandler extends Handler
{
    protected PackageServiceInterface $packageService;
    protected PackageMapperInterface $packageMapper;

    public function __construct(
        PackageServiceInterface $packageService,
        PackageMapperInterface $packageMapper
    ) {
        $this->packageService = $packageService;
        $this->packageMapper = $packageMapper;
    }

    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $type = $request->query('type');

        if ($type) {
            $packages = $this->packageService->getPackagesByType($type);
            $packageViewModels = $this->packageMapper->toViewModelCollection($packages);

            return response()->json([
                'status' => 'success',
                'message' => 'Packages retrieved successfully',
                'data' => array_map(fn($package) => $package->toArray(), $packageViewModels),
            ]);
        }

        // Get all packages grouped by type
        $individualPackages = $this->packageService->getPackagesByType('individual');
        $companyPackages = $this->packageService->getPackagesByType('companies');

        $individualViewModels = $this->packageMapper->toViewModelCollection($individualPackages);
        $companyViewModels = $this->packageMapper->toViewModelCollection($companyPackages);

        return response()->json([
            'status' => 'success',
            'message' => 'Packages retrieved successfully',
            'data' => [
                'individual' => array_map(fn($package) => $package->toArray(), $individualViewModels),
                'companies' => array_map(fn($package) => $package->toArray(), $companyViewModels),
            ],
        ]);
    }
} 