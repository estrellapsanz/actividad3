$(document).ready(function () {

    $('.nav-link').on('click', function (event) {
        event.preventDefault();
        let element = this.getAttribute('href');
        //alert(element)
        $('.tab-pane').removeClass('active');
        $('div' + element).addClass('active');
        $('.nav-link').removeClass('active');
        $(this).addClass('active');

        if (element != '#peticiones-tab')
            $('dataTables_wrapper').hide();
        else
            $('dataTables_wrapper').show();

    })

    $('button.nav-link').on('click', function (event) {
        event.preventDefault();
        let tab = $(this).attr('id');
        let tabla_cargada = $('#tabla-cargada').length > 0;

        if (tab == 'geolocation-tab') {

        } else if (tab == 'peticiones-tab') {

        } else if (tab == 'gestion-tab') {
        }

        //document.getElementById('resetear_peticion').value = -1;
        //document.getElementById('resetear').submit();
        //console.log($('table'));
        //$('table', 'p', 'ul').remove();

    })


});


if ("geolocation" in navigator) {
    /* geolocation is available */
    //alert('Geolocalizable');
    navigator.geolocation.getCurrentPosition(success, error);
} else {
    /* geolocation IS NOT available */
    alert('NO Geolocalizable');
}

const options = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0,
};

function success(pos) {
    const crd = pos.coords;
    /*console.log("Your current position is:");
    console.log(`Latitude : ${crd.latitude}`);
    console.log(`Longitude: ${crd.longitude}`);
    console.log(`More or less ${crd.accuracy} meters.`);*/
    let latitude = document.getElementById("latitude");
    let longitude = document.getElementById("longitude");
    let accuracy = document.getElementById("accuracy");
    latitude.textContent = `Latitude : ${crd.latitude}`;
    longitude.textContent = `Longitude : ${crd.longitude}`;
    accuracy.textContent = `More or less ${crd.accuracy} meters.`;
}

function error(err) {
    console.log(`ERROR(${err.code}): ${err.message}`);
}

navigator.geolocation.getCurrentPosition(success, error, options);