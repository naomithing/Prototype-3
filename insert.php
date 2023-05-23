<?php

// create the connection
$servername = "sql205.epizy.com";
$username = "epiz_34160505";
$password = "NIanfp5OmVad";
$dbname = "epiz_34160505_weatherapp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}else{
  echo "Database connected successfully";
}

// fetch data from api 
$json_data = file_get_contents("https://api.openweathermap.org/data/2.5/weather?&units=metric&q=glasgow&appid=fb3e255e49928aa4b81ce931e214bdea");

// convert the received data into json format
$data = json_decode($json_data, true);

// accessing the data 
$city = $data['name'];
$temp = $data['main']['temp'];
$humidity = $data['main']['humidity'];
$wind_speed = $data['wind']['speed'];
$pressure = $data['main']['pressure'];
$maindescrip = $data['weather'][0]['main'];
$descrip = $data['weather'][0]['description'];
$mintemp = $data['main']['temp_min'];
$maxtemp = $data['main']['temp_max'];
$timestamp = $data['dt'];
$day = gmdate("l", $timestamp);
$date = gmdate("Y-m-d", $timestamp);

// echo "$date";
// echo $temp;
// query to insert data into the table according to the table in database
echo" ---------------------------------------------------------------------------------------------------------------------";
echo"Server Message: ";
$sql = "INSERT INTO dataofweather(city,temperature,humidity,pressure,wind_speed,datetime,descrip,Mintemp,Maxtemp) 
       VALUES('$city','$temp','$humidity','$pressure','$wind_speed','$date','$descrip','$mintemp','$maxtemp')";
echo "$sql";

// execute the query to insert data into the "Weather" table
mysqli_query($conn, $sql);

// select the query
$sql_select = "SELECT * FROM dataofweather";

// execute the select query
$result = mysqli_query($conn, $sql_select);

// display the data in an HTML table
echo "<table border='1'>
        <tr>
            <th>City Name</th>
            <th>Temperature</th>
            <th>Humidity</th>
            <th>Description</th>
            <th>Date</th>
            <th>Pressure</th>
            <th>Wind Speed</th>
            <th>Min Temperature</th>
            <th>Max Temperature</th>
        </tr>";

while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['city'] . "</td>";
    echo "<td>" . $row['temperature'] . "</td>";
    echo "<td>" . $row['humidity'] . "</td>";
    echo "<td>" . $row['descrip'] . "</td>";
    echo "<td>" . $row['datetime'] . "</td>";
    echo "<td>" . $row['pressure'] . "</td>";
    echo "<td>" . $row['wind_speed'] . "</td>";
    echo "<td>" . $row['Mintemp'] . "</td>";
    echo "<td>" . $row['Maxtemp'] . "</td>";
    echo "</tr>";
}
echo "</table>";

?>