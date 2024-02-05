<?php
// Database configuration
$host = 'kashin.db.elephantsql.com';
$dbname = 'yvmijizw';
$user = 'yvmijizw';
$port = '5432'; // Default PostgreSQL port is 5432, provided by ElephantSQL


// Data Source Name for PostgreSQL
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

try {
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Assuming you've received and sanitized the XML URL ($_POST['xmlUrl'])
if (isset($_POST['xmlUrl'])) {
    $xmlUrl = filter_var($_POST['xmlUrl'], FILTER_SANITIZE_URL);
    if (filter_var($xmlUrl, FILTER_VALIDATE_URL) !== false) {
        $xmlContent = file_get_contents($xmlUrl);
        $xml = simplexml_load_string($xmlContent);
        $data = [];

        foreach ($xml->url as $url) {
            $loc = (string)$url->loc;
            $lastMod = (string)$url->lastmod;
            $data[] = ['loc' => $loc, 'lastmod' => $lastMod];
        }

        // Here, insert or update the database with the fetched XML data
        // Example: INSERT INTO site_xml_data (site_name, xml_url, xml_content) VALUES (?, ?, ?)
        // You'll need to extract 'site_name' from $xmlUrl and use $xmlContent for 'xml_content'
        
        // For demonstration, echoing back table rows
        foreach ($data as $entry) {
            echo "<tr><td>{$entry['loc']}</td><td>{$entry['lastmod']}</td></tr>";
        }
    } else {
        echo "Invalid URL.";
    }
} else {
    echo "No URL provided.";
}

// Example: Inserting new XML data
$siteName = 'Extracted or predefined site name'; // Define how you extract or set this
$stmt = $pdo->prepare("INSERT INTO site_xml_data (site_name, xml_url, xml_content) VALUES (?, ?, ?)");
$stmt->execute([$siteName, $xmlUrl, $xmlContent]);

?>
