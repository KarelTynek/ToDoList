@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-2">
        <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off">
            Nový projekt
        </button>
    </div>
    <div class="row mt-1">
        <div class="col-md-12">
                @if(count($projects) > 0)
                <ul class="list-group m-0">
                    @foreach ($projects as $project)
                    <li class="list-group-item">
                        <span><a href="#">{{ $project->title }}</a> - {{ str_limit($project->description, $limit = 100, $end = '...') }}</span>
                        <span class="float-right text-muted">{{ date('d.m.Y', strtotime($project->updated_at)) }}</span>
                    </li>
                    @endforeach
                </ul>
            @else
                <p>Nemáte žádný projekt.</p>
            @endif
        </div>
    </div>
</div>
@endsection
