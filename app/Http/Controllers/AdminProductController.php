<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{

    public function index() {
        $products = Product::all();

        return view('admin.products', compact('products'));
    }

    // Mostrar página para editar formulário
    public function edit(Product $product) {
        return view('admin.product_edit', [
            'product' => $product
        ]);
    }

    // Recebe requisição para dar update no produto -> PUT METHOD
    public function update(Product $product, ProductStoreRequest $request) {
        $input = $request->validated();
        if(!empty($input['cover']) && $input['cover']->isValid()) {
            Storage::delete($product->cover ?? '');
            $file = $input['cover'];
            $path = $file->store('public/products');
            $input['cover'] = $path;
        };

        $product->fill($input);
        $product->save();
        return redirect()->route('admin.products.index');
    }

    // Mostrar página para criar produto
    public function create() {
        return view('admin.product_create');
    }

    // Recebe requisição para criar produto -> POST METHOD
    public function store(ProductStoreRequest $request) {
        $input = $request->validated();
        $input['slug'] = Str::slug($input['name']);

        if(!empty($input['cover']) && $input['cover']->isValid()) {
            $file = $input['cover'];

            $path = $file->store('public/products');
            $input['cover'] = $path;
        };

        Product::create($input);

        return redirect()->route('admin.products.index');
    }

    public function destroy(Product $product) {
        $product->delete();
        Storage::delete($product->cover ?? '');
        return redirect()->route('admin.products.index');
    }

    public function destroyImage(Product $product) {
        Storage::delete($product->cover ?? '');
        $product->cover = null;
        $product->save();
        return redirect()->back();
    }
}
