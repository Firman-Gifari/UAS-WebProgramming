<?php
require '../backend/conn.php';

// Ambil produk berdasarkan kategori
$products = $database_connection->query("
  SELECT * 
  FROM products 
  WHERE category = 'Casual Outfit'
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Casual Outfit</title>
  </head>
  <body>
    <!-- PROMO -->
    <div class="bg-indigo-600 px-4 py-3 text-white">
      <p class="text-center text-sm font-medium">
        PROMO 12.12 HINGGA 99%
        <a href="comingsoon.html" class="inline-block underline"
          >Khusus di jam 00.00 WIB</a
        >
      </p>
    </div>
    <!-- END PROMO -->

    <!-- PRODUCT -->
    <section id="produk">
      <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <header>
        <a class="w-0" href="landingpage.php"
            ><img class="h-10 mb-5" src="../frontend/img//arrowBack.png" alt=""
          /></a>
          <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">
            Casual Outfit
          </h2>

          <p class="mt-4 max-w-md text-gray-500">
            Berikut adalah kumpulan produk kami bertemakan casual yang populer
            dan best seller, jangan lupa untuk menghabiskan uang anda disini
            yaa, keep enjoy of the shopping
          </p>
        </header>

        <ul class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
          <?php foreach ($products as $product): ?>
            <li>
              <a href="details.php?id=<?= $product['id'] ?>" class="group block overflow-hidden">
                <img
                  src="<?= $product['image_url'] ?>"
                  alt="<?= $product['name'] ?>"
                  class="h-[350px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[450px]"
                />

                <div class="relative bg-white pt-3">
                  <h3
                    class="text-xs text-gray-700 group-hover:underline group-hover:underline-offset-4"
                  >
                    <?= $product['name'] ?>
                  </h3>

                  <p class="mt-2">
                    <span class="sr-only"> Regular Price </span>

                    <span class="tracking-wider text-gray-900">
                      Rp. <?= number_format($product['price'], 0, ',', '.') ?>
                    </span>
                  </p>
                </div>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>
    <!-- END PRODUCT -->

    <!-- FOOTER -->
    <footer class="bg-indigo-600">
      <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="text-center">
          <p class="text-sm text-white lg:mt-0">
            @Copyright by 22552011171_EGA-SULANJANA_TIF-22-CID
          </p>
        </div>
      </div>
    </footer>
    <!-- END FOOTER -->
  </body>
</html>
