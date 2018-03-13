@extends('layouts.master')

    <h4> {{$name}} </h4>

@foreach( $drinks as $drink)
   {{$drink}}
    <br>
@endforeach

@foreach ($brands as $brand)
    <li><a href='{{url("products/brands/$brand->name")}}'> <span class="pull-right">(50)</span>{{$brand->name}}</a></li>
@endforeach