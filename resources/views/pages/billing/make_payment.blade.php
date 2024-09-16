@extends('layouts.full')
@section('content')
<div class="container-fluid">
   <div class="row justify-content-center">
      <div class="col-12">
         <!-- Header -->
         <div class="header mt-md-5">
            <div class="header-body">
               <div class="row align-items-center">
                  <div class="col">
                     <!-- Pretitle -->
                     <h6 class="header-pretitle">
                        {{utrans("billing.makePayment")}}
                     </h6>
                     <!-- Title -->
                     <h1 class="header-title">
                        {{utrans("billing.billing")}}
                     </h1>
                  </div>
                  <div class="col-auto">
                  </div>
               </div>
               <!-- / .row -->
            </div>
         </div>
         {!! Form::open(['action' => '\App\Http\Controllers\BillingController@submitPayment','id' => 'paymentForm','class' => 'mb-4','autocomplete' => 'on']) !!}
         <div class="row mt-4">
            <div class="col-12 ">
               <!-- First name -->
               <div class="form-group">
                  <!-- Label -->
                  <label>
                     {{utrans("billing.paymentMethod")}}
                  </label>
                  <!-- Input -->
                  {!! Form::select("payment_method",$paymentMethods,'new_card',['id' => 'payment_method', 'class' => 'form-control']) !!}
               </div>
            </div>
            <div class="col-12 ">
               <!-- Last name -->
               <div class="form-group new_card">
                  <!-- Label -->
                  <label>
                     {{utrans("billing.nameOnCard")}}
                  </label>
                  <!-- Input -->
                  {!! Form::text("name",null,['id' => 'name', 'class' => 'form-control', 'placeholder' => utrans("billing.nameOnCard--placeholder")]) !!}
               </div>
            </div>
            <div class="col-12">
               <!-- Email address -->
               <div class="form-group new_card">
                  <!-- Label -->
                  <label class="mb-1">
                     {{utrans("billing.creditCardNumber")}}
                  </label>
                  <!-- Input -->
                  {!! Form::tel("cc-number",null,['id' => 'cc-number', 'autocomplete' => 'cc-number', 'class' => 'cc-number form-control', 'placeholder' => utrans("billing.creditCardNumber--placeholder")]) !!}
               </div>
            </div>
            <div class="col-12 col-md-4">
               <!-- Phone -->
               <div class="form-group new_card">
                  <!-- Label -->
                  <label>
                     {{utrans("billing.expirationDate")}}
                  </label>
                  <!-- Input -->
                  {!! Form::tel("expirationDate",null,['id' => 'expirationDate', 'class' => 'form-control', 'placeholder' => utrans("billing.expirationDate--placeholder")]) !!}
               </div>
            </div>
            <div class="col-12 col-md-4">
               <!-- Birthday -->
               <div class="form-group new_card">
                  <!-- Label -->
                  <label>
                     {{utrans("billing.cvc")}}
                  </label>
                  <!-- Input -->
                  {!! Form::tel("cvc",null,['id' => 'cvc', 'autocomplete' => 'cvc', 'class' => 'form-control', 'placeholder' => utrans("billing.cvc--placeholder")]) !!}
               </div>
            </div>
            <div class="col-12 col-md-4">
               <!-- Birthday -->
               <div class="form-group new_card">
                  <!-- Label -->
                  <label>
                     {{utrans("billing.zip")}}
                  </label>
                  <!-- Input -->
                  {!! Form::text("zip",null,['id' => 'zip', 'class' => 'form-control', 'placeholder' => utrans("billing.zip--placeholder"), 'required' => true]) !!}
               </div>
            </div>
            <div class="col-12 ">
               <!-- First name -->
               <div class="form-group new_card">
                  <!-- Label -->
                  <label>
                     {{utrans("billing.country")}}
                  </label>
                  <!-- Input -->
                  {!! Form::select("country",countries(),config("customer_portal.country"),['id' => 'country', 'class' => 'form-control', 'required' => true]) !!}
               </div>
            </div>
            <div id="stateWrapper" class="col-12 ">
               <!-- First name -->
               <div class="form-group new_card">
                  <!-- Label -->
                  <label>
                     {{utrans("billing.state")}}
                  </label>
                  <!-- Input -->
                  {!! Form::select("state",subdivisions(config("customer_portal.country")),config("customer_portal.state"),['id' => 'state', 'class' => 'form-control', 'required' => true]) !!}
               </div>
            </div>
            <div class="col-12 ">
               <!-- First name -->
               <div class="form-group new_card">
                  <!-- Label -->
                  <label>
                     {{utrans("billing.line1")}}
                  </label>
                  <!-- Input -->
                  {!! Form::text("line1",null,['id' => 'line1', 'class' => 'form-control', 'placeholder' => utrans("billing.line1--placeholder"), 'required' => true]) !!}
               </div>
            </div>
            <div class="col-12 ">
               <!-- First name -->
               <div class="form-group new_card">
                  <!-- Label -->
                  <label>
                     {{utrans("billing.city")}}
                  </label>
                  <!-- Input -->
                  {!! Form::text("city",null,['id' => 'city', 'class' => 'form-control', 'placeholder' => utrans("billing.city"), 'required' => true]) !!}
               </div>
            </div>
            <div class="col-12 ">
               <!-- First name -->
               <div class="form-group">
                  <!-- Label -->
                  <label>
                     {{utrans("billing.amountToPay")}}
                  </label>
                  <!-- Input -->
                  {!! Form::number("amount", null,['id' => 'amount', 'class' => 'form-control', 'placeholder' => utrans("Amount to Pay"), 'step' => 'any', 'required' => true]) !!}
               </div>
            </div>
            <div class="d-flex justify-content-between align-items-center" style="padding: 0px 12px;">
               <!-- Toggle -->
               <div class="custom-control custom-checkbox-toggle new_card">
                  {!! Form::checkbox("makeAuto", 1, false, ['id' => 'makeAuto', 'class' => 'custom-control-input']) !!}
                  <label class="custom-control-label" for="makeAuto"></label>
               </div>
               <!-- Help text -->
               <div class="ml-3">
                  <h4 class="text-dark new_card mb-0">
                     {{utrans("billing.enableAuto")}}
                  </h4>
               </div>
            </div>
            <div class="col-12 col-md-12 mt-5">
               <input type="hidden" name="payment_tracker_id" value="{{uniqid("", true)}}" />
               <button id="submit_payment" type="submit" class="btn btn-primary">{{utrans("billing.submitPayment")}}</button>
            </div>
         </div>
         {!! Form::close() !!}
      </div>
      <!-- / .row -->
   </div>
   <!-- / .container-fluid -->
</div>
<!-- / .main-content -->
@endsection
@section('additionalJS')
<script src="/assets/libs/jquery-payment-plugin/jquery.payment.min.js"></script>
<script src="/assets/js/pages/billing/payment/page.js"></script>
<script type="text/javascript" src="/assets/libs/js-validation/jsvalidation.min.js"></script>
{!! JsValidator::formRequest('App\Http\Requests\CreditCardPaymentRequest','#paymentForm') !!}
@endsection