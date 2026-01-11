<?php
require_once 'config.php';
require_once 'helpers.php';
require_librarian();
$user=$_SESSION['user'];

$id=intval($_GET['id']);
$stmt=$conn->prepare("SELECT * FROM books WHERE id=? AND librarian_id=?");
$stmt->bind_param("ii",$id,$user['id']);
$stmt->execute();
$res=$stmt->get_result();
$book=$res->fetch_assoc();
if(!$book) redirect('manage_books.php');

$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $title=trim($_POST['title']);
    $author=trim($_POST['author']);
    $category=trim($_POST['category']);
    $copies=intval($_POST['copies']);

    if(!$title || !$author || !$category || $copies<1){
        $errors[]="All fields required";
    }

    if(empty($errors)){
        $stmt=$conn->prepare("UPDATE books SET title=?,author=?,category=?,copies=? WHERE id=? AND librarian_id=?");
        $stmt->bind_param("sssiii",$title,$author,$category,$copies,$id,$user['id']);
        if($stmt->execute()){
            redirect('manage_books.php');
        } else $errors[]="Failed to update";
    }
}

include 'partials/header.php';
?>
<div class="max-w-xl mx-auto">
    <div class="bg-white/5 border border-white/10 p-10 rounded-3xl backdrop-blur-xl">
        <h2 class="font-display text-3xl text-neonCyan mb-8 text-center">Modify Record</h2>
        <form method="post" class="space-y-5">
            <input type="text" name="title" value="<?php echo e($book['title']); ?>" required
                class="w-full bg-black/50 border border-white/10 rounded-xl px-5 py-4 text-white focus:border-neonCyan outline-none transition">
            <input type="text" name="author" value="<?php echo e($book['author']); ?>" required
                class="w-full bg-black/50 border border-white/10 rounded-xl px-5 py-4 text-white focus:border-neonCyan outline-none transition">
            <input type="text" name="category" value="<?php echo e($book['category']); ?>" required
                class="w-full bg-black/50 border border-white/10 rounded-xl px-5 py-4 text-white focus:border-neonCyan outline-none transition">
            <input type="number" name="copies" value="<?php echo e($book['copies']); ?>" required
                class="w-full bg-black/50 border border-white/10 rounded-xl px-5 py-4 text-white focus:border-neonCyan outline-none transition">
            <button type="submit" class="w-full bg-neonCyan text-black font-black py-4 rounded-xl hover:brightness-125 transition">UPDATE DATABASE</button>
        </form>
    </div>
</div>
<?php include 'partials/footer.php'; ?>