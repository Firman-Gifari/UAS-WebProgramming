<?php
require '../backend/conn.php';

// Ambil ID produk dari URL
if (!isset($_GET['id'])) {
    header('Location: landingpage.php');
    exit;
}

$product_id = $_GET['id'];

// Query ke database
try {
    $stmt = $database_connection->prepare("
        SELECT *, 
        JSON_UNQUOTE(variants) AS variants,
        JSON_UNQUOTE(sizes) AS sizes 
        FROM products 
        WHERE id = ?
    ");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Redirect jika produk tidak ditemukan
if (!$product) {
    header('Location: landingpage.php');
    exit;
}

// Decode JSON untuk varian dan ukuran
$variants = json_decode($product['variants']);
$sizes = json_decode($product['sizes']);

// Fungsi untuk generate bintang rating
function generateRatingStars($rating) {
  $fullStars = floor($rating);
  $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
  $emptyStars = 5 - $fullStars - $halfStar;
  
  $stars = '';
  
  // Full stars
  for ($i = 0; $i < $fullStars; $i++) {
      $stars .= '<svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
      </svg>';
  }
  
  // Half star
  if ($halfStar) {
      $stars .= '<svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 1a.999.999 0 01.897.553l1.93 3.91 4.317.628a1 1 0 01.554 1.706l-3.124 3.044.738 4.3a1 1 0 01-1.45 1.054L10 14.347l-3.86 2.03a1 1 0 01-1.45-1.054l.738-4.3-3.124-3.044a1 1 0 01.554-1.706l4.317-.628L9.103 1.553A1 1 0 0110 1zm0 2.445L8.665 5.3a1 1 0 01-.753.547l-2.647.385 1.916 1.867a1 1 0 01.287.885l-.453 2.635 2.365-1.243a1 1 0 01.931 0l2.365 1.243-.453-2.635a1 1 0 01.287-.885l1.916-1.867-2.647-.385a1 1 0 01-.753-.547L10 3.445z"/>
      </svg>';
  }
  
  // Empty stars
  for ($i = 0; $i < $emptyStars; $i++) {
      $stars .= '<svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
      </svg>';
  }
  
  return $stars;
}

// Ambil rating dari database
$rating = $product['rating'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Detail</title>
</head>
<body class="container mx-auto">
    <h1 class="font-bold my-4 text-2xl">Details</h1>
    <div class="flex flex-col md:flex-row gap-10">
        <!-- Bagian Gambar -->
        <div class="flex-1">
            <img
                src="<?= htmlspecialchars($product['image_url']) ?>"
                alt="<?= htmlspecialchars($product['name']) ?>"
                class="w-full rounded-lg shadow-lg"
            />
        </div>
        
        <!-- Bagian Detail Produk -->
        <div class="flex-1 flow-root">
            <dl class="-my-3 divide-y divide-gray-100 text-sm">
                <!-- Nama Produk -->
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                    <dt class="font-medium text-gray-900">Nama</dt>
                    <dd class="text-gray-700 sm:col-span-2 text-lg"><?= htmlspecialchars($product['name']) ?></dd>
                </div>

                <!-- Harga -->
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                    <dt class="font-medium text-gray-900">Harga</dt>
                    <dd class="text-gray-700 sm:col-span-2 text-lg font-semibold">
                        Rp <?= number_format($product['price'], 0, ',', '.') ?>
                    </dd>
                </div>

                <!-- Bagian Rating -->
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                    <dt class="font-medium text-gray-900">Rating</dt>
                    <dd class="text-gray-700 sm:col-span-2">
                        <div class="flex items-center">
                            <div class="flex items-center">
                                <?= generateRatingStars($rating) ?>
                            </div>
                            <span class="ml-2 text-gray-600">(<?= number_format($rating, 1) ?>/5.0)</span>
                        </div>
                    </dd>
                </div>

                <!-- Deskripsi -->
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                    <dt class="font-medium text-gray-900">Deskripsi</dt>
                    <dd class="text-gray-700 sm:col-span-2">
                        <?= htmlspecialchars($product['description']) ?>
                        <a href="#" class="text-blue-500 block mt-2">Lihat selengkapnya ...</a>
                    </dd>
                </div>

                <!-- Jumlah -->
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                    <dt class="font-medium text-gray-900">Jumlah</dt>
                    <dd class="text-gray-700 sm:col-span-2">
                        <div class="flex items-center rounded border border-gray-200 w-36">
                            <button
                                type="button"
                                id="kurangBtn"
                                class="size-10 leading-10 text-gray-600 transition hover:opacity-75"
                            >
                                &minus;
                            </button>
                            <input
                                type="number"
                                id="Quantity"
                                value="1"
                                min="1"
                                class="h-10 w-16 text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none"
                            />
                            <button
                                type="button"
                                id="tambahBtn"
                                class="size-10 leading-10 text-gray-600 transition hover:opacity-75"
                            >
                                &plus;
                            </button>
                        </div>
                    </dd>
                </div>

                <!-- Varian -->
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                    <dt class="font-medium text-gray-900">Varian</dt>
                    <dd class="text-gray-700 sm:col-span-2">
                        <div class="inline-flex flex-wrap gap-2 rounded-lg border border-gray-100 bg-gray-100 p-1">
                            <?php foreach ($variants as $varian): ?>
                                <button
                                    type="button"
                                    data-varian="<?= htmlspecialchars($varian) ?>"
                                    class="varian-btn px-4 py-2 text-sm rounded-md transition-colors duration-200"
                                >
                                    <?= htmlspecialchars($varian) ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </dd>
                </div>

                <!-- Ukuran -->
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                    <dt class="font-medium text-gray-900">Ukuran</dt>
                    <dd class="text-gray-700 sm:col-span-2">
                        <div class="inline-flex flex-wrap gap-2 rounded-lg border border-gray-100 bg-gray-100 p-1">
                            <?php foreach ($sizes as $size): ?>
                                <button
                                    type="button"
                                    data-ukuran="<?= htmlspecialchars($size) ?>"
                                    class="ukuran-btn px-4 py-2 text-sm rounded-md transition-colors duration-200"
                                >
                                    <?= htmlspecialchars($size) ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </dd>
                </div>

                <!-- Tombol Aksi -->
                <div class="grid grid-cols-1 gap-1 py-3 sm:grid-cols-3 sm:gap-4">
                    <dt class="font-medium text-gray-900"></dt>
                    <dd class="text-gray-700 sm:col-span-2 space-x-4">
                        <form action="../backend/tambahKeranjang.php" method="POST" class="inline-block">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']) ?>">
                            <input type="hidden" name="harga" value="<?= $product['price'] ?>">
                            <input type="hidden" name="quantity" id="quantityHidden" value="1">
                            <input type="hidden" name="varian" id="varianHidden">
                            <input type="hidden" name="ukuran" id="ukuranHidden">
                            
                            <button
                                type="submit"
                                class="bg-transparent rounded border border-gray-700 px-8 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100 transition-all duration-300"
                            >
                                Tambah ke Keranjang
                            </button>
                        </form>
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <script>
        // Fungsi untuk Quantity
        const quantityInput = document.getElementById("Quantity");
        const quantityHidden = document.getElementById("quantityHidden");
        const kurangBtn = document.getElementById("kurangBtn");
        const tambahBtn = document.getElementById("tambahBtn");

        // Update quantity hidden input
        function updateQuantity() {
            quantityHidden.value = quantityInput.value;
        }

        tambahBtn.addEventListener("click", () => {
            quantityInput.value = parseInt(quantityInput.value) + 1;
            updateQuantity();
        });

        kurangBtn.addEventListener("click", () => {
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
                updateQuantity();
            }
        });

        quantityInput.addEventListener("change", updateQuantity);

        // Fungsi untuk Varian
        const varianButtons = document.querySelectorAll('.varian-btn');
        const varianHidden = document.getElementById('varianHidden');

        varianButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Remove all active classes
                varianButtons.forEach(btn => {
                    btn.classList.remove('bg-blue-500', 'text-white', 'shadow-md');
                });

                // Add active class to clicked button
                button.classList.add('bg-blue-500', 'text-white', 'shadow-md');
                
                // Update hidden input
                varianHidden.value = button.dataset.varian;
            });
        });

        // Fungsi untuk Ukuran
        const ukuranButtons = document.querySelectorAll('.ukuran-btn');
        const ukuranHidden = document.getElementById('ukuranHidden');

        ukuranButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();

                // Remove all active classes
                ukuranButtons.forEach(btn => {
                    btn.classList.remove('bg-blue-500', 'text-white', 'shadow-md');
                });

                // Add active class to clicked button
                button.classList.add('bg-blue-500', 'text-white', 'shadow-md');
                
                // Update hidden input
                ukuranHidden.value = button.dataset.ukuran;
            });
        });

        // Validasi sebelum submit
        document.querySelector('form').addEventListener('submit', (e) => {
            if (!varianHidden.value || !ukuranHidden.value) {
                e.preventDefault();
                alert('Silakan pilih varian dan ukuran terlebih dahulu!');
            }
        });
    </script>
</body>
</html>