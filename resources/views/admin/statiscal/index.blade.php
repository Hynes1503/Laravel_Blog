@extends('admin.layouts.app')

@section('header')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Statiscal') }}
                </h2>
                <div class="hidden sm:flex sm:items-center mx-auto">
                    <x-search-bar />
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <h1>Tính năng đang phát triển. Hê hê</h1>
        </div>
    </div>
@endsection
