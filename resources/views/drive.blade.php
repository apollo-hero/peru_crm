@extends('user.layout.app')

@section('content')
<div class="banner row no-margin" style="background-image: url('{{ asset('asset/img/banner-bg.jpg') }}');">
    <div class="banner-overlay"></div>
    <div class="container pad-60">
        <div class="col-md-8">
            <h2 class="banner-head"><span class="strong">Trabajo que te pone primero</span><br>Conduce cuando quieras, haz lo que necesites</h2>
        </div>
        <div class="col-md-4">
            <div class="banner-form">
                <!-- <div class="row no-margin fields">
                    <div class="left">
                    	<img src="{{asset('asset/img/taxi-app.png')}}">
                    </div>
                   <div class="right">
                        <a href="{{url('login')}}">
                            <h3>Viaja con {{config('constants.site_title','Tranxit')}}</h3>
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
                            <h5>REGISTRARSE <i class="fa fa-chevron-right"></i></h5>
                        </a>
                    </div>
                </div>

                <!-- <p class="note-or">Or <a href="{{ url('login') }}">sign in</a> with your rider account.</p> -->
            </div>
        </div>
    </div>
</div>

<div class="row white-section pad-60 no-margin">
    <div class="container">
        
        <div class="col-md-4 content-block small">
             <div class="box-shadow">
                <div class="icon"><img src="{{asset('asset/img/driving-license.png')}}"></div>
            <h2>Establece tu propio horario</h2>
            <div class="title-divider"></div>
            <p>Puedes conducir con {{ config('constants.site_title', 'Tranxit') }} en cualquier momento, de día o de noche, los 365 días del año. Cuando conduce siempre depende de usted, por lo que nunca interfiere con las cosas importantes de su vida.</p>
        </div>
    </div>

        <div class="col-md-4 content-block small">
             <div class="box-shadow">
                <div class="icon"><img src="{{asset('asset/img/destination.png')}}"></div>
            <h2>Haz más a cada paso</h2>
            <div class="title-divider"></div>
            <p>Las tarifas de viaje comienzan con una cantidad base, luego aumentan con el tiempo y la distancia. Y cuando la demanda es más alta de lo normal, los conductores hacen más.</p>
        </div>
    </div>

        <div class="col-md-4 content-block small">
             <div class="box-shadow">
                <div class="icon"><img src="{{asset('asset/img/taxi-app.png')}}"></div>
            <h2>Deje que la aplicación lidere el camino</h2>
            <div class="title-divider"></div>
            <p>Solo toca y listo. Obtendrá instrucciones paso a paso, herramientas para ayudarlo a hacer más y asistencia 24/7, todo disponible allí mismo en la aplicación.</p>
        </div>
    </div>

    </div>
</div>

<div class="row gray-section no-margin full-section">
    <div class="container">                
        <div class="col-md-6 content-block">
            <div class="icon"><img src="{{asset('asset/img/taxi-car.png')}}"></div>
            <h3>Acerca de la aplicación</h3>
            <h2>Diseñado solo para conductores</h2>
            <div class="title-divider"></div>
            <p>Cuando desee ganar dinero, simplemente abra la aplicación y comenzará a recibir solicitudes de viaje. Obtendrá información sobre su piloto y las direcciones para llegar a su ubicación y destino. Cuando termine el viaje, recibirá otra solicitud cercana. Y si está listo para salir de la carretera, puede cerrar la sesión en cualquier momento.</p>
            <!--<a class="content-more more-btn" href="{{url('login')}}">VER CÓMO FUNCIONA <i class="fa fa-chevron-right"></i></a>-->
        </div>
        <div class="col-md-6 full-img text-center" style="background-image: url({{ asset('asset/img/driver-car.jpg') }});"> 
            <!-- <img src="img/anywhere.png"> -->
        </div>
    </div>
</div>

<div class="row white-section pad-60 no-margin">
    <div class="container">
        
        <div class="col-md-4 content-block small">
            <div class="box-shadow">
                <div class="icon"><img src="{{asset('asset/img/budget.png')}}"></div>
            <h2>Recompensas</h2>
            <div class="title-divider"></div>
            <p>Estás en el asiento del conductor. Así que recompénsese con descuentos en combustible, mantenimiento de vehículos, facturas de teléfonos celulares y más. Reduce tus gastos diarios y llévate dinero extra a casa.</p>
        </div></div>

        <div class="col-md-4 content-block small">
            <div class="box-shadow">
                <div class="icon"><img src="{{asset('asset/img/driving-license.png')}}"></div>
            <h2>Requisitos</h2>
            <div class="title-divider"></div>
            <p>Sepa que está listo para salir a la carretera. Ya sea que conduzca su propio automóvil o un vehículo con licencia comercial, debe cumplir con los requisitos mínimos y completar un control de seguridad en línea.</p>
        </div></div>

        <div class="col-md-4 content-block small">
            <div class="box-shadow">
                <div class="icon"><img src="{{asset('asset/img/seat-belt.png')}}"></div>
            <h2>La seguridad</h2>
            <div class="title-divider"></div>
            <p>Cuando conduces con {{ config('constants.site_title', 'Tranxit') }}, obtienes asistencia al conductor 24/7 y cobertura de seguro. Y todos los pasajeros son verificados con su información personal y número de teléfono, para que sepa a quién va a recoger y nosotros también.</p>
        </div></div>

    </div>
</div>
            
<div class="row find-city no-margin">
    <div class="container">
        <div class="col-md-12 center content-block">
            <div class="box-shadow">
                <div class="pad-60 ">
        <h2>Empieza a ganar dinero</h2>
        <p>Listo para ganar dinero? El primer paso es registrarse en el App.</p>
<a class="content-more more-btn" href="https://play.google.com/store/apps/details?id=com.tranxitpro.ServiTaxiConductor">COMIENCE A CONDUCIR AHORA <i class="fa fa-chevron-right"></i></a>
        <!-- <button type="submit" class="full-primary-btn drive-btn">START DRIVE NOW</button> -->
    </div>
</div>
</div>
    </div>
</div>

<!-- <div class="footer-city row no-margin" style="background-image: url({{ asset('asset/img/footer-city.png') }});"></div> -->
@endsection