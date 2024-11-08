<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}

if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'update_user'){
	$save = $crud->update_user();
	if($save)
		echo $save;
}
if($action == 'upload_file'){
	$save = $crud->upload_file();
	if($save)
		echo $save;
	// var_dump($_FILES);
}

if ($_GET['action'] == 'delete_file') {
    echo delete_file();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'remove_file') {
    $data = json_decode(file_get_contents("php://input"), true);
    $filePath = '../assets/uploads/products/' . $data['filePath'];

    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'File could not be deleted.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'File does not exist.']);
    }
    exit;
}

function delete_file()
{
    $filename = $_POST['filename'] ?? '';

    // File path should match the upload path
    $filepath = '../assets/uploads/products/' . $filename;

    if ($filename && file_exists($filepath)) {
        unlink($filepath);
        return json_encode(array("status" => 1, "message" => "File deleted successfully."));
    } else {
        return json_encode(array("status" => 0, "message" => "File not found."));
    }
}



if($action == 'save_upload'){
	$save = $crud->save_upload();
	if($save)
		echo $save;
}
if($action == 'delete_file'){
	$delete = $crud->delete_file();
	if($delete)
		echo $delete;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'delete_cart'){
	$delete = $crud->delete_cart();
	if($delete)
		echo $delete;
}
if($action == 'save_category'){
	$save = $crud->save_category();
	if($save)
		echo $save;
}
if($action == 'delete_category'){
	$delete = $crud->delete_category();
	if($delete)
		echo $delete;
}
if($action == 'save_product'){
	$save = $crud->save_product();
	if($save)
		echo $save;
}
if($action == 'delete_product'){
	$delete = $crud->delete_product();
	if($delete)
		echo $delete;
}
if($action == "add_to_cart"){
	$save = $crud->add_to_cart();
	if($save)
		echo $save;
}
if($action == "custom_req"){
	$save = $crud->custom_req();
	if($save)
		echo $save;
}
if($action == "make_req"){
	$save = $crud->make_req();
	if($save)
		echo $save;
}
if($action == "update_custom_req"){
	$save = $crud->update_custom_req();
	if($save)
		echo $save;
}
if($action == "update_user_req"){
	$save = $crud->update_user_req();
	if($save)
		echo $save;
}
if($action == "update_cart"){
	$save = $crud->update_cart();
	if($save)
		echo $save;
}
if($action == "get_cart_count"){
	$get = $crud->get_cart_count();
	if($get)
		echo $get;
}

if($action == "save_order"){
	$save = $crud->save_order();
	if($save)
		echo $save;
}
if($action == "update_order"){
	$save = $crud->update_order();
	if($save)
		echo $save;
}

if($action == "delete_order"){
	$delsete = $crud->delete_order();
	if($delsete)
		echo $delsete;
}
ob_end_flush();
?>
