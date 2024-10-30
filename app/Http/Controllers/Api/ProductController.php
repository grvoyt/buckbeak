<?php

namespace App\Http\Controllers\Api;

use App\Events\ProductDeleted;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\DropdownCollection;
use App\Http\Resources\ProductLiteCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;
    public function __construct(ProductRepositoryInterface $productRepository,ProductService $productService)
    {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
    }

    public function index(Request $request): ProductLiteCollection
    {
        return new ProductLiteCollection(
            $this->productRepository->listByUser(
                user: auth()->user(),
                perPage: $request->query('perPage', 10),
                page: $request->query('page', 1),
            )
        );
    }

    public function store(ProductStoreRequest $request): ProductResource
    {
        $product = $this->productService
            ->createByUser(
                user: auth()->user(),
                data: $request->validated()
            );
        $product->load([
            'category','country','status'
        ]);
        return new ProductResource($product);
    }

    public function show(Product $product): ProductResource
    {
        $product->load([
            'category','country','status'
        ]);
        return new ProductResource($product);
    }

    public function update(ProductUpdateRequest $request,Product $product): ProductResource
    {
        $product = $this->productService
            ->update(
                product: $product,
                data: $request->validated()
            );
        $product->load([
            'category','country','status'
        ]);
        return new ProductResource($product);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product_id = $product->id;
        $product->delete();
        event(new ProductDeleted($product_id));
        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }

    public function dropdown(Request $request): DropdownCollection
    {
        return new DropdownCollection(
            $this->productRepository->dropdown(
                user: auth()->user(),
                perPage: $request->query('perPage', 10),
                page: $request->query('page', 1),
            )
        );
    }
}
