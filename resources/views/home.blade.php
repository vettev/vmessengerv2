@extends('layouts.master')
@include('layouts.header')

@section('content')
    <section id="user-panel" class="row">
        <div class="col-md-3">
            @include('layouts.contacts')
        </div>
        <div class="col-md-9">
            <section id="messaging" class="row">
                
            </section>
        </div>
    </section>
    <li id="message-template">
        <p class="date"></p>
        <p class="sender"></p>
        <p class="content"></p>
    </li>
    <div class="modal fade" tabindex="-1" role="dialog" id="modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content-dark">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                </div>
            </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
