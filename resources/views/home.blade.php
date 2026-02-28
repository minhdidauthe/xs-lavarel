@extends('layouts.app')

@section('title', $page->meta_title ?: 'SOICAU7777.CLICK - Soi Cầu Xổ Số 3 Miền - Kết Quả Xổ Số Hôm Nay')

@if($page->meta_description)
@section('meta_description', $page->meta_description)
@endif

@section('content')
    {!! $renderedContent !!}
@endsection
