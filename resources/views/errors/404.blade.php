@extends('errors::minimal')

<div class="error-bg"></div>
{{-- @section('code', '404') --}}
@section('title', __('Página no encontrada') )

@section('code')
@endsection
@section('message')
        <link rel="stylesheet" href="./assets/css/plantilla.css">
        <!-- Begin page -->
        <div class="home-btn d-none d-sm-block">
                                            <a href="/" class="text-white"><i class="fas fa-home h2"></i></a>
                                        </div>
        
            <div class="account-pages">
            
                <div class="container">
                    <div class="row justify-content-center">
                            <div class="card shadow-lg">
                                <div class="card-block">
                                    
                                    <div class="text-center p-3">
                                        
                                            <h1 class="error-page mt-4"><span>404!</span></h1>
                                        <h4 class="mb-4 mt-5">Página no disponible</h4>
                                        <p class="mb-4">Lo siento, esta página no está disponible.<br> Ha sido eliminada o nunca existió.</p>
                                        
                                        <a class="btn btn-primary mb-4 waves-effect waves-light" href="/"><i class="mdi mdi-home"></i> Ir al inicio</a>
                                    </div>
                
                                </div>
                            </div>
                                                
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
        <!-- END wrapper -->
        <script src="./js/plantilla.js"></script>
@endsection