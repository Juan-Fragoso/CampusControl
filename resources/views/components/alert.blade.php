 @if (session('success'))
     <div class="alert alert-success alert-dismissible fade show" role="alert">
         <strong>¡Exitoso!</strong> {{ session('success') }}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>
 @endif

 @if (session('error'))
     <div class="alert alert-danger alert-dismissible fade show" role="alert">
         <strong>Hubo un problema:</strong> {{ session('error') }}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>
 @endif

 @if ($errors->any())
     <div class="alert alert-warning border-0 shadow-sm">
         <ul class="mb-0">
             @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
             @endforeach
         </ul>
     </div>
 @endif
