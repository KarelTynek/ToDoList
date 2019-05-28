@extends('layouts.app')

@section('content')
<div class="container mt-3">
    @include('flash::message')
    <div class="row">
        <div class="col-3">
            <form method="GET" action="{{ route('profile') }}" id="sort">
                <div class="form-group">
                    <select name="sort" class="form-control">
                        <option disabled selected>Řadit podle</option>
                        <option value="title">Název</option>
                        <option value="date">Datum úpravy</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="col">
            <a href="{{ route('createproject') }}" type="button" class="btn btn-primary">
                Nový projekt
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if(count($projects) > 0)
            <div class="accordion" id="accordion">
                <div class="card border-0">
                    <div class="card">
                        <div class="card-header" id="private">
                            <h2 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseprivate" aria-expanded="false"
                                    aria-controls="collapseprivate">
                                    <span
                                        class="badge badge-pill badge-secondary pl-2 pr-2">{{ $private->count }}</span>
                                    Soukromé projekty
                                </button>
                            </h2>
                        </div>
                        <div id="collapseprivate" class="collapse" aria-labelledby="private" data-parent="#accordion">
                            <div class="card-body p-0">
                                <ul class="list-group m-0 list-group-flush">
                                    @foreach ($projects as $project)
                                    @if ($project->type == 1)
                                    <li class="list-group-item">
                                        @if ($project->owner == Auth::id())
                                        <i class="fas fa-edit"></i>
                                        @endif
                                        <div class="row">
                                            <div class="col-10"><span>
                                                    <a class="card-link"
                                                        href="{{ route('showproject', ['id' => $project->id_project]) }}">{{ $project->title }}</a>
                                                    @if ($project->description != null)
                                                    - {{ str_limit($project->description, $limit = 100, $end = '...') }}
                                                    @endif
                                                </span></div>
                                            <div class="col-2"> <span
                                                    class="float-right text-muted">{{ date('d.m.Y', strtotime($project->updated_at)) }}</span>
                                            </div>
                                        </div>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="public">
                            <h2 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapsepublic" aria-expanded="false" aria-controls="collapsepublic">
                                    <span class="badge badge-pill badge-secondary pl-2 pr-2">{{ $public->count }}</span>
                                    Veřejné projekty
                                </button>
                            </h2>
                        </div>
                        <div id="collapsepublic" class="collapse" aria-labelledby="public" data-parent="#accordion">
                            <div class="card-body p-0">
                                <ul class="list-group m-0 list-group-flush">
                                    @foreach ($projects as $project)
                                    @if ($project->type == 0)
                                    <li class="list-group-item">
                                        @if ($project->owner == Auth::id())
                                        <a href="{{ route('editproject', ['id' => $project->id_project]) }}" class="text-dark"><i class="fas fa-edit"></i></a>
                                        @endif
                                        <span>
                                            <a
                                                href="{{ route('showproject', ['id' => $project->id_project]) }}">{{ $project->title }}</a>
                                            @if ($project->description != null)
                                            - {{ str_limit($project->description, $limit = 100, $end = '...') }}
                                            @endif
                                        </span>
                                        <span
                                            class="float-right text-muted">{{ date('d.m.Y', strtotime($project->updated_at)) }}</span>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            {{ $projects->links() }}
            @else
            <p>Nemáte žádný projekt.</p>
            @endif
        </div>
    </div>
</div>
@endsection



@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script>
    $('select[name=sort]').change(function() {
            $('#sort').submit();
            $(this).prop('disabled', 'true');
       });
</script>
@endpush