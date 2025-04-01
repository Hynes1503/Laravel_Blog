@extends('footer.app')

@section('title', $page->title . ' - HynesBlog')

@section('content')
<div class="container mt-5">
    <h1 class="font-semibold text-3xl text-gray-800 leading-tight mb-3">{{ $page->title }}</h1>
    <p>{!! $page->content !!}</p>
</div>
@endsection
