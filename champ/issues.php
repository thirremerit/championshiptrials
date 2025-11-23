<?php
session_start();
include 'db_connect.php'; // your database connection file

// Get filter values from URL
$search   = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$location = $_GET['location'] ?? '';
$status   = $_GET['status'] ?? '';

// Build query dynamically
$query = "SELECT issues.*, users.username as reported_by_name FROM issues 
          LEFT JOIN users ON issues.user_id = users.id
          WHERE 1=1";
if($search)   $query .= " AND (title LIKE '%$search%' OR description LIKE '%$search%')";
if($category) $query .= " AND category='$category'";
if($location) $query .= " AND location LIKE '%$location%'";
if($status)   $query .= " AND status='$status'";

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>CityCare - Issues</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .table-wrapper {
            max-height: 500px;
            overflow-y: auto;
            margin-top: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px 12px;
            text-align: left;
        }
        th {
            position: sticky;
            top: 0;
            background: #1e88e5;
            color: #fff;
            z-index: 2;
        }
        tr:nth-child(even){background: #f2f2f2;}
        .status-pending { background-color: #ffe0b2; }
        .status-inprogress { background-color: #fff59d; }
        .status-resolved { background-color: #c8e6c9; }
        .btn { padding:6px 10px; border-radius:8px; cursor:pointer; background:#1e88e5; color:#fff; border:0; }
        #mapModal{ display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center; padding:20px; }
        #mapModal .panel{ width:100%; max-width:900px; height:70vh; background:#071028; border-radius:10px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,0.6); }
        #mapModal .panel header{ display:flex; justify-content:space-between; align-items:center; padding:10px 14px; background:rgba(255,255,255,0.02); color:#cfd8dc; }
        #previewMap{ width:100%; height:calc(100% - 44px); display:block; }
        #mapModal .closeBtn{ background:transparent; border:1px solid rgba(255,255,255,0.06); color:#cfd8dc; padding:6px 10px; border-radius:8px; cursor:pointer; }
    </style>
</head>
<body>
<header>
    <h1>
        <img src="photos/Hipster_Walking/Hipster_Walking_1.png" alt="Mascot" id="mascot" style="height:40px;">
        CityCare
    </h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="report.php">Report Issue</a>
        <a href="issues.php">View Issues</a>
    </nav>
</header>

<div class="container">
    <h2>Reported Issues</h2>

    <!-- Search / Filter Form -->
    <form method="GET" action="issues.php" class="filter-form">
        <input type="text" name="search" placeholder="Search keyword..." value="<?php echo htmlspecialchars($search); ?>">
        <select name="category">
            <option value="">All Categories</option>
            <option value="Pothole" <?php if($category=='Pothole') echo 'selected'; ?>>Pothole</option>
            <option value="Trash" <?php if($category=='Trash') echo 'selected'; ?>>Trash</option>
            <option value="Broken Light" <?php if($category=='Broken Light') echo 'selected'; ?>>Broken Light</option>
        </select>
        <input type="text" name="location" placeholder="Location..." value="<?php echo htmlspecialchars($location); ?>">
        <select name="status">
            <option value="">All Statuses</option>
            <option value="Pending" <?php if($status=='Pending') echo 'selected'; ?>>Pending</option>
            <option value="In Progress" <?php if($status=='In Progress') echo 'selected'; ?>>In Progress</option>
            <option value="Resolved" <?php if($status=='Resolved') echo 'selected'; ?>>Resolved</option>
        </select>
        <button type="submit" class="btn">Filter</button>
    </form>

    <div class="table-wrapper">
        <table>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Location</th>
                <th>Status</th>
                <th>Reported By</th>
                <th>Map</th>
            </tr>
            <?php while($row = $result->fetch_assoc()):
                $statusVal = $row['status'] ?? 'Unknown';
                $class = ($statusVal == 'Pending') ? 'status-pending' : (($statusVal == 'In Progress') ? 'status-inprogress' : (($statusVal=='Resolved')?'status-resolved':''));
                $lat = isset($row['lat']) && $row['lat'] !== '' ? $row['lat'] : '';
                $lng = isset($row['lng']) && $row['lng'] !== '' ? $row['lng'] : '';
                $locText = !empty($row['location']) ? $row['location'] : '';
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['category']); ?></td>
                <td><?php echo htmlspecialchars($locText); ?></td>
                <td>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'worker'): ?>
                    <form method="POST" action="update_status.php">
                        <input type="hidden" name="issue_id" value="<?php echo $row['id']; ?>">
                        <select name="status" class="<?php echo $class; ?>" onchange="this.form.submit()">
                            <option value="Pending" <?php if($statusVal=='Pending') echo 'selected'; ?>>Pending</option>
                            <option value="In Progress" <?php if($statusVal=='In Progress') echo 'selected'; ?>>In Progress</option>
                            <option value="Resolved" <?php if($statusVal=='Resolved') echo 'selected'; ?>>Resolved</option>
                        </select>
                    </form>
                <?php else: ?>
                    <span class="<?php echo $class; ?>"><?php echo htmlspecialchars($statusVal); ?></span>
                <?php endif; ?>
                </td>
                <td><?php echo !empty($row['reported_by_name']) ? htmlspecialchars($row['reported_by_name']) : 'Unknown'; ?></td>
                <td>
                    <div class="map-actions">
                        <button type="button" class="btn previewBtn"
                            data-lat="<?php echo htmlspecialchars($lat); ?>"
                            data-lng="<?php echo htmlspecialchars($lng); ?>"
                            data-query="<?php echo htmlspecialchars($locText); ?>">
                            Preview
                        </button>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<footer>
    &copy; 2025 CityCare
</footer>

<!-- Modal for map preview -->
<div id="mapModal" role="dialog" aria-hidden="true">
    <div class="panel" role="document">
        <header>
            <div>Map Preview</div>
            <div>
                <button class="closeBtn" id="closeMap">Close</button>
            </div>
        </header>
        <div id="previewMap" aria-hidden="true"></div>
    </div>
</div>

<script>
/* Map preview logic */
(function(){
    const cssCandidates = [
        'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
        'https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css'
    ];
    const jsCandidates = [
        'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
        'https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js'
    ];

    function loadCSS(url){ return new Promise((res,rej)=>{ const l=document.createElement('link'); l.rel='stylesheet'; l.href=url; l.onload=()=>res(url); l.onerror=()=>rej(url); document.head.appendChild(l); }); }
    function loadJS(url){ return new Promise((res,rej)=>{ const s=document.createElement('script'); s.src=url; s.async=true; s.onload=()=>res(url); s.onerror=()=>rej(url); document.body.appendChild(s); }); }

    async function tryLoad(list, loader){
        for(const url of list){
            try { await loader(url); return url; } catch(e){ }
        }
        throw new Error('All candidates failed');
    }

    async function ensureLeaflet(){
        try {
            await tryLoad(cssCandidates, loadCSS);
            await tryLoad(jsCandidates, loadJS);
            return (typeof L !== 'undefined');
        } catch(e){ console.error('Leaflet load failed', e); return false; }
    }

    async function geocode(query){
        const url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query);
        const res = await fetch(url, { headers: { 'Accept-Language': 'en' } });
        if (!res.ok) throw new Error('Geocode request failed');
        return await res.json();
    }

    function buildMap(container, lat, lng){
        container.innerHTML = '';
        const map = L.map(container, { zoomControl: true }).setView([lat,lng], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        L.marker([lat,lng]).addTo(map);
        setTimeout(()=>{ map.invalidateSize(); }, 120);
        return map;
    }

    const previewButtons = document.querySelectorAll('.previewBtn');
    const modal = document.getElementById('mapModal');
    const closeBtn = document.getElementById('closeMap');
    const previewContainer = document.getElementById('previewMap');

    async function showPreview(lat, lng, query){
        const ok = await ensureLeaflet();
        if (!ok) { alert('Map library failed to load.'); return; }
        try {
            if (lat && lng) {
                buildMap(previewContainer, parseFloat(lat), parseFloat(lng));
                modal.style.display = 'flex';
                modal.setAttribute('aria-hidden','false');
            } else if (query) {
                const results = await geocode(query);
                if (results && results.length) {
                    const r = results[0];
                    buildMap(previewContainer, parseFloat(r.lat), parseFloat(r.lon));
                    modal.style.display = 'flex';
                    modal.setAttribute('aria-hidden','false');
                } else { alert('Location not found for preview.'); }
            } else { alert('No location data available for this issue.'); }
        } catch(err){ console.error('Preview failed', err); alert('Map preview failed.'); }
    }

    previewButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const lat = btn.getAttribute('data-lat') || '';
            const lng = btn.getAttribute('data-lng') || '';
            const q = btn.getAttribute('data-query') || '';
            showPreview(lat, lng, q);
        });
    });

    closeBtn.addEventListener('click', () => {
        previewContainer.innerHTML = '';
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden','true');
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            previewContainer.innerHTML = '';
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden','true');
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.style.display === 'flex') {
            previewContainer.innerHTML = '';
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden','true');
        }
    });
})();
</script>

</body>
</html>
