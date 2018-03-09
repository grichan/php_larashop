@extends('layouts.master')

    <h4> {{$name}} </h4>

@foreach( $product_categories as $product_category)
   {{$product_category->name}};
@endforeach