<?php
require_once 'config.php';
require_once 'helpers.php';
require_login(); 

$user = $_SESSION['user'];
$success = $error = '';

if(isset($_POST['upload']) && $user['role'] === 'librarian') {
    $book_id = intval($_POST['book_id']);
    $file = $_FILES['cover'];

    if($book_id <= 0) {
        $error = "Select a valid book.";
    } elseif($file['error'] !== 0) {
        $error = "Select an image.";
    } else {
        $allowed = ['jpg','jpeg','png','gif'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if(!in_array($ext, $allowed)) {
            $error = "JPG, PNG, GIF only.";
        } else {
            if (!is_dir('uploads')) mkdir('uploads', 0777, true);
            $newFileName = time() . '_' . preg_replace('/\s+/', '_', $file['name']);
            $destination = 'uploads/' . $newFileName;

            if(move_uploaded_file($file['tmp_name'], $destination)) {
                $stmt = $conn->prepare("INSERT INTO gallery (book_id, filename) VALUES (?, ?)");
                $stmt->bind_param("is", $book_id, $newFileName);
                if($stmt->execute()) $success = "Cover uploaded!";
                else $error = "DB Error.";
            }
        }
    }
}

// Fetch all book covers with titles
$result = $conn->query("SELECT g.*, b.title FROM gallery g JOIN books b ON g.book_id = b.id ORDER BY g.uploaded_at DESC");

include 'partials/header.php';
?>
<div class="space-y-12">
    <?php if($user['role'] === 'librarian'): ?>
    <div class="max-w-lg mx-auto bg-white/5 border border-white/10 p-8 rounded-3xl">
        <h2 class="font-display text-2xl text-neonYellow mb-6 text-center italic">Upload Book Asset</h2>
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <select name="book_id" required class="w-full bg-black border border-white/10 rounded-xl p-4 text-white">
                <option value="">-- Choose Volume --</option>
                <?php 
                $books_res = $conn->query("SELECT id, title FROM books");
                while($b = $books_res->fetch_assoc()): ?>
                    <option value="<?php echo $b['id']; ?>"><?php echo e($b['title']); ?></option>
                <?php endwhile; ?>
            </select>
            <input type="file" name="cover" accept="image/*" required class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-neonYellow file:text-black">
            <button type="submit" name="upload" class="w-full bg-neonYellow text-black font-black py-3 rounded-xl hover:scale-105 transition transform">UPLOAD TO SYSTEM</button>
        </form>
    </div>
    <?php endif; ?>

    <div>
        <h3 class="font-display text-3xl text-white mb-8 border-l-4 border-neonCyan pl-4 tracking-tight">Visual Archives</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="bg-white/5 border border-white/10 p-4 rounded-2xl group hover:border-neonCyan transition">
                    <div class="aspect-[3/4] overflow-hidden rounded-xl mb-4">
                        <img src="uploads/<?php echo $row['filename']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                    <p class="text-center text-xs font-bold text-gray-400 uppercase tracking-tighter truncate"><?php echo e($row['title']); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php include 'partials/footer.php'; ?>