@extends('layouts.app')
@section('title', 'Items')

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-md-8">
                <h1>All posts</h1>
            </div>
            <div class="col-12 col-md-4">
                <div class="float-lg-end">
                    {{-- TODO: Links, policy --}}

                    <a href="{{ route('items.create') }}" role="button" class="btn btn-sm btn-success mb-1"><i
                            class="fas fa-plus-circle"></i> Create Item</a>
                    <a href="{{ route('labels.create') }}" role="button" class="btn btn-sm btn-success mb-1"><i
                            class="fas fa-plus-circle"></i> Create Label</a>


                </div>
            </div>
        </div>

        {{-- TODO: Session flashes --}}

        <div class="row mt-3">
            <div class="col-12 col-lg-9">
                <div class="row">
                    {{-- TODO: Read posts from DB --}}

                    @forelse ($items as $item)
                        <div class="col-12 col-md-6 col-lg-6 mb-3 d-flex align-self-stretch">
                            <div class="card w-100">
                                <img src="{{ asset( isset($item->image) ? 'storage/'.$item->image : 'images/default_post_cover.jpg') }}" class="card-img-top" alt="Post cover">
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

                <div class="d-flex justify-content-center">
                    {{-- TODO: Pagination --}}
                </div>

            </div>
            <div class="col-12 col-lg-3">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="card bg-light">
                            <div class="card-header">
                                Label
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

                    <div class="col-12 mb-3">
                        <div class="card bg-light">
                            <div class="card-header">
                                Statistics
                            </div>
                            <div class="card-body">
                                <div class="small">
                                    <ul class="fa-ul">
                                        {{-- TODO: Read stats from DB --}}
                                        <li><span class="fa-li"><i class="fas fa-user"></i></span>Users:
                                            {{ $users->count() }}</li>
                                        <li><span class="fa-li"><i
                                                    class="fas fa-layer-group"></i></span>Labels:{{ $labels->count() }}
                                        </li>
                                        <li><span class="fa-li"><i
                                                    class="fas fa-file-alt"></i></span>Items:{{ $items->count() }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
