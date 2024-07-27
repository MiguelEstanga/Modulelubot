@extends('layouts.app')



@section('content')
   @if(in_array('admin', user_roles()))
         @include('lubot::component.menu-configuracion-lubot')

         <div class="conatiner">
            
         </div>
   @endif
 
@endsection


