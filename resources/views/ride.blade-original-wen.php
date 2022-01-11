@extends('user.layout.app')

@section('content')
    <div class="banner row no-margin" style="background-image: url('{{ asset('asset/img/banner-bg.jpg') }}');">
        <div class="banner-overlay"></div>
        <div class="container pad-60">
            <div class="col-md-8">
                <h2 class="banner-head"><span class="strong">Siempre el viaje que quieres</span><br>La mejor manera de llegar a donde quiera que vayas</h2>
            </div>
            <div class="col-md-4">
                <div class="banner-form">
                   <!-- <div class="row no-margin fields">
                        <div class="left">
                           <img src="{{asset('asset/img/taxi-app.png')}}">
                        </div>
                        <div class="right">
                            <a href="{{url('login')}}">
                                <h3>Paseo con{{config('constants.site_title','Tranxit')}}</h3>
                                <h5>REGISTRARSE <i class="fa fa-chevron-right"></i></h5>
                            </a>
                        </div>
                    </div>-->
                    <div class="row no-margin fields">
                        <div class="left">
                        <img src="{{asset('asset/img/taxi-app.png')}}">
                        </div>
                        <div class="right">
                            <a href="{{url('provider/login')}}">
                                <h3>Inicia sesión para conducir</h3>
                                <h5>REGÍSTRATE <i class="fa fa-chevron-right"></i></h5>
                            </a>
                        </div>
                    </div>

                   <!--  <p class="note-or">Or <a href="{{url('provider/login')}}">sign in</a> with your driver account.</p> -->
                    
                </div>
            </div>
        </div>
    </div>

    <div class="row white-section pad-60 no-margin">
        <div class="container ">
            
            <div class="col-md-4 content-block small">
                <div class="box-shadow">
                <div class="icon"><img src="{{asset('asset/img/taxi-app.png')}}"></div>
                <h2>Toca la aplicación y viaja seguro</h2>
                <div class="title-divider"></div>
                <p>{{ config('constants.site_title', 'Tranxit')  }}es la forma más inteligente de moverse. Un toque y un automóvil llega directamente a usted. Su conductor sabe exactamente a dónde ir. Y puede pagar en efectivo o con tarjeta.</p>
            </div>
        </div>

            <div class="col-md-4 content-block small">
                 <div class="box-shadow">
                 <div class="icon"><img src="{{asset('asset/img/destination.png')}}"></div>
                <h2>Elige cómo pagar</h2>
                <div class="title-divider"></div>
                <p>Cuando llegue a su destino, pague en efectivo o cargue automáticamente su tarjeta. Con {{ config('constants.site_title', 'Tranxit') }}, la decisión es tuya.</p>
            </div>
        </div>

            <div class="col-md-4 content-block small">
                 <div class="box-shadow">
                 <div class="icon"><img src="{{asset('asset/img/budget.png')}}"></div>
                <h2>Usted califica, nosotros escuchamos</h2>
                <div class="title-divider"></div>
                <p>Califique a su conductor y brinde comentarios anónimos sobre su viaje. Su aporte nos ayuda a hacer de cada viaje una experiencia de 5 estrellas.</p>
            </div>
        </div>


        </div>
    </div>

  

          

    <!-- <div class="row gray-section no-margin">
        <div class="container">                
            <div class="col-md-6 content-block">
                <h2>Safety Putting people first</h2>
                <div class="title-divider"></div>
                <p>Whether riding in the backseat or driving up front, every part of the {{ config('constants.site_title', 'Tranxit') }} experience has been designed around your safety and security.</p>
                <a class="content-more" href="#">HOW WE KEEP YOU SAFE <i class="fa fa-chevron-right"></i></a>
            </div>
            <div class="col-md-6 img-block text-center"> 
                <img src="{{asset('asset/img/seat-belt.jpg')}}">
            </div>
        </div>
    </div> -->
    <div class="row gray-section pad-60 full-section">
    <div class="container">
        <div class="col-md-6 content-block">
              <div class="icon"><img src="{{ asset('asset/img/seat-belt.png') }}"></div>
            <h2>Seguridad poniendo a las personas primero</h2>
            <div class="title-divider"></div>
            <p>Ya sea montando en el asiento trasero o conduciendo al frente, cada parte del {{ config('constants.site_title', 'Tranxit') }} La experiencia ha sido diseñada en torno a su seguridad.</p>
           <!-- <a class="content-more more-btn" href="{{url('login')}}">CÓMO TE MANTENEMOS SEGURO <i class="fa fa-chevron-right"></i></a>-->
        </div>
        <!-- <div class="col-md-6 img-box text-center"> 
            <img src="{{ asset('asset/img/seat-belt.jpg') }}">
        </div> -->
        <div class="col-md-6 full-img text-center" style="background-image: url({{ asset('asset/img/safty-bg.jpg') }});"> 
            <!-- <img src="img/anywhere.png"> -->
        </div>
    </div>
</div>


    <!-- <div class="row find-city no-margin">
        <div class="container">
            <h2>{{config('constants.site_title','Tranxit')}} is in your city</h2>
            <form>
                <div class="input-group find-form">
                    <input type="text" class="form-control"  placeholder="Search" >
                    <span class="input-group-addon">
                        <button type="submit">
                            <i class="fa fa-arrow-right"></i>
                        </button>  
                    </span>
                </div>
            </form>
        </div>
    </div> -->
    <?php $footer = asset('asset/img/footer-city.png'); ?>
    <!-- <div class="footer-city row no-margin" style="background-image: url({{$footer}});"></div> -->
@endsection


@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function () {

    $("#btnSubmit").click(function (event) {


    event.preventDefault();

    $.ajax({
       type: "POST",
       url: "{{url('/fare')}}",
       data: $("#idForm").serialize(),

       success: function(data)
       { 
           $("#div1").show();
           $("#div2").show();
           $("#btnSubmit").hide();
           $("#div1").html("Estimated Fare - "+data.estimated_fare+"$");
           $("#div2").html("Distance - "+data.distance+"mile(s)");


       }
     });


 

   });

});

</script>


@endsection



