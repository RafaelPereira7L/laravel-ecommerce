@extends('layouts.default')

@section('title', 'Produto')

@section('content')
<section class="text-gray-600 overflow-hidden">
    <div class="container px-5 py-24 mx-auto">
        <div class="lg:w-4/5 mx-auto flex flex-wrap">
            <img alt="ecommerce" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded"
            src="@if(Str::contains(Storage::url($product->cover), 'via.placeholder')){{ $product->cover }}@else{{ Storage::url($product->cover) }}@endif">
            <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">{{ $product->name }}</h1>
                <p class="leading-relaxed">{{ $product->description }}</p>
                <div class="my-3">
                    @if($product->stock > 0)
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">Em estoque
                    </span>
                    @else
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-red-100 text-orange-800">Indisponível
                    </span>
                    @endif
                </div>
                <div class="flex border-t-2 border-gray-100 mt-6 pt-6">
                    <span class="title-font font-medium text-2xl text-gray-900">R${{ $product->price }}</span>
                    <a class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded cursor-pointer">Comprar</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
