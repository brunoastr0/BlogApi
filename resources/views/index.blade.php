@extends('layouts.app')

@section('main')
    <div class="flex w-full flex-1 flex-col items-center px-8 md:px-20 text-center">
        <div class="absolute top-0 right-0 mt-4 mr-4">
            @if (Route::has('login'))
                <div class="space-x-4">
                    @auth
                        <a
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="font-medium text-primary hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150"
                        >
                            Log out
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="font-medium text-primary hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="font-medium text-primary hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
        <div class=" border-t-[1px] border-white/5 mt-4 md:mt-16 flex flex-wrap md:max-w-full gap-4 justify-center">


      

        
    
                
                       @foreach ($posts as $post)
                       <div class="w-full max-w-[400px]  mt-10 md:mt-24 cursor-pointer overflow-hidden ">
                       <div class="w-full bg-default rounded shadow-lg p-8 flex flex-col justify-center items-center">
                    
                        <div class="justify-start text-start space-y-4 leading-3 mt-8">
                          <p class="text-white text-xl">{{$post->title}}</p>
                          <p class="text-muted text-lg">{{$post->content}}</p>
                        </div>
                       </div>        
                    </div>


                           
                       @endforeach
                    </div>


            
        </div>
    </div>
@endsection
