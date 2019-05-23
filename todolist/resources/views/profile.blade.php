@extends('layouts.app')

@section('content')
<div class="container">
    @include('flash::message')
    <div class="row">
        <div class="col-3">
            <form method="GET" action="{{ route('profile') }}" id="sort">
                <div class="form-group">
                    <select name="sort" class="form-control">
                        <option disabled selected>Řadit podle</option>
                        <option value="title">Název</option>
                        <option value="date">Datum úpravy</option>
                        <option value="type">Typ</option>
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

            <div class="accordion" id="accordionExample">
                <div class="card shadow-sm">
                    <div class="card-header" id="headingPublic">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#public"
                                aria-expanded="true" aria-controls="public">
                                Veřejné projekty
                            </button>
                        </h2>
                    </div>

                    <div id="public" class="collapse show" aria-labelledby="headingPublic"
                        data-parent="#accordionExample">
                        <div class="card-body p-0 border-bottom-0 rounded">
                            <ul class="list-group m-0">
                                <li class="list-group-item border-left-0 border-right-0 rounded-0">Test</li>
                                <li class="list-group-item border-left-0 border-right-0 rounded-0">Test</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-header" id="headingPrivate">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#private"
                                aria-expanded="true" aria-controls="private">
                                Soukromé projekty
                            </button>
                        </h2>
                    </div>

                    <div id="private" class="collapse show" aria-labelledby="headingPrivate"
                        data-parent="#accordionExample">
                        <div class="card-body p-0 border-bottom-0 rounded">
                            <ul class="list-group m-0">
                                    <li class="list-group-item border-left-0 border-right-0 rounded-0">Test</li>
                                    <li class="list-group-item border-left-0 border-right-0 rounded-0">Test</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <ul class="list-group m-0">
                @foreach ($projects as $project)



                <li class="list-group-item">
                    <span>
                        @if ($project->type == 1) <i class="fas fa-lock"></i> @endif
                        <a href="{{ route('showproject', ['id' => $project->id_project]) }}">{{ $project->title }}</a>
                        @if ($project->description != null)
                        - {{ str_limit($project->description, $limit = 100, $end = '...') }}
                        @endif
                    </span>
                    <span class="float-right text-muted">{{ date('d.m.Y', strtotime($project->updated_at)) }}</span>
                </li>
                @endforeach
            </ul>
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