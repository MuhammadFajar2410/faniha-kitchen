<!DOCTYPE html>
<html lang="en">

<head>

  @include('backend.layouts.head')

</head>

<body>

  <div class="container-fluid">

    <div class="row" style="margin-top:10%">
        <!-- 403 Error Text -->
      <div class="col-md-12">
        <div class="text-center">
          <div class="error mx-auto" data-text="403">403</div>
          <p class="lead text-gray-800 mb-5">Unautorized Please Check Our Policy</p>
          <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
          {{-- {{dd(auth()->user())}}; --}}
            <a href="{{route('home')}}">&larr; Back to Home</a>

        </div>
      </div>
    </div>

    </div>


    @include('backend.layouts.footer')

</body>

</html>
