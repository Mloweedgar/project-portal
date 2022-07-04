@extends('layouts.back')

@section('styles')

@endsection

@section('content')
  @if (count($errors) > 0)
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif
  @if (!empty($flag))
      <div class="alert alert-danger">
          Message: {{$flag["message"]}}
      </div>
  @endif

    <div class="container-fluid">
        <h1 class="content-title">{{__("aboutppp.title")}}</h1>

        <div class="row content-row">

              <form action="about-ppp/edit" method="POST" class="col-md-12 form-inline">
                {{ csrf_field() }}

                  <div class="card">
                      <div class="header">
                          <h2>
                              {{__("aboutppp.title")}}
                          </h2>

                      </div>
                      <div class="body">
                          <div class="form-group">

                              <div class="form-line">
                                  <textarea rows="5" class="form-control no-resize" name="aboutppp" >{{isset($aboutppp) ? $aboutppp->value : "" }}</textarea>
                                  <button class="btn btn-large btn-primary waves-effect pull-right m-r-20 m-t-20" type="submit">{{__('general.save')}}</button>
                              </div>
                          </div>
                      </div>
                  </div>
            </form>
        </div>
    </div>
@endsection
