@extends('layouts.app')
@section('title', 'Label')

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            <div class="row justify-content-between">
                <div class="col-12 col-md-8">
                    <h1> <span style="color:white;background-color:{{ $label->color }};">{{ $label->name }}</span></h1>
                    <a href="{{ route('items.index') }}"><i class="fas fa-long-arrow-alt-left"></i> Back to the homepage</a>
                </div>
                <div class="col-12 col-md-4">
                    <div class="float-lg-end">
                        {{-- TODO: Links, policy --}}

                        <a href="{{ route('labels.edit', $label) }}" role="button" class="btn btn-sm btn-primary">
                            <i class="far fa-edit"></i> Edit category
                        </a>

                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-confirm-modal">
                            <i class="far fa-trash-alt"></i> Delete category
                        </button>

                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-lg-12">
                <div class="row">
                    {{-- TODO: Read posts from DB --}}

                    @forelse ($items as $item)
                        <div class="col-12 col-md-6 col-lg-6 mb-3 d-flex align-self-stretch">
                            <div class="card w-100">
                                <img src="{{ asset(isset($item->image) ? 'storage/' . $item->image : 'images/default_post_cover.jpg') }}"
                                    class="card-img-top" alt="Post cover">
                                <div class="card-body">
                                    {{-- TODO: Title --}}
                                    <h5 class="card-title mb-0">{{ $item->name }}</h5>
                                    <p class="small mb-0">
                                        <span>
                                            <i class="far fa-calendar-alt"></i>
                                            {{-- TODO: Date --}}
                                            <span>{{ $item->obtained }}</span>
                                        </span>
                                    </p>
                                    @foreach ($item->labels as $label)
                                        <a href="{{ route('labels.show', $label) }}" class="text-decoration-none">
                                            <span
                                                style="color:white;background-color:{{ $label->color }};">{{ $label->name }}</span>
                                        </a>
                                    @endforeach
                                    {{-- TODO: Short desc --}}

                                    <p class="card-text mt-1">{{ Str::limit($item->description, 50) }}</p>
                                </div>
                                <div class="card-footer">
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

                <!-- Modal -->
                <div class="modal fade" id="delete-confirm-modal" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Confirm delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{-- TODO: name --}}
                                Are you sure you want to delete category <strong>N/A</strong>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger"
                                    onclick="document.getElementById('delete-category-form').submit();">
                                    Yes, delete this category
                                </button>

                                {{-- TODO: Route, directives --}}
                                <form id="delete-category-form" action="#" method="POST" class="d-none">

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endsection
