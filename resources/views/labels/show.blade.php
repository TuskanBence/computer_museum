@extends('layouts.app')
@section('title', 'view Label')

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
                        <a href="{{ route('labels.edit', $label) }}" role="button" class="btn btn-sm btn-primary">
                            <i class="far fa-edit"></i> Edit Label
                        </a>
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-confirm-modal">
                            <i class="far fa-trash-alt"></i> Delete Label
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 col-lg-12">
                <div class="row">
                    @forelse ($items as $item)
                        <div class="col-12 col-md-6 col-lg-6 mb-3 d-flex align-self-stretch">
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
                                    @foreach ($item->labels as $llabel)
                                        <a href="{{ route('labels.show', $llabel) }}" class="text-decoration-none">
                                            <span
                                                style="color:white;background-color:{{ $llabel->color }};">{{ $llabel->name }}</span>
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
                                Are you sure you want to delete label <span
                                    style="color:white;background-color:{{ $label->color }};">{{ $label->name }}</span>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger"
                                    onclick="document.getElementById('delete-label-form').submit();">
                                    Yes, delete this label
                                </button>
                                <form id="delete-label-form" action="{{ route('labels.destroy', $label) }}" method="POST"
                                    class="d-none">
                                    @method('DELETE')
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endsection
