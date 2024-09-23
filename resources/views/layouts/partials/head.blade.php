<!doctype html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="description" content="Customer Portal">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{config("customer_portal.company_name")}}</title>
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" href="/assets/fonts/feather/feather.min.css">
      <link rel="stylesheet" href="/assets/libs/flatpickr/dist/flatpickr.min.css">
      <link rel="stylesheet" href="/assets/css/theme.css">
      <link rel="stylesheet" href="/assets/css/select2.css">
      <link rel="stylesheet" href="/assets/css/bootstrap-colorpicker.min.css">
      <link rel="stylesheet" href="/assets/css/Chart.min.css">
      <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon_package/apple-touch-icon.png') }}">
      <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon_package/favicon-32x32.png') }}">
      <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon_package/favicon-16x16.png') }}">
      <link rel="mask-icon" href="{{ asset('favicon_package/safari-pinned-tab.svg') }}" color="#5bbad5">
      <meta name="msapplication-TileColor" content="#da532c">
      <meta name="theme-color" content="#ffffff">
   </head>
