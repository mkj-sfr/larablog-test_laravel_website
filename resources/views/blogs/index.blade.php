@extends('layout')
@section('content')
    <!-- Banner Starts Here -->
    @include('partials._main_banner')
    <!-- Banner Ends Here -->

    <section class="blog-posts">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="all-blog-posts">
              <div class="row">
                @foreach ($blogs_by_search as $blog)
                                
                @php
                    $date = Illuminate\Support\Carbon::parse($blog->updated_at)
                @endphp
                
                
                <div class="col-lg-12">
                    <div class="blog-post">
                      <div class="blog-thumb">
                        <img src="{{$blog->image ? $blog->image : asset('images/blog-post-01.jpg')}}">
                      </div>
                      <div class="down-content">
                        <span>{{$blog->category()->first()->name}}</span>
                        <a href="/blogs/{{$blog->id}}"><h4>{{$blog->title}}</h4></a>
                        <ul class="post-info">
                          <li><a href="/blogs?name={{$blog->user()->first()->last_name}}">{{$blog->user()->first()->first_name . ' ' . $blog->user()->first()->last_name}}</a></li>
                           <li>{{$date->englishMonth . ' ' . $date->day . ', ' . $date->year}}</li> 
                          <li>{{$blog->comments()->count()}} Comments</li>
                        </ul>
                        <p>{{$blog->body}}</p>
                        <x-blog_tags :tags="$blog->tags"/>
                      </div>
                    </div>
                  </div>
              
              @endforeach
            </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="sidebar">
              <div class="row">

                <x-blog_search />

                <div class="col-lg-12">
                  <div class="sidebar-item recent-posts">
                    <div class="sidebar-heading">
                      <h2>Recent Posts</h2>
                    </div>
                    <div class="content">
                      <ul>
                        @foreach ($blogs as $blog)
                        @php
                            $date = Illuminate\Support\Carbon::parse($blog->updated_at)
                        @endphp
                        <li><a href="/blogs/{{$blog->id}}">
                          <h5>{{$blog->title}}</h5>
                          <span>{{$date->englishMonth . ' ' . $date->day . ', ' . $date->year}}</span>
                        </a></li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="sidebar-item categories">
                    <div class="sidebar-heading">
                      <h2>Categories</h2>
                    </div>
                    <div class="content">
                      <ul>
                        @foreach ($categories as $category)
                        <li><a href="/blogs?category={{$category->name}}">- {{$category->name}}</a></li>
                        @endforeach
                        
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    
    

@endsection