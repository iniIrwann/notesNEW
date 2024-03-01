<?php
$servername = "localhost";
$database = "pplg_1_notes";
$password = "";
$conn = mysqli_connect($servername, "root", $password, $database);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

function query($kueri)
{
    global $conn;
    $result = mysqli_query($conn, $kueri);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function hapus($no)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM notes WHERE id = '$no'");
    return mysqli_affected_rows($conn);
}
function inputdata($inputdata)
{
    global $conn;
    $sql = mysqli_query($conn, $inputdata);
    return $sql;
}

function editdata($tablename, $id)
{
    global $conn;
    $sql = mysqli_query($conn, "SELECT * FROM $tablename WHERE id = '$id'");
    return $sql;
}

function update($table, $data, $id)
{
    global $conn;
    $sql = "UPDATE $table SET note = '$data' WHERE id = '$id' ";
    $hasil = mysqli_query($conn, $sql);
    return $hasil;
}

function cek_login($username, $password)
{
    global $conn;
    $uname = $username;
    $upass = $password;
    $hasil = mysqli_query($conn, "select * from user where username='$uname' and password=md5('$upass')");
    $cek = mysqli_num_rows($hasil);
    if ($cek > 0) {
        $query = mysqli_fetch_array($hasil);
        $_SESSION['id_user'] = $query['id_user'];
        $_SESSION['username'] = $query['username'];
        $_SESSION['role'] = $query['role'];
        return true;
    } else {
        return false;
    }
}

function showcatatan()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT notes.id, notes.note, notes.created_at, user.username 
    FROM notes INNER JOIN user ON notes.id_user = user.id_user;");
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

?>