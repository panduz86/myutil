/*
Gestione combo regioni-province-comuni
@version 16.0.0
*/

function getRegioni(country_code,destinazione){
    var url_script = "ajax_script/getRegioni.php";

    $.ajax({
        url : url_script,
        type: 'GET',
        data: {
            nazione: country_code
        },
        success: function (data, textStatus, jqXHR) {
            //window.alert(data);
            $('#'+destinazione).html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            window.alert(errorThrown);
        }
    });
}

function getProvince(region_code,country_code,destinazione){
    var url_script = "ajax_script/getProvince.php";
        
    $.ajax({
        url : url_script,
        type: 'GET',
        data: {
            nazione: country_code,
            regione: region_code
        },
        success: function (data, textStatus, jqXHR) {
            //window.alert(data);
            $('#'+destinazione).html(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            window.alert(errorThrown);
        }
    });
}
