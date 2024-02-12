<div class="remodal remodal-lg" data-remodal-id="add-address-modal-fields-with-map"
    data-remodal-options="hashTracking: false">
    <div class="remodal-header">
        <button id="closeAddressModal" data-remodal-action="close" class="remodal-close"></button>
        <div class="remodal-title">افزودن آدرس جدید</div>
    </div>
    <div class="remodal-content">
        <div class="row">

            <div class="col-md-12 mb-md-0 mb-4" id="step1-add-address">
                <!-- start of add-address-form -->
            
                <div class="row">
                    <!-- start of form-element -->
                        <div class="form-element-row mb-3">
                            <label class="label fs-7">نام آدرس</label>
                            <input id="name" type="text" class="form-control" placeholder="نام">
                        </div>

                    <div class="col-lg-6 mb-3">
                        <!-- start of form-element -->
                        <div class="form-element-row">
                            <label class="label fs-7">نام گیرنده</label>
                            <input id="recv_name" type="text" class="form-control" placeholder="نام">
                        </div>
                        <!-- end of form-element -->
                    </div>
                    <div class="col-lg-6 mb-3">
                        <!-- start of form-element -->
                        <div class="form-element-row">
                            <label class="label fs-7">نام خانوادگی گیرنده</label>
                            <input id="lastName" type="text" class="form-control" placeholder="نام خانوادگی">
                        </div>
                        <!-- end of form-element -->
                    </div>
                    <div class="col-lg-6 mb-3">
                        <!-- start of form-element -->
                        <div class="form-element-row">
                            <label class="label fs-7">استان</label>
                            
                            <select onchange="getCities($(this).val())" class="select2" name="state02" id="state02">
                                <option value="0">انتخاب کنید</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- end of form-element -->
                    </div>
                    <div class="col-lg-6 mb-3">
                        <!-- start of form-element -->
                        <div class="form-element-row">
                            <div class="form-element-row">
                                <label class="label fs-7">شهر</label>
                                <select class="select2" name="city02" id="city02">
                                </select>
                            </div>
                        </div>
                        <!-- end of form-element -->
                    </div>
                    <div class="col-lg-6 mb-3">
                        <!-- start of form-element -->
                        <div class="form-element-row">
                            <label class="label fs-7">شماره موبایل</label>
                            <input onkeypress="return isNumber(event)" minlength="8" maxlength="11" id="phone" type="text" class="form-control" placeholder="مثال: ۰۹۱۲۳۴۵۶۷۸۹">
                        </div>
                        <!-- end of form-element -->
                    </div>
                    <div class="col-lg-6 mb-3">
                        <!-- start of form-element -->
                        <div class="form-element-row">
                            <label  class="label fs-7">کدپستی</label>
                            <input onkeypress="return isNumber(event)" minlength="10" maxlength="10" id="postalCode" type="text" class="form-control"
                                placeholder="کدپستی باید ۱۰ رقم و بدون خط تیره باشد">
                        </div>
                        <!-- end of form-element -->
                    </div>
                    <div class="col-12 mb-3">
                        <!-- start of form-element -->
                        <div class="form-element-row">
                            <label  class="label fs-7">آدرس</label>
                            <textarea id="fullAddress" rows="5" class="form-control" placeholder="آدرس کامل"></textarea>
                        </div>
                        <!-- end of form-element -->
                    </div>
                </div>
            
                <!-- end of add-address-form -->
            </div>

            <div class="col-md-12 mb-md-0 mb-4 hidden" id="step2-add-address">
                <div id="map" style="width: 100%; height: 500px">نقشه</div>
            </div>

        </div>
    </div>
    <div class="remodal-footer">
        <button id="backBtnInAddressModal" class="btn btn-sm btn-outline-light px-3 me-2">بازگشت</button>
        <button id="submitAddress" class="btn btn-sm btn-primary px-3">ثبت</button>
    </div>
</div>

<script src="https://cdn.parsimap.ir/third-party/mapbox-gl-js/plugins/parsimap-geocoder/v1.0.0/parsimap-geocoder.js"></script>
<link
  href="https://cdn.parsimap.ir/third-party/mapbox-gl-js/plugins/parsimap-geocoder/v1.0.0/parsimap-geocoder.css"
  rel="stylesheet"
/>

    <script>

        function emptyFields() {
            $("#recv_name").val('');
            $("#lastName").val('');
            $("#name").val('');
            $("#postalCode").val('');
            $("#fullAddress").val('');
            $("#phone").val('');
            $("#state02").val('');
            $("#city02").val('');
            $("#x").val('');
            $("#y").val('');
            mode = 'create';
            step = 0;

        }

        function getCities(stateId, selectedCity=undefined) {

            if(stateId == 0) {
                $("#city02").empty();
                return;
            }
            $.ajax({
                type: 'get',
                url: '{{ route('api.cities') }}',
                data: {
                    state_id: stateId
                },
                success: function(res) {

                    if(res.status !== 'ok') {
                        $("#city02").empty();
                        return;
                    }

                    let html = '<option value="0">انتخاب کنید</option>';
                    res.data.forEach(elem => {
                        
                        if(selectedCity !== undefined && elem.id === selectedCity)
                            html += '<option selected value="' + elem.id + '">' + elem.name + '</option>';
                        else
                            html += '<option value="' + elem.id + '">' + elem.name + '</option>';
                    });
                    
                    $("#city02").empty().append(html);
                }
            })

        }

        let recv_name;
        let lastName;
        let phone;
        let name;
        let address;
        let postalCode;
        let cityId;

        $(document).ready(function() {

            $("#submitAddress").on('click', function() {

                if(step === 0) {

                    recv_name = $('#recv_name').val();
                    lastName = $('#lastName').val();
                    phone = $('#phone').val();
                    name = $('#name').val();
                    address = $('#fullAddress').val();
                    postalCode = $('#postalCode').val();
                    cityId = $("#city02").val();

                    if(postalCode.length === 0) {
                        showErr('لطفا کدپستی موردنظر خود را وارد نمایید.');
                        return;
                    }

                    step = 1;

                    // $.ajax({
                    //     type: 'get',
                    //     url: 'https://api.parsimap.ir/parcel/unit?key=p147e61e68fa364653b4710fdecd3d6cf55e40b00d&postcode=' + postalCode,
                    //     success: function(res) {

                    //         console.log(res);

                    //     }
                    // });

                    

                    $("#step1-add-address").addClass('hidden');
                    $("#step2-add-address").removeClass('hidden');
                    
                    mapboxgl.setRTLTextPlugin(
                        'https://cdn.parsimap.ir/third-party/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.2.3/mapbox-gl-rtl-text.js',
                        null,
                    );

                    const map = new mapboxgl.Map({
                        container: 'map',
                        style: 'https://api.parsimap.ir/styles/parsimap-streets-v11?key=p1c7661f1a3a684079872cbca20c1fb8477a83a92f',
                        center: x !== undefined && y !== undefined ? [y, x] : [51.4, 35.7],
                        zoom: 13,
                    });

                    var marker = undefined;

                    if(x !== undefined && y !== undefined) {
                        marker = new mapboxgl.Marker();
                        marker.setLngLat({lng: y, lat: x}).addTo(map);
                    }

                    function addMarker(e){
                        
                        if (marker !== undefined)
                            marker.remove();
                        
                        //add marker
                        marker = new mapboxgl.Marker();
                        marker.setLngLat(e.lngLat).addTo(map);

                        x = e.lngLat.lat;
                        y = e.lngLat.lng;
                    }

                    map.on('click', addMarker);
                    const control = new ParsimapGeocoder();
                    map.addControl(control);

                    return;
                }

                if(x === undefined || y === undefined) {
                    showErr("لطفا مکان موردنظر خود را از روی نقضه انتخاب کنید");
                    return;
                }

                $.ajax({
                    type: 'post',
                    url: mode === 'create' ? '{{ route('address.store') }}' : '{{ route('address.update') }}' + '/' + selectedAddrId,
                    data: {
                        x: x,
                        y: y,
                        name: name,
                        postal_code: postalCode,
                        address: address,
                        recv_name: recv_name,
                        recv_last_name: lastName,
                        recv_phone: phone,
                        city_id: cityId,
                    },
                    success: function(res) {
                        if(res.status === "ok") {
                            $('#closeAddressModal').click();
                            location.reload(true);
                        }
                        else
                            showErr(res.msg);
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        
                        var errs = XMLHttpRequest.responseJSON.errors;

                        if(errs instanceof Object) {
                            var errsText = '';

                            Object.keys(errs).forEach(function(key) {
                                errsText += key + " : " + errs[key];
                            });
                            showErr(errsText);    
                        }
                        else {
                            var errsText = '';

                            for(let i = 0; i < errs.length; i++)
                                errsText += errs[i].value;
                            
                            showErr(errsText);
                        }
                    }
                });
            });
        });


        $("#backBtnInAddressModal").on('click', function() {
            
            if(step === 0) {
                $('#closeAddressModal').click();
                return;
            }
            
            step = 0;

            $("#step1-add-address").removeClass('hidden');
            $("#step2-add-address").addClass('hidden');
        })

    </script>