<?php  


// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$markers = $dom->createElement("markers");
$markersNode = $dom->appendChild($markers); 
// Opens a connection to a MySQL server
$conn_string = "host=localhost port=5432 dbname=map user=postgres password=postgres";
$connection = pg_connect($conn_string);

if (!$connection) {  die('Not connected : ');} 


// Select all the rows in the markers table

$query = "SELECT * FROM barangays";
$result = pg_query($connection, $query);
if (!$result) {
  echo "An error occurred.\n";
  exit;
}

header("Content-type: text/xml"); 

// Iterate through the rows, adding XML nodes for each

while ($row = pg_fetch_assoc($result)){  
  // ADD TO XML DOCUMENT NODE  
  //--------process 2: marker---------------
  $marker = $dom->createElement("marker");  
  $newMarker = $markers->appendChild($marker);
  //$parNode2 = $dom->appendChild($node);  
  //----------------------------------------
  
  
  //------------process 1:points----------------------
  //$pointsNode = $dom->createElement("Polypoints");
  //$parNodePoints = $parNode2->appendChild($pointsNode);
  //--------------------------------------------------
  
  $newMarker->setAttribute("name",$row['barangay']);
  $newMarker->setAttribute("address", $row['address']);
  $newMarker->setAttribute("type",$row['disaster_type']);
  $newMarker->setAttribute("disaster_description",$row['disaster_description']);
  $newMarker->setAttribute("casualties",$row['casualties']);
  $newMarker->setAttribute("families_affected",$row['families_affected']);
  $newMarker->setAttribute("estimated_cost",$row['estimated_cost']);
  
  
  
  //------------process 2:points ---------------------
   
  
  //$newPolygon->setAttribute("lat", $row['lat']);  
  //$newPolygon->setAttribute("lng", $row['lng']); 

  //$point = $dom->createElement("point");
  //$newPoint = $polygon->appendChild($point); 
  $newMarker->setAttribute("lat", $row['lat']);
  $newMarker->setAttribute("lng", $row['lng']);
  //$newPolygon->setAttribute("type", $row['type']);
  //---------------------------------------------------
  
  //$points = $dom->createElement("points");
  //$newPoints = $polygon->appendChild($points);
  
  
  //$point=$dom->createElement("point");
  //$newPoint=$polygon->appendChild($point);
  //$newPoint->setAttribute("lat", $row['lat']); 
  //$newPoint->setAttribute("lng", $row['lng']);
  
  //$points1 = explode(",",$row['points']);
  //for($i=0;$i<count($points1);$i++)
  //{
  //  $point = $dom->createElement("point",$row['points']);
  //  $newPoint = $polygon->appendChild($point);
  //  $newPoint->setAttribute("latitude", $points1[$i++]);
  //  $newPoint->setAttribute("longitude", $points1[$i]);
  //}
  
} 

echo $dom->saveXML();

?>