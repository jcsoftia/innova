@extends('auth.contenido')

@section('login')
<!-- Begin page -->
        <div class="accountbg"></div>
        
        <div class="wrapper-page">
                <div class="card card-pages shadow-none">
    
                    <div class="card-body">
                        <div class="text-center m-t-0 m-b-15">
                                <a href="#" class=""><span><h1><i class="fas fa-first-aid"></i> Innova Dent</h1></span></a>
                                <a href="#">
                                    <span class="text-center mb-3" style="font-size:3.75rem; display:block; height:3.75rem !important" class=""><i class="mdi mdi-account-circle"></i></span>
                                </a>
                        </div>

                        
                        <h5 class="font-20 text-center">Inicie sesión</h5>
                        <form class="form-horizontal was-validated" method="POST" action="{{ route('login')}}" >
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="col-12 mb-3 {{$errors->has('usuario' ? 'is-invalid' : '')}}">
                                    
                                    <label>Username</label>
                                    <input type="text" value="{{old('usuario')}}" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
                                    <div class="text-center mt-1">
                                        {!!$errors->first('usuario','<span class="theme--dark error">:message</span>')!!}
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group ">
                                <div class="col-12 mb-4 {{$errors->has('password' ? 'is-invalid' : '')}}">
                                    <label>Password </label>
                                    {{-- <span class="text-center" style="font-size:2.75rem; display:block" class="pl-2"><i class="mdi mdi-cellphone-key"></i></span> --}}
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                    {!!$errors->first('password','<span class="theme--dark error">:message</span>')!!}
                                </div>
                            </div>
    
    
                            <div class="form-group text-center m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Iniciar Sesion</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
    
                </div>
            </div>
@endsection
