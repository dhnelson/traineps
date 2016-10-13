<div class="col-md-3 blog-index-sidebar">
    {!! Form::open (['action' => 'BlogController@subscribe', 'class'=>'navbar-form subscribe-spacing', 'data-parsley-validate' => '', 'data-parsley-errors-container'=>'#subscribe-errors']) !!}  
        <div class="input-group blue">
          {{ Form::label('Subscribe:') }}
          {{ Form::text('email', null, ['required'=>'', 'class'=>'form-control', 'placeholder'=>'Enter Email...']) }}
            <span class="input-group-btn subscribe-btn">
              <button class="btn btn-danger" type="submit">
                  <span class=" glyphicon glyphicon-search"></span>
              </button>
            </span>
        </div>
      <div id="subscribe-errors"></div>
    {!! Form::close() !!}

    <div class="blog-index-sidebar-contact">
        <dl>
            <dt class="red"><span class="glyphicon glyphicon-earphone blue"></span> Call or Text Me:</dt>
                <ul>
                    <li><dd><span>Cell: <a href="tel:1-646-717-3142">(646) 717-3142</a></span></dd></li>
                    <li><dd><span>Gym: <a href="tel:1-973-887-2496">(973) 887-2496</a></span></dd></li>
                </ul>
        </dl>
        <dl>
            <dt class="red"><span class="glyphicon glyphicon-globe blue"></span> My Social Media:</dt>
                <ul>
                    <li><dd><a href="https://www.facebook.com/Evolution-Performance-Systems-131558953564049/?fref=ts"><i class="fa fa-facebook-official" aria-hidden="true"></i> Facebook</a></dd></li>
                <li><dd><a href="https://www.instagram.com/eps_training"><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</a></dd></li>
                </ul>
        </dl> 
    </div>  
      
    {!! Form::open(['method'=>'GET', 'route'=>'blog.search', 'role'=>'keyword', 'class'=>'navbar-form subscribe-spacing', 'data-parsley-validate' => '', 'data-parsley-errors-container'=>'#search-errors'])  !!}
        <div class="input-group blue">
          {{ Form::label('Search:') }}
          {{ Form::text('keyword', null, ['required'=>'', 'class'=>'form-control', 'placeholder'=>'Search Posts...']) }}
            <span class="input-group-btn subscribe-btn">
              <button class="btn btn-danger" type="submit">
                  <span class=" glyphicon glyphicon-search"></span>
              </button>
            </span>
        </div>
      <div id="search-errors"></div>
    {!! Form::close() !!}

    <div class="blog-index-sidebar-content">
      <h4><u>Blog Posts</u></h4><br>
        @foreach ($posts as $post)
          <span><a href="{{ route('blog.single', $post->slug) }}">{{ $post->title }} </a></span>
        @endforeach <br><br>

      <h4><u>Categories</u></h4><br>
        @foreach ($categories as $category)
          <span><a href="{{ route('blog.category', $category->id) }}">{{ $category->name }} </a></span>
        @endforeach <br><br>

      <h4><u>Tags</u></h4><br>
        @foreach ($tags as $tag)
          <span><a href="{{ route('blog.tag', $tag->id) }}">{{ $tag->name }} </a></span>
        @endforeach <br><br>   
    </div>
</div>