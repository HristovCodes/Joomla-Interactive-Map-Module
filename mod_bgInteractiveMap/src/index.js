import L from '../node_modules/leaflet/dist/leaflet';
import '../node_modules/leaflet/dist/leaflet.css';
import ZoomMarker from './ZoomMarker';


const defaultCenter = [42.7249925, 25.4833039];
const defaultZoom = 7.7;
maxBoundsTopLeft = [44.267552653898946, 21.19562785223469];
maxBoundsBottomRight = [41.24442015186197, 29.71685444362345]

const map = L.map('map', {
  zoomSnap: 0.1, //updates leaflet to allow fractional zoom
  minZoom: defaultZoom, //user cant zoom out anymore then on start
  maxBounds: [maxBoundsTopLeft, maxBoundsBottomRight] //forces map to stay between both
});

//tile map 
//change this to change map look
const basemap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}', {
  attribution: 'Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ, TomTom, Intermap, iPC, USGS, FAO, NPS, NRCAN, GeoBase, Kadaster NL, Ordnance Survey, Esri Japan, METI, Esri China (Hong Kong), and the GIS User Community'
});

//starts map on bounds on defaultZoom zoom
map.setView(defaultCenter, defaultZoom);

//sets tiles to map object
basemap.addTo(map);

//get the data from php
//get the mapData dom element
var mapData = document.getElementById("mapData")

//check if it got anyhting
if(mapData.value === null)
{
  console.error("NO MAP DATA")
}

//parse the obj 
JSON.parse(mapData.value).forEach(el => {
    //creates marker with text and zoom on click
    ZoomMarker(map, [el.lat,el.long], 10, `<a href="http://example.com/">Visit and explore ${el.name}!</a>`)
});