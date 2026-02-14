<?php

namespace App\Restify;

use App\Models\Order;
use App\Services\OrderService;
use Binaryk\LaravelRestify\Fields\Field;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class OrderRepository extends Repository
{
    public static string $model = Order::class;

    public static array $search = ['id', 'client.name'];

    public static array $match = ['created_at'];

    public static array $sort = ['created_at'];

    public function fields(RestifyRequest $request): array
    {
        return [
            Field::make('id')->readonly(),
            Field::make('client_id')->rules('required', 'exists:clients,id'),
            Field::make('user_id')->readonly(),
            Field::make('total_amount')->readonly(),
            Field::make('status')->readonly(),

            Field::make('items')->rules('required', 'array'),

            Field::make('created_at')->readonly(),
        ];
    }

    public function store(RestifyRequest $request)
    {
        $orderService = app(OrderService::class);

        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = $orderService->createOrder(
            ['client_id' => $data['client_id']],
            $data['items'],
            $request->user()
        );

        return response()->json([
            'data' => $order,
        ], 201);
    }
}
