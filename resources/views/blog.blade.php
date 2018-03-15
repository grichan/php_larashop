@extends('layouts.layout')

@section('content') 
<section id="advertisement">
    <div class="container">
        <img src="images/shop/advertisement.jpg" alt="" />
    </div>
</section>
{{ var_dump($data['posts'][0])}}
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    @include('shared.sidebar')
                </div>
            </div>
            <div class="col-sm-9">
                <div class="blog-post-area">
                    <h2 class="title text-center">Latest From our Blog</h2>

                @for($i = 0; $i < count($data['posts']); $i++)
                    <div class="single-blog-post">
                        <h3>{{$data['posts'][$i]->title}}</h3>
                        <div class="post-meta">
                            <ul>
                                <li><i class="fa fa-user"></i> Dr. Peper </li>
                                <li><i class="fa fa-clock-o"></i> -99999 pm</li>
                                <li><i class="fa fa-calendar"></i> DEC 5, 2027</li>
                            </ul>
                            <span>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </span>
                        </div>
                        <a href="">
                            <img src="images/blog/{{$data['posts'][$i]->image}}" alt="">
                        </a>
                        <p>{{$data['posts'][$i]->content}}</p>
                        <a  class="btn btn-primary" href="{{url(
                        'blog/post/' .$data['posts'][$i]->blog .'')}}">Read More</a>
                    </div>
                @endfor

                    <div class="pagination-area">
                        <ul class="pagination">
                            <li><a href="" class="active">1</a></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                            <li><a href=""><i class="fa fa-angle-double-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection