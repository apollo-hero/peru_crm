<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
    <H1>RECARGAR CREDITO A CHOFERES</H1>
<form action="{{route('admin.billeterarecargar')}}" method="POST">
    @csrf
    <div class="form-group col-md-6">
  
    <input type="text" name="phone" id="phone" placeholder="CELULAR" class="form-control mb-2">
    </div>
    <div class="form-group col-md-6">
   
    <input type="text" name="cantidad" placeholder="CANTIDAD A RECARGAR" class="form-control mb-2">
    </div>   
   
    <button  style="margin:20px" type="submit" class="btn btn-primary">RECARGAR</button>
</form>




<table class="table" >
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">CHOFER ID</th>
      <th scope="col">NOMBRE</th>
      <th scope="col">APELLIDO</th>
      <th scope="col">CELULAR</th>
      <th scope="col">TIPO</th>
      <th scope="col">IMPORTE</th>
      <th scope="col">BALANCE</th>
      <th scope="col">SALDO ACTUAL</th>
      <th scope="col">TRANSACCION</th>
      <th scope="col">FECHA</th>
    </tr>
  </thead>
  <tbody id="myTable">
                @foreach($ProviderWallet as $item)
                <tr>
                    <th scope="row">{{$item->id}}</th>
                    <td>{{$item->provider_id}}</td>
                    <td>{{$item->first_name}}</td>
                    <td>{{$item->last_name}}</td>
                    <td>{{$item->mobile}}</td>
                    <td>{{$item->type}}</td>
                    <td>{{$item->amount}}</td>
                    <td>{{$item->open_balance}}</td>
                    <td>{{$item->close_balance}}</td>
                    <td>{{$item->transaction_alias}}</td>
                    <td>{{$item->created_at}}</td>
                    
                </tr>
                @endforeach()


  
  </tbody>
</table>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

 <script>
    $(document).ready(function(){
    $("#phone").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    });
    </script>

    </body>
</html>

