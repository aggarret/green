var geocoder;
var s_data = [];
var total_address = "";

function geocode() {
    //event listener on form.  when submit is clicked, do something
    $('#event_create').on('submit',function(e){
        
        //prevent submit button from submitting form to PHP
        e.preventDefault();

        //capture form into array
         s_data = $(this).serializeArray();
        
        //convert array to object
        var out = {};
        for(var i = 0; i<s_data.length; i++){
            var record = s_data[i];
            out[record.name] = record.value;
        }

        //capture values from object to geolocate
        var address_street = out.address_street;
        var address_zip = out.address_zip;
        total_address = address_street + ',' + address_zip;
        
        //geolocate address
        geocoder = new google.maps.Geocoder();
        locate(total_address);
    });
}

function locate(address_to_find)
{
    geocoder.geocode({'address': address_to_find.toString()}, function(results, status) {
        if (status == 'OK') {
            var lat = results[0].geometry.location.lat();
            var lng = results[0].geometry.location.lng();

            var city = results[0].address_components[3].long_name;
            var county = results[0].address_components[4].long_name;

            //Push lat&lng to the object array
            s_data.push({name: 'lat', value: lat});
            s_data.push({name: 'lng', value: lng});
            s_data.push({name: 'google_city', value: city});
            s_data.push({name: 'google_county', value: county});

            callAjax();
        }
        else {
            alert('Could not locate the address.  Please try a different address.');
        }
    });
}

function callAjax()
{
    //serialize the ajax so that laravel can use request in the same fashion
    $.ajax({
        type:"POST",
        url: ajax_url,
        traditional: true,
        data: s_data,
        dataType: 'json',
        success: function(data){
            console.log('Everything was a success!');
            //redirection
            window.location.href = redirect_url;
        },
        error: function(data){
            console.log(data);
        }
    });
}