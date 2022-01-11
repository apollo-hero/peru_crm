'use strict';

class DispatcherPanel extends React.Component {
    componentWillMount() {
        this.setState({
            listContent: 'dispatch-map'
        });
    }

    handleUpdateBody(body) {
        console.log('Body Update Called', body);
        this.setState({
            listContent: body
        });
    }

    handleUpdateFilter(filter) {
        console.log('Filter Update Called', this.state.listContent);
        if(filter == 'all'){
            this.setState({
                listContent: 'dispatch-map'
            });
        }else if(filter == 'assigned'){
            this.setState({
                listContent: 'dispatch-assigned'
            });
        }else if(filter == 'cancelled'){
            this.setState({
                listContent: 'dispatch-cancelled'
            });
        }else if(filter == 'return'){
            this.setState({
                listContent: 'dispatch-return'
            });
        }else{
            this.setState({
                listContent: 'dispatch-map'
            });
        }
    }

    handleRequestShow(trip, event) {
        console.log('Show Request', trip);
        if(trip.status == 'CANCELLED') {
            this.setState({
                listContent: 'dispatch-cancelled',
                trip: trip
            });
        } else {
            if(trip.current_provider_id == 0) {
                this.setState({
                    listContent: 'dispatch-assign',
                    trip: trip
                });

            } else {
                this.setState({
                    listContent: 'dispatch-map',
                    trip: trip
                });
            }
        }
        
        ongoingInitialize(trip);
    }

    handleAutoRequest(trip) {
        if(trip.status == 'SEARCHING' && trip.current_provider_id != 0) {
            this.setState({
                listContent: 'dispatch-map',
                trip: trip
            });
            $('.notification').remove();
            $('.container-fluid').first().before('<div class="alert alert-danger notification"><button type="button" class="close" data-dismiss="alert">×</button><p style="margin-top:10px;">Ride is auto assigned. You cannot manually assign drivers.</p></div>');
            setTimeout(function() { $('.notification').fadeOut('fast', 'linear', function() { $('.notification').delay(5000).remove(); }); }, 5000);
        }
        
    }

    handleRequestCancel(argument) {
        this.setState({
            listContent: 'dispatch-map'
        });
    }

    render() {

        let listContent = null;

        // console.log('DispatcherPanel', this.state.listContent);

        switch(this.state.listContent) {
            case 'dispatch-create':
                listContent = <div className="col-md-6">
                        <DispatcherRequest completed={this.handleRequestShow.bind(this)} cancel={this.handleRequestCancel.bind(this)} />
                    </div>;
                break;
            case 'dispatch-map':
                listContent = <div className="col-md-6">
                        <DispatcherList clicked={this.handleRequestShow.bind(this)} checked={this.handleAutoRequest.bind(this)} />
                    </div>;
                break;
            case 'dispatch-assigned':
                listContent = <div className="col-md-6">
                        <DispatcherAssignedList />
                    </div>;
                break;
            case 'dispatch-cancelled':
                listContent = <div className="col-md-6">
                        <DispatcherCancelledList clicked={this.handleRequestShow.bind(this)} />
                    </div>;
                break;
            case 'dispatch-assign':
                listContent = <div className="col-md-6">
                        <DispatcherAssignList trip={this.state.trip} />
                    </div>;
                break;
        }

        return (
            <div className="container-fluid">
                <h4>Dispatcher</h4>

                <DispatcherNavbar body={this.state.listContent} updateBody={this.handleUpdateBody.bind(this)} updateFilter={this.handleUpdateFilter.bind(this)}/>

                <div className="row">
                    { listContent }

                    <div className="col-md-6">
                        <DispatcherMap body={this.state.listContent} />
                    </div>
                </div>
            </div>
        );

    }
};

class DispatcherNavbar extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            body: 'dispatch-map',
            selected:''
        };
    }

    filter(data) {
        console.log('Navbar Filter', data);
        this.setState({selected  : data})
        this.props.updateFilter(data);
    }

    handleBodyChange() {
        // console.log('handleBodyChange', this.state);
        if(this.props.body != this.state.body) {
            this.setState({
                body: this.props.body
            });
        }

        if(this.state.body == 'dispatch-map') {
            console.log("augus 001");
            this.props.updateBody('dispatch-create');
            this.setState({
                body: 'dispatch-create'
            });
        }else if(this.state.body == 'dispatch-assigned') {
            console.log("augus 002");
            this.props.updateBody('dispatch-map');
            this.setState({
                body: 'dispatch-assigned'
            });
        }else if(this.state.body == 'dispatch-cancelled') {
            console.log("augus 003");
            this.props.updateBody('dispatch-map');
            this.setState({
                body: 'dispatch-cancelled'
            });
        } else {
            console.log("augus 004");
            this.props.updateBody('dispatch-map');
            this.setState({
                body: 'dispatch-map'
            });
        }
    }

    isActive(value){
        return 'nav-item '+((value===this.state.selected) ?'active':'');
    }

    render() {
        return (
            <nav className="navbar navbar-light bg-white b-a mb-2">
                <button className="navbar-toggler hidden-md-up" 
                    data-toggle="collapse"
                    data-target="#process-filters"
                    aria-controls="process-filters"
                    aria-expanded="false"
                    aria-label="Toggle Navigation"></button>
                

                <ul className="nav navbar-nav float-xs-right">
                    <li className="nav-item">
                        <button type="button" 
                            onClick={this.handleBodyChange.bind(this)} 
                            className="btn btn-success btn-md label-right b-a-0 waves-effect waves-light">
                            <span className="btn-label"><i className="ti-plus"></i></span>
                            Agregar
                        </button>
                    </li>
                </ul>

                <div className="collapse navbar-toggleable-sm" id="process-filters">
                    <ul className="nav navbar-nav dispatcher-nav">
                        <li className={this.isActive('all')} onClick={this.filter.bind(this, 'all')}>
                            <span className="nav-link" href="#">Buscando</span>
                        </li>
                        <li className={this.isActive('assigned')} onClick={this.filter.bind(this, 'assigned')}>
                            <span className="nav-link" href="#">Asignado</span>
                        </li>
                        <li className={this.isActive('cancelled')} onClick={this.filter.bind(this, 'cancelled')}>
                            <span className="nav-link" href="#">Cancelado</span>
                        </li>
                        
                    </ul>
                </div>
            </nav>
        );
    }
}

class DispatcherList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            data: {
                data: []
            }
        };
        this.getTripsUpdate = this.getTripsUpdate.bind(this);
    }

    componentDidMount() {
        window.worldMapInitialize();
        window.Tranxit.TripTimer = setInterval(
            () => this.getTripsUpdate(),
            1000
        );
    }

    componentWillUnmount() {
        clearInterval(window.Tranxit.TripTimer);
    }

    getTripsUpdate() {
        $.get('/admin/dispatcher/trips?type=SEARCHING', function(result) {
            if(result.hasOwnProperty('data')) {
                this.setState({
                    data: result
                });
            } else {
                this.setState({
                    data: {
                        data: []
                    }
                });
            }
        }.bind(this));
    }

    handleClick(trip) {
        this.props.checked(trip);
        this.props.clicked(trip);
    }

    render() {
        return (
            <div className="card">
                <div className="card-header text-uppercase"><b>Lista de búsqueda</b></div>
                <DispatcherListItem data={this.state.data.data} clicked={this.handleClick.bind(this)} />
            </div>
        );
    }
}

class DispatcherAssignedList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            data: {
                data: []
            }
        };
        this.getTripsUpdate = this.getTripsUpdate.bind(this);
    }

    componentDidMount() {
        window.worldMapInitialize();
        window.Tranxit.TripTimer = setInterval(
            () => this.getTripsUpdate(),
            1000
        );
    }

    componentWillUnmount() {
        clearInterval(window.Tranxit.TripTimer);
    }

    getTripsUpdate() {
        $.get('/admin/dispatcher/trips?type=ASSIGNED', function(result) {
            if(result.hasOwnProperty('data')) {
                this.setState({
                    data: result
                });
            } else {
                this.setState({
                    data: {
                        data: []
                    }
                });
            }
        }.bind(this));
    }

    render() {
        return (
            <div className="card">
                <div className="card-header text-uppercase"><b>Lista asignada</b></div>
                <DispatcherAssignedListItem data={this.state.data.data} />
            </div>
        );
    }
}


class DispatcherAssignedListItem extends React.Component {

    render() {
        var listItem = function(trip) {
            return (
                    <div className="il-item" key={trip.id}>
                        <a className="text-black" href="#">
                            <div className="media">
                                <div className="media-body">
                                    <p className="mb-0-5">{trip.user.first_name} {trip.user.last_name} 
                                    {trip.status == 'COMPLETED' ?
                                        <span className="tag tag-success pull-right"> {trip.status} </span>
                                    : trip.status == 'ASSIGNED' ?
                                        <span className="tag tag-danger pull-right"> {trip.status} </span>
                                    : trip.status == 'CANCELLED' ?
                                        <span className="tag tag-danger pull-right"> {trip.status} </span>
                                    : trip.status == 'SEARCHING' ?
                                        <span className="tag tag-warning pull-right"> {trip.status} </span>
                                    : trip.status == 'SCHEDULED' ?
                                        <span className="tag tag-primary pull-right"> {trip.status} </span>
                                    : 
                                        <span className="tag tag-info pull-right"> {trip.status} </span>
                                    }
                                    </p>
                                    <h6 className="media-heading">Desde: {trip.s_address}</h6>
                                    <h6 className="media-heading">A: {trip.d_address ? trip.d_address : "Not Selected"}</h6>
                                    <h6 className="media-heading">Pago: {trip.payment_mode}</h6>
                                    <h6 className="media-heading">Chofer asignado: {trip.provider.first_name} {trip.provider.last_name}</h6>
                                    <span className="text-muted">Asignado a : {trip.updated_at}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                );
        }.bind(this);

        return (
            <div className="items-list">
                {this.props.data.map(listItem)}
            </div>
        );
    }
}

class DispatcherCancelledList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            data: {
                data: []
            }
        };
        this.getTripsUpdate = this.getTripsUpdate.bind(this);
    }

    componentDidMount() {
        window.worldMapInitialize();
        window.Tranxit.TripTimer = setInterval(
            () => this.getTripsUpdate(),
            1000
        );
    }

    componentWillUnmount() {
        clearInterval(window.Tranxit.TripTimer);
    }

    getTripsUpdate() {
        $.get('/admin/dispatcher/trips?type=CANCELLED', function(result) {
            if(result.hasOwnProperty('data')) {
                this.setState({
                    data: result
                });
            } else {
                this.setState({
                    data: {
                        data: []
                    }
                });
            }
        }.bind(this));
    }

    handleClick(trip) {
        this.props.clicked(trip);
    }

    render() {
        return (
            <div className="card">
                <div className="card-header text-uppercase"><b>Cancelled List</b></div>
                <DispatcherCancelledListItem data={this.state.data.data} clicked={this.handleClick.bind(this)} />
            </div>
        );
    }
}


class DispatcherCancelledListItem extends React.Component {
    handleClick(trip) {
        this.props.clicked(trip)
    }

    render() {
        var listItem = function(trip) {
            return (
                    <div className="il-item" key={trip.id}  onClick={this.handleClick.bind(this, trip)}>
                        <a className="text-black" href="#">
                            <div className="media">
                                <div className="media-body">
                                    <p className="mb-0-5">{trip.user.first_name} {trip.user.last_name} 
                                    {trip.status == 'COMPLETED' ?
                                        <span className="tag tag-success pull-right"> {trip.status} </span>
                                    : trip.status == 'CANCELLED' ?
                                        <span className="tag tag-danger pull-right"> {trip.status} </span>
                                    : trip.status == 'SEARCHING' ?
                                        <span className="tag tag-warning pull-right"> {trip.status} </span>
                                    : trip.status == 'SCHEDULED' ?
                                        <span className="tag tag-primary pull-right"> {trip.status} </span>
                                    : 
                                        <span className="tag tag-info pull-right"> {trip.status} </span>
                                    }
                                    </p>
                                    <h6 className="media-heading">From: {trip.s_address}</h6>
                                    <h6 className="media-heading">To: {trip.d_address ? trip.d_address : "Not Selected"}</h6>
                                    <h6 className="media-heading">Payment: {trip.payment_mode}</h6>
                                    <h6 className="media-heading">Reason: {trip.cancel_reason}</h6>
                                    <span className="text-muted">Cancelled at : {trip.updated_at}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                );
        }.bind(this);

        return (
            <div className="items-list">
                {this.props.data.map(listItem)}
            </div>
        );
    }
}

class DispatcherListItem extends React.Component {
    handleClick(trip) {
        this.props.clicked(trip)
    }

    handleCancel(trip, event) {
        event.stopPropagation();
        location.assign("/admin/dispatcher/cancel?request_id="+trip.id);
    }

    render() {
        var listItem = function(trip) {
            return (
                    <div className="il-item" key={trip.id} onClick={this.handleClick.bind(this, trip)}>
                        <button className="btn btn-danger" onClick={this.handleCancel.bind(this, trip)} >Cancel Ride</button>
                        <a className="text-black" href="#">
                            <div className="media">
                                <div className="media-body">
                                    <p className="mb-0-5">{trip.user.first_name} {trip.user.last_name} 
                                    {trip.status == 'COMPLETED' ?
                                        <span className="tag tag-success pull-right"> {trip.status} </span>
                                    : trip.status == 'CANCELLED' ?
                                        <span className="tag tag-danger pull-right"> {trip.status} </span>
                                    : trip.status == 'SEARCHING' ?
                                        <span className="tag tag-warning pull-right"> {trip.status} </span>
                                    : trip.status == 'SCHEDULED' ?
                                        <span className="tag tag-primary pull-right"> {trip.status} </span>
                                    : 
                                        <span className="tag tag-info pull-right"> {trip.status} </span>
                                    }
                                    </p>
                                    <h6 className="media-heading">From: {trip.s_address}</h6>
                                    <h6 className="media-heading">To: {trip.d_address ? trip.d_address : "Not Selected"}</h6>
                                    <h6 className="media-heading">Payment: {trip.payment_mode}</h6>
                                    <progress className="progress progress-success progress-sm" max="100"></progress>
                                    <span className="text-muted">{trip.current_provider_id == 0 ? "Manual Assignment" : "Auto Search"} : {trip.created_at}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                );
        }.bind(this);

        return (
            <div className="items-list">
                {this.props.data.map(listItem)}
            </div>
        );
    }
}

class Modal extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            loadCount: props.loadCount,
            directions: props.directions,
            show: props.show
        };
        this.handleModal = this.handleModal.bind(this);
    }

    handleModal = () => {
        this.state.show ? $("#incoming").modal('show') : $("#incoming").hide('hide');
    }

    componentDidUpdate(prevProps, prevState) {
        if(this.state.loadCount == this.props.loadCount) return;
        this.setState({
            loadCount: this.props.loadCount,
            directions: this.props.directions,
            show: this.props.show
        }, () => {
            this.handleModal();
        });
    }

    render() {
        return (
            <div className="modal fade" id="incoming" role="dialog">
                <div className="modal-dialog" role="document">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h4 className="modal-title text-center incoming-tit" id="myModalLabel">Address List</h4>
                        </div>
                        <div className="modal-body">
                            <table className="table">
                                <thead className="thead">
                                    <tr>
                                        <th>Dirección Origen</th>
                                        <th>Latitude</th>
                                        <th>Longtitude</th>
                                    </tr>
                                </thead>
                                <tbody className="tbody">
                                    {
                                        this.state.directions.map(({id, s_address, s_latitude, s_longitude}) => (
                                            <tr key={id}>
                                                <td>
                                                    <button data-dismiss="modal"
                                                        className="btn modal-button"
                                                        onClick={this.props.buttonClick}
                                                        value={JSON.stringify([s_address, s_latitude, s_longitude])}
                                                    >{s_address}</button>
                                                </td>
                                                <td>{s_latitude}</td>
                                                <td>{s_longitude}</td>
                                            </tr>
                                        ))
                                    }
                                </tbody>
                            </table>
                        </div>
                        <div className="modal-footer row no-margin">
                            <button type="button" className="btn btn-default incoming-btn" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
};

class DispatcherRequest extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            data: [],
            user : {
                first_name : '',
                last_name : '',
                email : '',
                mobile : ''
            },
            modal_show : false,
            s_address: '',
            d_address: '',
            directions : [],
            loadCount: 0,
            isLoading: false
        };
        this.getUserInfoByMobile = this.getUserInfoByMobile.bind(this);
        this.showModal = this.showModal.bind(this);
        this.canSubmit = this.canSubmit.bind(this);
        this.changeAddress = this.changeAddress.bind(this);
        this.initStates = this.initStates.bind(this);
        this.getServiceData = this.getServiceData.bind(this);
    }

    changeAddress = (event) => {
        const {name, value} = event.target;
        console.log('name + value = ', name, value);
        this.setState({
            [name]: value
        });
    }

    getServiceData() {
        $.get('/admin/service', function(result) {
            this.setState({
                data: result
            });
        }.bind(this));
    }

    componentDidMount() {
        // Auto Assign Switch
        new Switchery(document.getElementById('provider_auto_assign'));
        
        // Schedule Time Datepicker
        $('#schedule_time').datetimepicker({
            minDate: window.Tranxit.minDate,
            maxDate: window.Tranxit.maxDate,
        });

        // Get Service Type List
        this.getServiceData();

        // Mount Ride Create Map
        window.createRideInitialize();

        function stopRKey(evt) { 
            var evt = (evt) ? evt : ((event) ? event : null); 
            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
            if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
        } 

        document.onkeypress = stopRKey; 
    }

    initStates = () => {
        this.setState({
            data: [],
            user : {
                first_name : '',
                last_name : '',
                email : '',
                mobile : ''
            },
            s_address: '',
            d_address: '',
            directions : [],
            isLoading: false
        });
     /*   $('#s_address').val('');
        $('#d_address').val('');*/
        /*$('#references').val('');
        $('#schedule_time').val(this.currentDate());
        $('#s_latitude').val('');
        $('#d_latitude').val('');
        $('#s_longitude').val('');
        $('#d_longitude').val('');
        $('#distance').val('');*/
        
      

       /* window.Tranxit.map = true;
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 0, lng: 0},
            zoom: 2,
        });

        map.clear(); */
        
       /* directionsDisplay.setMap(null);
        directionsDisplay.setMap(map);*/

        //mapMarkers = [];
       /*   toastr.options = { 
            //primeras opciones
            "closeButton": false, //boton cerrar
            "debug": false,
            "newestOnTop": false, //notificaciones mas nuevas van en la parte superior
            "progressBar": true, //barra de progreso hasta que se oculta la notificacion
            "preventDuplicates": false, //para prevenir mensajes duplicados
            
            "onclick": null,
            
            //Posición de la notificación
            //toast-bottom-left, toast-bottom-right, toast-bottom-left, toast-top-full-width, toast-top-center
            "positionClass": "toast-top-right",
                    
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "tapToDismiss": false
        };*/

        this.getServiceData();
        window.createRideInitialize();
        
  
      
        destination=undefined;
        origin=undefined;
        
      
        document.getElementById("mobile").focus();

    }

    createRide(event) {
        console.log(event);
        event.preventDefault();
        event.stopPropagation();
        console.log('version_005', $("#form-create-ride").serialize());
       /* $('#s_address').val('');
        $('#d_address').val('');*/
       // $('#references').val('');
     //   $('#schedule_time').val(this.currentDate());
       // 

        document.getElementById("mobile").focus();
        this.initStates();
        $.ajax({
            url: '/admin/dispatcher',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': window.Laravel.csrfToken },
            type: 'POST',
            data: $("#form-create-ride").serialize(),
            success: function(data) {
                if(typeof data.message !== 'undefined') {

                    if(data.message=='PEDIDO ENVIADO'){
                        console.log("entro 001");
                        $('.container-fluid').first().before('<div class="alert alert-success  notification"><button type="button" class="close" data-dismiss="alert">×</button><p style="margin-top:10px;">'+data.message+'</p></div>');
                        setTimeout(function() { $('.notification').fadeOut('fast', 'linear', function() { $('.notification').delay(5000).remove(); }); }, 5000);
                    }
                    else{
                        console.log("entro 002");
                        $('.container-fluid').first().before('<div class="alert alert-danger notification"><button type="button" class="close" data-dismiss="alert">×</button><p style="margin-top:10px;">'+data.message+'</p></div>');
                        setTimeout(function() { $('.notification').fadeOut('fast', 'linear', function() { $('.notification').delay(5000).remove(); }); }, 5000);
                    }
                    
                
                }
                console.log('Accept', data);
                // this.props.completed(data);
                // this.initStates();
            }.bind(this),
            fail: function(err) {
                console.log(err);
                // this.initStates();
            }
        });
    }

    cancelCreate() {
        this.props.cancel(true);
    }

    getUserInfoByMobile(mobile) {
        fetch(`/admin/dispatcher/user_by_mobile?mobile=${encodeURIComponent(mobile)}`)
        .then(res => res.json())
        .then(res => {
            if(res.user != null) {
                this.setState(prevState => ({
                    user: {
                        first_name: res.user.first_name,
                        last_name: res.user.last_name,
                        email: res.user.email,
                        mobile: res.user.mobile
                    },
                    directions: res.directions
                }), () => {
                    this.showModal();
                });
            }
            else {
               /* $('#s_address').val('');
                $('#d_address').val('');
                $('#references').val('');
                $('#schedule_time').val(this.currentDate());*/

                   $('#s_address').val('');
                    $('#d_address').val('');
                    $('#references').val('');
                    $('#preciocentral').val('');
                    $('#schedule_time').val(this.currentDate());
                    $('#s_latitude').val('');
                    $('#d_latitude').val('');
                    $('#s_longitude').val('');
                    $('#d_longitude').val('');
                    $('#distance').val('');

                const email = this.state.user.mobile ? `${this.state.user.mobile}@gmail.com` : '';


                this.setState(prevState => ({
                    user: {
                        ...prevState,
                        first_name: '',
                        last_name: '',
                        email: email
                        
                    }
                }));
              
            }
        });
    }

    showModal = () => {
        this.setState({loadCount: this.state.loadCount + 1});
        this.setState({modal_show: true});
    }

    fillUserInfo = event => {
        event.preventDefault();
        const {value, name} = event.target;
        this.setState(prevState => ({
            user : {
                ...prevState.user,
                [name]: value
            }
        }));
        if(name == 'mobile') {
            this.getUserInfoByMobile(value);
        }
    }

    currentDate() {
        var d = new Date(),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear(),
            h = d.getHours(), mm = d.getMinutes();
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        return (`${year}/${month}/${day} ${h}:${mm}`);
    }

    setDirectionAddress = (event) => {
        const values = JSON.parse(event.target.value);
        $('#s_address').val(values[0]);
        $('#s_latitude').val(values[1]);
        $('#s_longitude').val(values[2]);
        $('#s_address').keypress();
        $('#s_address').keyup();
        $('#s_address').keydown();
        $('#s_address').click();
        $('#s_address').focus();
    }

    enterKeyPress(event) {
        if(event.keyCode == 13) {
            event.preventDefault();
            this.fillUserInfo(event);
            first_name.focus();
        }
    }

    canSubmit = () => {
        let result = false;
        //if(this.state.user.first_name == null || this.state.user.first_name == '') result = true;
        //if(this.state.user.last_name == null || this.state.user.last_name == '') result = true;
        //if(this.state.user.email == null || this.state.user.email == '') result = true;
        //if(this.state.user.mobile == null || this.state.user.mobile == '') result = true;
        //if(this.state.isLoading) result = true;
     
        return result;
    }

    render() {
        return (
            <div className="card card-block" id="create-ride">
                <div className={`spinner-border ${this.state.isLoading ? 'hide' : ''}`}></div>
                <h3 className="card-title text-uppercase">Detalles del Viaje</h3>
                <form id="form-create-ride" onSubmit={this.createRide.bind(this)} method="POST">
                    <div className="row">
                        <div className="col-xs-6">
                            <div className="form-group">
                                <label htmlFor="mobile">Celular</label>
                                <input type="text" className="form-control numbers" name="mobile" id="mobile" placeholder="Phone"
                                    value={this.state.user.mobile}
                                    onKeyUp={this.enterKeyPress.bind(this)}
                                    onChange={this.fillUserInfo}
                                    required
                                />
                            </div>
                        </div>
                        <div className="col-xs-6">
                            <div className="form-group">
                                <label htmlFor="email">Email</label>
                                <input type="email" className="form-control" name="email" id="email" placeholder="Email"
                                    value={this.state.user.email}
                                    onChange={this.fillUserInfo}
                                    required
                                />
                            </div>
                        </div>

                        <div className="col-xs-6">
                            <div className="form-group">
                                <label htmlFor="first_name">Primer Nombre</label>
                                <input type="text" className="form-control" name="first_name" id="first_name" placeholder="First Name"
                                    value={this.state.user.first_name}
                                    onChange={this.fillUserInfo}
                                    required
                                />
                            </div>
                        </div>
                        <div className="col-xs-6">
                            <div className="form-group">
                                <label htmlFor="last_name">Segundo Nombre</label>
                                <input type="text" className="form-control" name="last_name" id="last_name" placeholder="Last Name"
                                    value={this.state.user.last_name}
                                    onChange={this.fillUserInfo}
                                    required
                                />
                            </div>
                        </div>
                        <div className="col-xs-6">
                        <div className="form-group">
                                <label htmlFor="s_address">Dirección Origen</label>
                                <input type="text"
                                    name="s_address"
                                    className="form-control"
                                    id="s_address"
                                    placeholder="Pickup Address"
                                    required></input>

                                <input type="hidden" name="s_latitude" id="s_latitude"></input>
                                <input type="hidden" name="s_longitude" id="s_longitude"></input>
                            </div>
                        </div>


                        <div className="col-xs-6">
                        <div className="form-group">
                                <label htmlFor="d_address">Dirección Destino</label>
                                
                                <input type="text" 
                                    name="d_address"
                                    className="form-control"
                                    id="d_address"
                                    placeholder="Dropoff Address"
                                    required></input>

                                <input type="hidden" name="d_latitude" id="d_latitude"></input>
                                <input type="hidden" name="d_longitude" id="d_longitude"></input>
                                <input type="hidden" name="distance" id="distance"></input>
                            </div>
                        </div>



                        <div className="col-xs-6">
                        <div className="form-group">
                                <label htmlFor="references">Referencias</label>
                                <input type="text" className="form-control" name="references" id="references" placeholder="Referencias" required />
                            </div>
                        </div>
                        <div className="col-xs-6">
                        <div className="form-group">
                                <label htmlFor="preciocentral">Precio Sugerido</label>
                                <input type="tel"  className="form-control" name="preciocentral" id="preciocentral" placeholder="Precio Sugerido" required  />
                            </div>
                        </div>



                        <div className="col-xs-6">
                        <div className="form-group">
                                <label htmlFor="schedule_time">Tiempo programado</label>
                                <input type="text" className="form-control" name="schedule_time" id="schedule_time"
                                    placeholder="Date"
                                    defaultValue={this.currentDate()}
                                />
                            </div>
                        </div>



                        <div className="col-xs-6">
     
                        <div className="form-group">
                                <label htmlFor="service_types">Tipo Servicio</label>
                                <ServiceTypes data={this.state.data} />
                            </div>
                        </div>


                        <div className="col-xs-6">
                        <div className="form-group">
                                <label htmlFor="estimated" className="estimate_amount">Cantidad estimada :  <span id="estimated" name="estimated">S/.0</span></label>
                            </div>
                        </div>

                        <div className="col-xs-6">
                        <div className="form-group">
                                <label htmlFor="provider_auto_assign">Chofer Asignado automático</label>
                                <br />
                                <input type="checkbox" id="provider_auto_assign" name="provider_auto_assign" className="js-switch" data-color="#f59345" defaultChecked />
                            </div>
                        </div>


                        



                    </div>
                    <div className="row">
                        <div className="col-xs-6">
                            <button type="button" className="btn btn-lg btn-danger btn-block waves-effect waves-light" onClick={this.cancelCreate.bind(this)}>
                                CANCELAR
                            </button>
                        </div>
                       <div className="col-xs-6">
                            <button id="showbtn-isright" className="btn btn-lg btn-success btn-block waves-effect waves-light" 
                                disabled={this.canSubmit()}
                            >ENVIAR</button>
                        </div>
                    </div>
                </form>

                <Modal directions={this.state.directions}
                    loadCount={this.state.loadCount}
                    show={this.state.modal_show}
                    buttonClick={this.setDirectionAddress.bind(this)}
                />
            </div>
        );
    }
};

class DispatcherAssignList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            data: {
                data: []
            }
        };
    }

    componentDidMount() {
        $.get('/admin/dispatcher/providers', { 
            service_type: this.props.trip.service_type_id,
            latitude: this.props.trip.s_latitude,
            longitude: this.props.trip.s_longitude
        }, function(result) {
            console.log('Providers', result);
            if(result) {
                result['data']=result;
                this.setState({
                    data: result
                });
                window.assignProviderShow(result.data, this.props.trip);
            } else {
                this.setState({
                    data: {
                        data: []
                    }
                });
                window.providerMarkersClear();
            }
        }.bind(this));
    }

    render() {
        console.log('DispatcherAssignList - render', this.state.data);
        return (
            <div className="card">
                <div className="card-header text-uppercase"><b>Asignar Chofer</b></div>
                
                <DispatcherAssignListItem data={this.state.data.data} trip={this.props.trip} />
            </div>
        );
    }
}

class DispatcherAssignListItem extends React.Component {
    handleClick(provider) {
        // this.props.clicked(trip)
        console.log('Provider Clicked');
        window.assignProviderPopPicked(provider);
    }
    render() {
        var listItem = function(provider) {
            return (
                    <div className="il-item" key={provider.id} onClick={this.handleClick.bind(this, provider)}>
                        <a className="text-black" href="#">
                            <div className="media">
                                <div className="media-body">
                                    <p className="mb-0-5">{provider.first_name} {provider.last_name}</p>
                                    <h6 className="media-heading">Rating: {provider.rating}</h6>
                                    <h6 className="media-heading">Celular: {provider.mobile}</h6>
                                    <h6 className="media-heading">Tipo: {provider.service.service_type.name}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                );
        }.bind(this);

        return (
            <div className="items-list">
                {this.props.data.map(listItem)}
            </div>
        );
    }
}

class ServiceTypes extends React.Component {
    render() {
        // console.log('ServiceTypes', this.props.data);
        var mySelectOptions = function(result) {
            return <ServiceTypesOption
                    key={result.id}
                    id={result.id}
                    name={result.name} />
        };
        return (
                <select 
                    name="service_type"
                    className="form-control" id="service_type">
                    {this.props.data.map(mySelectOptions)}
                </select>
            )
    }
}

class ServiceTypesOption extends React.Component {
    render() {
        return (
            <option value={this.props.id}>{this.props.name}</option>
        );
    }
};

class DispatcherMap extends React.Component {
    render() {
        return (
            <div className="card my-card">
                <div className="card-header text-uppercase">
                    <b>MAPA</b>
                </div>
                <div className="card-body">
                    <div id="map" style={{ height: '450px'}}></div>
                </div>
            </div>
        );
    }
}

ReactDOM.render(
    <DispatcherPanel />,
    document.getElementById('dispatcher-panel')
);