<?php		
include 'define.php';
$keyword = strval($_GET['term']);
$search_param = "{$keyword}%";
$conn = new mysqli(PDO_HOST, PDO_USER_NAME , PDO_USER_PSW, PDO_DB_NAME);

$sql = $conn->prepare("SELECT DISTINCT cpville FROM sta_entreprise WHERE cpville LIKE ?"    );
$sql->bind_param("s",$search_param);			
$sql->execute();
$result = $sql->get_result();
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
    $Result[] = $row["cpville"]."";
	}
	echo json_encode($Result);
}
$conn->close();
?>