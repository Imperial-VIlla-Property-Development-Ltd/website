@extends('layouts.dashboard')
@section('page_title','Client Live Map')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<style>
    .map-wrapper {
        background: #0b0f24;
        padding: 25px;
        border-radius: 18px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.45);
        border: 1px solid rgba(255,255,255,0.08);
    }

    #map {
        height: 720px;
        border-radius: 16px;
        box-shadow: 0 0 25px rgba(0,153,255,0.35);
    }

    /* Clean header for map */
    .map-title {
        font-size: 30px;
        font-weight: 700;
        color: white;
        margin-bottom: 18px;
    }

    /* Color dot indicators */
    .dot-red, .dot-blue, .dot-green {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(255,255,255,0.6);
    }
    .dot-red { background: #ff3b3b; box-shadow: 0 0 18px #ff3b3b; }
    .dot-blue { background: #3b82f6; box-shadow: 0 0 18px #3b82f6; }
    .dot-green { background: #22c55e; box-shadow: 0 0 18px #22c55e; }

    /* Glow pulse */
    .pulse {
        animation: pulse 1.8s infinite ease-in-out;
    }

    @keyframes pulse {
        0% { transform: scale(0.9); opacity: 0.7; }
        50% { transform: scale(1.3); opacity: 1; }
        100% { transform: scale(0.9); opacity: 0.7; }
    }

    /* Motion lines */
    .motion-line {
        stroke-dasharray: 6;
        animation: dash 1.5s linear infinite;
    }

    @keyframes dash {
        to {
            stroke-dashoffset: -20;
        }
    }

    /* Buttons */
    .btn-main {
        background:#007bff;
        color:white;
        padding:10px 18px;
        border-radius:8px;
        font-weight:600;
        transition:0.2s;
    }
    .btn-main:hover {
        background:#005fcc;
        transform:translateY(-2px);
    }

    .btn-secondary {
        background:#1e263b;
        color:#9db4ff;
        padding:10px 18px;
        border-radius:8px;
        font-weight:600;
    }


    
/* 3D Radar animation */
.radar-ring {
    position: absolute;
    width: 180px;
    height: 180px;
    border-radius: 50%;
    border: 3px solid rgba(0, 255, 200, 0.35);
    animation: radarPulse 3s infinite ease-out;
}

@keyframes radarPulse {
    0% { transform: scale(0.1); opacity: 0.8; }
    70% { transform: scale(1.5); opacity: 0.2; }
    100% { transform: scale(2.2); opacity: 0; }
}

/* Movement trail dots */
.trail-dot {
    width: 10px;
    height: 10px;
    background: rgba(0,150,255,0.75);
    border-radius: 50%;
    box-shadow: 0 0 12px rgba(0,150,255,0.75);
}

/* Direction arrow */
.direction-arrow {
    border-top: 10px solid #3b82f6;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    height: 0;
    width: 0;
    transform-origin: center;
    animation: moveArrow 1.2s infinite linear;
}

@keyframes moveArrow {
    0% { transform: translateY(0px); opacity: 1; }
    100% { transform: translateY(-18px); opacity: 0; }
}

/* Hover card */
.hover-card {
    background:#0f172a;
    color:white;
    padding:8px 10px;
    border-radius:10px;
    font-size:12px;
    border:1px solid rgba(255,255,255,0.15);
    position:absolute;
    pointer-events:none;
    z-index:9999;
    display:none;
}


</style>

<div class="max-w-full mx-auto map-wrapper">

    <div class="flex justify-between items-center mb-3">
        <h2 class="map-title">Gombe State — Live Client Map</h2>

        <div class="flex items-center gap-3">
            <button id="refreshBtn" class="btn-main">🔄 Refresh</button>
            <button id="centerAll" class="btn-secondary">🎯 Re-center</button>
        </div>
    </div>

    <div id="map"></div>

</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Set map to Gombe State
    const map = L.map('map', {
        zoomControl: false,
        minZoom: 6,
        maxZoom: 17
    }).setView([10.2892, 11.1673], 9);

    // Dark theme tile
    L.tileLayer(
        "https://tile.jawg.io/jawg-dark/{z}/{x}/{y}.png?access-token=PbwPnI8GMgN28Xwm2srllLEb7qGBvURyVtYFECQbpysaJihQzN8OD0DXzNWAW6EQ",
        { attribution: "&copy; Jawg Maps" }
    ).addTo(map);

    const markerGroup = L.layerGroup().addTo(map);
    const lineGroup = L.layerGroup().addTo(map);

    function getStatusColor(status) {
        switch (status) {
            case "online": return "green";
            case "recent": return "blue";
            default: return "red";
        }
    }

    // Custom glowing icon generator
    function dotIcon(color) {
        return L.divIcon({
            className: "",
            html: `<div class="dot-${color} pulse"></div>`,
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        });
    }

    function drawMotionLine(coordsA, coordsB, color) {
        const polyline = L.polyline([coordsA, coordsB], {
            color: color,
            weight: 3,
            className: "motion-line"
        });
        lineGroup.addLayer(polyline);
    }

    function fetchLocations() {
        document.getElementById("refreshBtn").innerText = "Refreshing...";

        fetch("{{ route('admin.map.locations') }}")
            .then(r => r.json())
            .then(json => {
                markerGroup.clearLayers();
                lineGroup.clearLayers();

                const points = json.data || [];
                const latlngs = [];

                for (let i = 0; i < points.length; i++) {
                    const c = points[i];
                    if (!c.lat || !c.lng) continue;

                    let statusColor = "red";
                    if (c.status === "online") statusColor = "green";
                    else if (c.status === "recent") statusColor = "blue";

                    const marker = L.marker([c.lat, c.lng], {
                        icon: dotIcon(statusColor)
                    }).bindPopup(`
                        <div class="text-sm text-blue-200">
                            <div class="font-bold text-lg">${c.name}</div>
                            <div>Reg: ${c.registration_id ?? "-"}</div>
                            <div>Last Seen: ${c.last_seen_at ?? "-"}</div>
                            <a href="/admin/clients/${c.client_id}" class="text-blue-400 underline mt-2 block">View Profile</a>
                        </div>
                    `);

                    markerGroup.addLayer(marker);
                    latlngs.push([c.lat, c.lng]);

                    // Draw motion lines between sequential clients for animation
                    if (i > 0) {
                        const prev = points[i - 1];
                        if (prev.lat && prev.lng) {
                            const color = statusColor === "green" ? "#22c55e" :
                                          statusColor === "blue" ? "#3b82f6" :
                                          "#ff3b3b";
                            drawMotionLine(
                                [prev.lat, prev.lng],
                                [c.lat, c.lng],
                                color
                            );
                        }
                    }
                }

                if (latlngs.length > 0) {
                    map.fitBounds(L.latLngBounds(latlngs).pad(0.2));
                }
            })
            .finally(() => {
                document.getElementById("refreshBtn").innerText = "🔄 Refresh";
            });
    }

    fetchLocations();
    setInterval(fetchLocations, 10000);

    document.getElementById("refreshBtn").addEventListener("click", fetchLocations);
    document.getElementById("centerAll").addEventListener("click", fetchLocations);
</script>


<script>
/* -----------------------------
   PHASE 4: RADAR + TRAIL + ARROWS
--------------------------------*/

const radarGroup = L.layerGroup().addTo(map);
const trailGroup = L.layerGroup().addTo(map);
const arrowGroup = L.layerGroup().addTo(map);

let hoverCard = document.createElement("div");
hoverCard.classList.add("hover-card");
document.body.appendChild(hoverCard);

function createRadar(lat, lng) {
    const radarIcon = L.divIcon({
        className: "",
        html: `<div class="radar-ring"></div>`,
        iconSize: [180, 180],
        iconAnchor: [90, 90]
    });

    L.marker([lat, lng], { icon: radarIcon }).addTo(radarGroup);
}

function createTrail(trailData) {
    trailData.forEach(t => {
        const d = L.divIcon({
            className:"",
            html:`<div class="trail-dot"></div>`,
            iconSize:[10,10],
            iconAnchor:[5,5]
        });
        L.marker([t.lat, t.lng], { icon:d }).addTo(trailGroup);
    });
}

function createDirectionArrow(lat1, lng1, lat2, lng2) {
    const angle = (Math.atan2(lat2-lat1, lng2-lng1) * 180 / Math.PI);

    const arrowIcon = L.divIcon({
        className:"",
        html:`<div class="direction-arrow" style="transform: rotate(${angle}deg);"></div>`,
        iconSize:[20,20],
        iconAnchor:[10,10]
    });

    L.marker([lat2, lng2], { icon: arrowIcon }).addTo(arrowGroup);
}

function attachHoverEvent(marker, data) {
    marker.on("mouseover", function (e) {
        hoverCard.style.display = "block";
        hoverCard.innerHTML = `
            <b>${data.name}</b><br>
            Reg: ${data.registration_id}<br>
            Last Seen: ${data.last_seen_at}<br>
            Status: ${data.status}
        `;
    });

    marker.on("mousemove", function (e) {
        hoverCard.style.top = (e.originalEvent.pageY + 15)+"px";
        hoverCard.style.left = (e.originalEvent.pageX + 15)+"px";
    });

    marker.on("mouseout", function () {
        hoverCard.style.display = "none";
    });
}

/* Replace your old fetchLocations() with this enhanced one */
function fetchLocations() {
    fetch("{{ route('admin.map.locations') }}")
    .then(r => r.json())
    .then(json => {
        markerGroup.clearLayers();
        radarGroup.clearLayers();
        trailGroup.clearLayers();
        arrowGroup.clearLayers();

        const points = json.data || [];
        const latlngs = [];

        points.forEach(p => {
            if(!p.lat || !p.lng) return;

            const icon = dotIcon(
                p.status === "online" ? "green" :
                p.status === "recent" ? "blue" : "red"
            );

            const marker = L.marker([p.lat,p.lng], {icon})
                .bindPopup(`
                    <div class="text-sm text-blue-200">
                        <div class="font-bold text-lg">${p.name}</div>
                        <div>Reg: ${p.registration_id}</div>
                        <div>Last Seen: ${p.last_seen_at}</div>
                    </div>
                `);

            marker.addTo(markerGroup);

            attachHoverEvent(marker, p);

            /* 3D radar for ACTIVE users */
            if (p.status === "online") createRadar(p.lat, p.lng);

            /* movement trail (last 8 coordinates) */
            if (p.trail && p.trail.length > 1) {
                createTrail(p.trail);

                let last = p.trail[p.trail.length - 1];
                let second = p.trail[p.trail.length - 2];

                /* direction arrow */
                createDirectionArrow(
                    second.lat, second.lng,
                    last.lat, last.lng
                );
            }

            latlngs.push([p.lat,p.lng]);
        });

        if(latlngs.length > 0) {
            map.fitBounds(L.latLngBounds(latlngs).pad(0.3));
        }
    });
}

fetchLocations();
setInterval(fetchLocations, 10000);
</script>

@endpush

@endsection
