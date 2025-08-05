<?php

namespace App\Component\Payments\Infrastructure\Http\Handler;

use App\Component\Payments\Application\Service\PaymentServiceInterface;
use App\Libraries\Base\Http\Handler;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/v1/payments/apply-promo-code',
    tags: ['Payments'],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['package_id', 'code'],
            properties: [
                new OA\Property(property: 'package_id', type: 'integer', description: 'Package ID'),
                new OA\Property(property: 'code', type: 'string', description: 'Promo code'),
            ],
            type: 'object'
        )
    ),
    responses: [
        new OA\Response(response: 200, description: 'Promo code applied successfully', content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'data', properties: [
                    new OA\Property(property: 'package_id', type: 'integer'),
                    new OA\Property(property: 'original_price', type: 'number'),
                    new OA\Property(property: 'final_price', type: 'number'),
                    new OA\Property(property: 'discount_amount', type: 'number'),
                    new OA\Property(property: 'discount_percentage', type: 'number'),
                    new OA\Property(property: 'promo_code', type: 'string'),
                    new OA\Property(property: 'is_valid', type: 'boolean'),
                    new OA\Property(property: 'error_message', type: 'string'),
                ], type: 'object'),
            ],
            type: 'object'
        )),
        new OA\Response(response: 400, description: 'Invalid request'),
        new OA\Response(response: 422, description: 'Validation error'),
    ]
)]
class ApplyPromoCodeHandler extends Handler
{
    protected PaymentServiceInterface $paymentService;

    public function __construct(PaymentServiceInterface $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'package_id' => 'required|integer|exists:packages,id',
            'code' => 'required|string|max:50',
        ]);

        $packageId = $request->input('package_id');
        $promoCode = $request->input('code');

        $calculation = $this->paymentService->calculatePromoCode($packageId, $promoCode);

        return response()->json([
            'status' => 'success',
            'message' => $calculation->isValid ? 'Promo code applied successfully' : 'Invalid promo code',
            'data' => [
                'package_id' => $calculation->packageId,
                'original_price' => $calculation->originalPrice,
                'final_price' => $calculation->finalPrice,
                'discount_amount' => $calculation->discountAmount,
                'discount_percentage' => $calculation->discountPercentage,
                'promo_code' => $calculation->promoCode,
                'is_valid' => $calculation->isValid,
                'error_message' => $calculation->errorMessage,
            ],
        ]);
    }
} 