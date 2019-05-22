@extends('layouts.app')

@section('content')
<div class="container">
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
            <ul class="list-group m-0">
                @foreach ($projects as $project)
                <li class="list-group-item">
                    <span>
                        @if ($project->type == 1) <i class="fas fa-lock"></i> @endif
                        <a href="#">{{ $project->title }}</a>
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