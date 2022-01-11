<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sample CRUD Firebase Javascript - 01 Read Data</title>
    <link rel="stylesheet" href="style.css" />
</head>

<style type="text/css">
body,
h1,
h2 {
    margin: 0;
    padding: 0;
}

body {
    background: #8a3921a3;
    font-family: Arial, sans-serif;
    color: #ffffff;
}

h1 {
    padding: 10px;
    background: #ffcc00;
    color: #000;
}

#data {
    margin-top: 20px;
}
</style>

<body>
    <center>
        <h1 id="conductorAlerta" style="font-size: 450; display: none;"> ESCUCHANDO ALERTAS SOS


        </h1>
        <h4 id="conductorAlertaH4" style="font-size: 450; display: none;">SISTEMA DE ALERTA SOS CONDUCTORES</h4>
        <button id="startbtn">Iniciar Escucha SOS</button>

        <audio id="music" src="http://miappdetaxi0001-001-site7.gtempurl.com/audio/red-alert.mp3" loop></audio>


        <div id="data" style="display: none;">
            <table cellpadding="6" border=1>
                <thead>
                    <th>
                        Fechayhora
                    </th>

                    <th>nombreConductor</th>
                    <th>sonando</th>
                    <th>Delete</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </center>


    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-database.js"></script>
    <!-- TODO: Add SDKs for Firebase products that you want to use
			     https://firebase.google.com/docs/web/setup#available-libraries -->

    <script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyDL-rSm-EpqAjhxo7vbwWfHAL0XpLtFRxE",
        authDomain: "dtaxicmexico.firebaseapp.com",
        databaseURL: "https://dtaxicmexico-default-rtdb.firebaseio.com",
        projectId: "dtaxicmexico",
        storageBucket: "dtaxicmexico.appspot.com",
        messagingSenderId: "6461474198",
        appId: "1:6461474198:web:e094ebf7193725a98d89b7",
        measurementId: "G-N1Z9KPVR29"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    </script>

    <script type="text/javascript">
    const dbRef = firebase.database().ref();

    const sos = dbRef.child('sos');


    sos.on("child_added", snap => {

        let child_sos = snap.val();
        var datetime = '';

        if (child_sos.fechayhora != undefined)
            datetime = child_sos.fechayhora;


        if (child_sos.FECHA != undefined)
            datetime = child_sos.FECHA;


        console.log(child_sos.lat);
        console.log(child_sos.lng);
        console.log(child_sos.nombreConductor);
        console.log(child_sos.sonando);

        //var row  = '<tr><td>'+datetime+'</td><td>'+child_sos.lat+'</td><td>'+child_sos.lng+'</td><td>'+child_sos.nombreConductor+'</td><td>'+child_sos.sonando+'</td><td><button key='+snap.key+' Onclick="return ConfirmDelete();" class="delete" >Delete</button></td></tr>';
        var row = '<tr><td>' + datetime + '</td><td>' + child_sos.nombreConductor + '</td><td>' + child_sos
            .sonando + '</td><td><button key=' + snap.key +
            ' Onclick="return ConfirmDelete();" class="delete" >Delete</button></td></tr>';

        $("#data tr:last").after(row);

        var audio = document.getElementById("music");
        audio.play();

    });


    function ConfirmDelete() {

    }

    // delete opration
    $(document).on('click', '.delete', function(event) {


        if (confirm("Estas seguro que desea eliminar la Alerta?")) {

            var key = $(this).attr('key');
            const sosRef = dbRef.child('sos/' + key);
            sosRef.remove();
            $(this).parent().parent().remove();
            var audio = document.getElementById("music");
            audio.pause();

        } else {
            return false;

        }

    });


    const startbtn = document.getElementById("startbtn");
    const conductorAlerta_ = document.getElementById("conductorAlerta");

    const data_ = document.getElementById("data");

    const conductorAlertaH4_ = document.getElementById("conductorAlertaH4");
    startbtn.addEventListener("click", () => {
        music
        //Show the loader and hide the button

        conductorAlerta_.style.display = "";
        data_.style.display = "";
        conductorAlertaH4_.style.display = "";
        //Wait for the music to start
        music.play().then(() => {
            //Hide the loader and show the content
            music.pause();
        });
    });
    </script>
</body>

</html>