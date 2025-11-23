<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Report an Issue</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #reportMap { width:100%; height:260px; border-radius:8px; margin-top:12px; background:#071028; }
        .map-preview { margin-top:8px; color:var(--muted-2); font-size:13px; }
        .map-preview strong { color:#fff; }
        .previewRow { display:block; margin-top:8px; }
        input[type="file"] { color:var(--muted-2); background:rgba(255,255,255,0.02); padding:8px;border-radius:8px;border:1px solid rgba(255,255,255,0.04); }
        .map-error { color:#fff; padding:18px; text-align:center; background:linear-gradient(180deg,#071028,#041226); border-radius:8px; }
        .btn{ padding:8px 12px; border-radius:8px; cursor:pointer; }
        .submit-btn{ display:inline-block; background:linear-gradient(90deg,#1fb6ff,#0066ff); color:#fff; border:0; padding:10px 16px; border-radius:10px; font-weight:600; cursor:pointer; box-shadow:0 6px 18px rgba(3,10,30,0.35); transition:transform .12s ease,opacity .12s; }
        .submit-btn:hover{ transform:translateY(-3px); opacity:0.95; }
        .form-actions{ display:flex; gap:12px; align-items:center; margin-top:14px; flex-wrap:wrap; }
    </style>
</head>
<body>

<header>
    <h1>CityCare</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="issues.php">View Issues</a>
        <a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>)</a>
    </nav>
</header>

<div class="container">
    <h2>Report an Issue</h2>

    <form id="reportForm" action="submit_report.php" method="POST" enctype="multipart/form-data">
        <label>Title:</label>
        <input type="text" name="title" placeholder="Enter issue title" required>

        <label>Description:</label>
        <textarea name="description" placeholder="Describe the issue" required></textarea>

        <label>Category:</label>
        <select name="category" required>
            <option>Pothole</option>
            <option>Broken Light</option>
            <option>Trash</option>
            <option>Road Damage</option>
            <option>Other</option>
        </select>

        <label>Location (address or place):</label>
        <input type="text" name="location" id="location" placeholder="Enter location" required>

        <div style="margin-top:8px;">
            <small style="color:rgba(255,255,255,0.75);">Click on the map to place a marker. Drag marker to adjust.</small>
        </div>

        <div id="reportMap" aria-label="Report location map"></div>

        <div class="previewRow">
            <div class="map-preview" id="mapPreviewLine">No marker set. Click map to set location.</div>
        </div>

        <input type="hidden" name="lat" id="lat">
        <input type="hidden" name="lng" id="lng">

        <label>Photo (optional):</label>
        <input type="file" name="photo" accept="image/*">

        <div class="form-actions">
            <button type="submit" class="submit-btn">Submit Issue</button>
            <button type="button" class="btn" onclick="window.location='issues.php'">Cancel</button>
        </div>
    </form>
</div>

<footer>
    &copy; 2025 CityCare
</footer>

<script>
(function(){
    const mapEl = document.getElementById('reportMap');
    const previewLine = document.getElementById('mapPreviewLine');
    const latInput = document.getElementById('lat');
    const lngInput = document.getElementById('lng');

    const CITY_LAT = 40.7128;
    const CITY_LNG = -74.0060;

    // Load Leaflet dynamically
    const lnk = document.createElement('link');
    lnk.rel='stylesheet'; lnk.href='https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
    document.head.appendChild(lnk);

    const scr = document.createElement('script');
    scr.src='https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
    scr.onload = initMap;
    document.body.appendChild(scr);

    let marker=null;

    function updatePreviewText(){
        if(latInput.value && lngInput.value){
            previewLine.innerHTML = 'Marker at <strong>' + parseFloat(latInput.value).toFixed(6) + ', ' + parseFloat(lngInput.value).toFixed(6) + '</strong>';
        } else previewLine.textContent = 'No marker set. Click map to set location.';
    }

    function placeMarker(lat,lng){
        if(marker){
            marker.setLatLng([lat,lng]);
        } else {
            marker = L.marker([lat,lng],{draggable:true}).addTo(map);
            marker.on('dragend',function(e){
                const p = e.target.getLatLng();
                latInput.value = p.lat;
                lngInput.value = p.lng;
                updatePreviewText();
            });
        }
        map.setView([lat,lng],16);
        latInput.value = lat;
        lngInput.value = lng;
        updatePreviewText();
    }

    let map;
    function initMap(){
        map = L.map(mapEl).setView([CITY_LAT,CITY_LNG],13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'&copy; OpenStreetMap contributors'}).addTo(map);

        map.on('click', function(e){
            placeMarker(e.latlng.lat, e.latlng.lng);
        });

        // load existing coords if any (rarely needed)
        if(latInput.value && lngInput.value){
            placeMarker(parseFloat(latInput.value), parseFloat(lngInput.value));
        } else updatePreviewText();

        setTimeout(()=>{ map.invalidateSize(); },200);
    }
})();
</script>

</body>
</html>
