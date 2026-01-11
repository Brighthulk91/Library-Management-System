<?php
require_once 'config.php';
require_once 'helpers.php';
require_librarian();
$user=$_SESSION['user'];

$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $title=trim($_POST['title']);
    $author=trim($_POST['author']);
    $category=trim($_POST['category']);
    $copies=intval($_POST['copies']);

    if(!$title || !$author || !$category || $copies<1){
        $errors[]="All fields required and copies must be at least 1";
    }

    if(empty($errors)){
        $stmt=$conn->prepare("INSERT INTO books (librarian_id,title,author,category,copies) VALUES (?,?,?,?,?)");
        $stmt->bind_param("isssi",$user['id'],$title,$author,$category,$copies);
        if($stmt->execute()){
            redirect('manage_books.php');
        } else $errors[]="Failed to add book";
    }
}

include 'partials/header.php';
?>
<div class="max-w-2xl mx-auto">
    <div class="bg-white/5 border border-white/10 p-10 rounded-3xl backdrop-blur-xl shadow-2xl relative">
        <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-neonGreen text-black px-6 py-2 rounded-full font-black text-xs tracking-tighter">NEW ACQUISITION</div>
        
        <h2 class="font-display text-4xl text-white mb-8 text-center mt-4 tracking-tight">Register Volume</h2>

        <?php foreach($errors as $err): ?>
            <div class="bg-red-500/10 border border-red-500/50 text-red-500 p-4 rounded-xl mb-6 text-sm italic"><?php echo e($err); ?></div>
        <?php endforeach; ?>

        <form method="post" class="space-y-6">
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-gray-500 uppercase ml-1 tracking-widest">Book Information</label>
                <input type="text" name="title" placeholder="Full Title" required
                    class="w-full bg-black/50 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-neonGreen outline-none transition">
                <input type="text" name="author" placeholder="Author Name" required
                    class="w-full bg-black/50 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-neonGreen outline-none transition">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-500 uppercase ml-1 tracking-widest">Classification</label>
                    <input type="text" name="category" placeholder="e.g. Sci-Fi" required
                        class="w-full bg-black/50 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-neonGreen outline-none transition">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-gray-500 uppercase ml-1 tracking-widest">Stock Units</label>
                    <input type="number" name="copies" placeholder="Qty" required
                        class="w-full bg-black/50 border border-white/10 rounded-2xl px-6 py-4 text-white focus:border-neonGreen outline-none transition">
                </div>
            </div>

            <button type="submit" class="w-full bg-white text-black font-black py-5 rounded-2xl hover:bg-neonGreen transition shadow-lg active:scale-95 text-sm tracking-widest">
                CONFIRM ENTRY
            </button>
        </form>
    </div>
</div>
<?php include 'partials/footer.php'; ?>