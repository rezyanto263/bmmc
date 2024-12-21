<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rumah Sakit</title>
    <link
      rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
    />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <style>
      #map {
        height: 100vh; /* Tinggi peta */
        width: 100%; /* Lebar peta */
      }
    </style>

    <link rel="stylesheet" href="./style.css" />
  </head>

  <body>
    <div id="map" style="margin-top: 65px"></div>

    <script>
      // Inisialisasi peta
      const map = L.map("map").setView([-8.65, 115.2], 10.5); // Pusat peta di Bali

      // Tambahkan tile dari OpenStreetMap
      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
        attribution:
          '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      }).addTo(map);

      // URL Overpass API dengan query untuk rumah sakit
      const overpassUrl =
        'https://overpass-api.de/api/interpreter?data=[out:json];node["amenity"="hospital"](around:90000,-8.65,115.2);out;';

      // Ambil data dari Overpass API
      console.log(overpassUrl);
      fetch(overpassUrl)
        .then((response) => response.json())
        .then((data) => {
          // Menambahkan marker untuk setiap rumah sakit
          data.elements.forEach((element) => {
            if (element.lat && element.lon && element.tags.name) {
              L.marker([element.lat, element.lon]).addTo(map).bindPopup(`
                    <b>${element.tags.name}</b>
                `); // Menampilkan nama rumah sakit di popup
            }
          });
        })
        .catch((error) =>
          console.error("Error fetching Overpass data:", error)
        );
    </script>

    <!-- CDN JAVASCRIPT BOOTSTRAP -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
