// Initialize OSM
var map;
var marker;
var currentMarker;
var destinationMarker;
var routingControl;

function initializeMap(latitude, longitude, imageFile) {
    if (!map) {
        // Inisialisasi peta hanya sekali
        map = L.map('map').setView([latitude, longitude], 17);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
            maxZoom: 20,
            minZoom: 8,
        }).addTo(map);

        // Tambahkan marker awal
        marker = L.marker([latitude, longitude]).addTo(map);

        marker.setLatLng([latitude, longitude]).bindPopup(
            `
            <img src="${imageFile}" class="object-fit-cover w-100 h-100" width="150px" height="150px"><br>
            <button class="btn-primary w-100 mt-3" type="button" onclick="routeFromCurrentLocation(${latitude}, ${longitude}, '${imageFile}')"><i class="las la-directions"></i> GET DIRECTION</button>
            `
        ).openPopup();
    } else {
        // Update koordinat jika peta sudah diinisialisasi
        updateMap(latitude, longitude, imageFile);
    }
}

function updateMap(latitude, longitude, imageFile) {
    if (map && marker) {
        // Pindahkan peta ke lokasi baru
        map.setView([latitude, longitude], 17);

        if (routingControl) {
            map.removeControl(routingControl);
        }

        currentMarker ? currentMarker.remove() : null;
        destinationMarker ? destinationMarker.remove() : null;

        // Pindahkan marker ke lokasi baru
        marker.setLatLng([latitude, longitude]).bindPopup(
            `
            <img src="${imageFile}" class="object-fit-cover w-100 h-100" width="150px" height="150px"><br>
            <button class="btn-primary w-100 mt-3" type="button" onclick="routeFromCurrentLocation(${latitude}, ${longitude}, '${imageFile}')"><i class="las la-directions"></i> GET DIRECTION</button>
            `
        ).openPopup();
    } else {
        console.error('Peta atau marker belum diinisialisasi.');
    }
}

function routeFromCurrentLocation(destLatitude, destLongitude, imageFile) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                var currentLocation = L.latLng(position.coords.latitude, position.coords.longitude);
                var destination = L.latLng(destLatitude, destLongitude);

                const yourLocationIcon = L.icon({
                    iconUrl: 'https://cdn-icons-png.flaticon.com/512/12207/12207498.png',
                    iconSize: [50, 50],
                    iconAnchor: [25, 50],
                    popupAnchor: [0, -50]
                });

                currentMarker = L.marker(currentLocation, { icon: yourLocationIcon }).addTo(map).bindPopup('Your Location').openPopup();

                destinationMarker = L.marker(destination).addTo(map).bindPopup(
                    `
                    <img src="${imageFile}" class="object-fit-cover w-100 h-100" width="150px" height="150px"><br>
                    <button class="btn-danger w-100 mt-3" type="button" onclick="initializeMap(${destLatitude}, ${destLongitude}, '${imageFile}')"><i class="las la-close"></i> EXIT DIRECTION</button>
                    `
                ).openPopup();

                routingControl = L.Routing.control({
                    waypoints: [
                        currentLocation,
                        destination
                    ],
                    draggableWaypoints: false,
                    routeWhileDragging: false,
                    showAlternatives: false,
                    addWaypoints: false,
                    deleteWaypoints: false,
                    createMarker: function() {
                        return null;
                    },
                    collapsible: true,
                }).addTo(map);

                map.fitBounds([
                    [currentLocation.lat, currentLocation.lng],
                    [destination.lat, destination.lng]
                ]);
            },
            function (error) {
                console.error("Error mendapatkan lokasi: ", error);
                alert("Gagal mendapatkan lokasi. Pastikan GPS diaktifkan.");
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    } else {
        alert("Geolocation tidak didukung di browser Anda.");
    }
}