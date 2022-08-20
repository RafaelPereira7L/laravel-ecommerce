<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
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
    public function update(Product $product, Request $request) {
        $input = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer',
            'cover' => 'file|nullable',
            'description' => 'nullable|string',
        ]);
        if(!empty($input['cover']) && $input['cover']->isValid()) {
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
    public function store(Request $request) {
        $input = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'stock' => 'nullable|integer',
            'cover' => 'file|nullable',
            'description' => 'nullable|string',
        ]);
        $input['slug'] = Str::slug($input['name']);

        if(!empty($input['cover']) && $input['cover']->isValid()) {
            $file = $input['cover'];

            $path = $file->store('public/products');
            $input['cover'] = $path;
        };

        Product::create($input);

        return redirect()->route('admin.products.index');
    }
}
