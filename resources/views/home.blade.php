@extends('layouts.app')
@section('content')

{{-- <section class="section">
    <div class="columns">
      @for($i = 1; $i <= 3; $i++)
        <div class="column card mg-1">
          <h4 class="has-text-centered">The title</h4>
          <div class="auto-scroll vh-one-third">
             @include('components.table')
          </div>
        </div>
       @endfor
    </div>
</section> --}}

<section class="section card mg-1 is-fullheight">
  <div class="columns">
    <div class="column ">
      <h4 class="has-text-centered">The title</h4>
          <div class="auto-scroll is-fullheight">
             @include('components.table')
          </div>
    </div>
    <div class="column">
      <h4 class="has-text-centered">The title</h4>
          <div class="auto-scroll is-fullheight">
             <canvas class="this-graph" id="this-graph"  width="100%" ></canvas>
          </div>
    </div>
  </div>
</section>

@endsection
