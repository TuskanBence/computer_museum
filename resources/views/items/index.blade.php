@extends('layouts.app')
@section('title', 'Items')

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-md-8">
                <h1>All items in the museum</h1>
            </div>
            <div class="col-12 col-md-4">
                <div class="float-lg-end">
                    <a href="{{ route('items.create') }}" role="button" class="btn btn-sm btn-success mb-1"><i
                            class="fas fa-plus-circle"></i> Create Item</a>
                    <a href="{{ route('labels.create') }}" role="button" class="btn btn-sm btn-success mb-1"><i
                            class="fas fa-plus-circle"></i> Create Label</a>
                </div>
            </div>
        </div>
        @if (Session::has('label_deleted'))
            <div class="alert alert-success">
                A <span style="color:white;background-color:{{ session('color') }};">{{ session('name') }}</span> label
                has been deleted
            </div>
        @endif
        @if (Session::has('item_deleted'))
            <div class="alert alert-success">
                The {{ session('name') }} item has been deleted</div>
        @endif
        <div class="row mt-3">
            <div class="col-12 col-lg-9">
                <div class="row">
                    @forelse ($items as $item)
                        <div class="col-12 col-md-6 col-lg-6 mb-3 d-flex align-self-stretch ">
                            <div>
                                <h3 class="card-title mb-0">{{ $item->name }}</h3>
                                <p class="small mb-0">
                                    <span>
                                        <i class="far fa-calendar-alt"></i>
                                        <span>{{ $item->obtained }}</span>
                                    </span>
                                </p>
                                <img src="{{ asset(isset($item->image) ? 'storage/' . $item->image : 'images/default_post_cover.jpg') }}"
                                    class="card-img-top" alt="Post cover">
                                <div class="card-body">
                                    <p class="card-text mt-1">{{ Str::limit($item->description, 50) }}</p>
                                </div>
                                <div class="card-footer">
                                    @foreach ($item->labels as $label)
                                        <a href="{{ route('labels.show', $label) }}" class="text-decoration-none">
                                            <span
                                                style="color:white;background-color:{{ $label->color }};">{{ $label->name }}</span>
                                        </a>
                                    @endforeach
                                    <a href="{{ route('items.show', $item) }}" class="btn btn-primary">
                                        <span>View post</span> <i class="fas fa-angle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning" role="alert">
                                No posts found!
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center">
                    {{ $items->links('pagination::bootstrap-5') }}
                </div>

            </div>
            <div class="col-12 col-lg-3">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="card bg-light">
                            <div class="card-header">
                                Labels
                            </div>
                            <div class="card-body">
                                {{-- TODO: Read categories from DB --}}
                                @foreach ($labels as $label)
                                    <a href="{{ route('labels.show', $label) }}" class="text-decoration-none">
                                        <span
                                            style="color:white;background-color:{{ $label->color }};">{{ $label->name }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
