@extends('layouts.full')
@section('content')
<div class="container-fluid">
   <div class="row justify-content-center">
      <div class="col-12">
         <div class="header mt-md-5">
            <div class="header-body">
               <div class="row align-items-center">
                  <div class="col">
                     <h6 class="header-pretitle">
                        {{utrans("tickets.createNewTicket")}}
                     </h6>
                     <h1 class="header-title">
                        {{utrans("headers.tickets")}}
                     </h1>
                  </div>
               </div>
            </div>
         </div>
         <div class="card">
            <div class="card-body">
               {!! Form::open(['action' => '\App\Http\Controllers\TicketController@store', 'id' => 'ticketForm']) !!}             
               <!-- Department Selection -->
               <div class="form-group">
                  <label for="department">{{ utrans("tickets.department") }}</label>
                  {!! Form::select('department', [
                     '1' => 'Sales Team',
                     '2' => 'Support Team',
                     '3' => 'Billing Team',
                     '8' => 'Cancellation Team',
                  ], null, ['class' => 'form-control', 'id' => 'department', 'required' => 'required', 'placeholder' => ""]) !!}
               </div>

               <!-- Subject Input -->
               <div class="form-group">
                  <label for="subject">{{utrans("tickets.subject")}}</label>
                  <div class="input-group input-group-merge">
                     {!! Form::text("subject",null,['class' => 'form-control form-control-prepended', 'id' => 'subject', 'placeholder' => utrans("tickets.subjectLong")]) !!}
                     <div class="input-group-prepend">
                        <div class="input-group-text">
                           <span class="fe fe-message-square"></span>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Description Input -->
               <div class="form-group">
                  <label for="description">{{utrans("tickets.description")}}</label>
                  {!! Form::textarea("description",null,['class' => 'form-control', 'id' => 'description', 'placeholder' => utrans("tickets.descriptionLong")]) !!}
               </div>
               <button type="submit" class="btn btn-outline-primary">{{utrans("actions.createTicket")}}</button>
               {!! Form::close() !!}
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('additionalJS')
<script type="text/javascript" src="/assets/libs/js-validation/jsvalidation.min.js"></script>
{!! JsValidator::formRequest('App\Http\Requests\TicketRequest','#ticketForm') !!}
@endsection