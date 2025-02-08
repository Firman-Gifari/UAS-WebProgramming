<?php
require '../backend/conn.php';

// Ambil kategori unik
$categories = $database_connection->query("
  SELECT DISTINCT category 
  FROM products 
  LIMIT 4
")->fetchAll();

// Mapping kategori ke URL halaman khusus
$category_pages = [
  "Muslim Outfit" => "muslim_outfit.php",
  "Casual Outfit" => "casual_outfit.php",
  "Vintage Outfit" => "vintage_outfit.php",
  "Streetwear Outfit" => "streetwear_outfit.php",
];

$categories = [
  ['category' => 'Muslim Outfit', 'image_url' => 'https://plus.unsplash.com/premium_photo-1669366530593-8c5ec8050f1e?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NDV8fHJlbGlnaW91cyUyMG91dGZpdHxlbnwwfHwwfHx8MA%3D%3D'],
  ['category' => 'Casual Outfit', 'image_url' => 'https://images.unsplash.com/photo-1536243298747-ea8874136d64?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
  ['category' => 'Vintage Outfit', 'image_url' => 'https://images.unsplash.com/photo-1649449446718-33d2753a36eb?q=80&w=1376&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
  ['category' => 'Streetwear Outfit', 'image_url' => 'https://images.unsplash.com/photo-1644568722968-c21549419c4c?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="styles.css" />
    <style>
      html {
        scroll-behavior: smooth;
      }
    </style>
    <title>Landing page</title>
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

    <!-- NAVBAR -->
    <header class="bg-gray-50">
      <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div
          class="flex flex-col items-start gap-4 md:flex-row md:items-center md:justify-between"
        >
          <div>
            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
              AQILA WARDROBE
            </h1>

            <p class="mt-1.5 text-sm text-gray-500">
              Pusat fashion se-Indonesia, dari tahun 2000
            </p>
          </div>

          <div class="flex items-center gap-4">
            <button type="button">
              <a
                class="inline-flex items-center justify-center gap-1.5 rounded border border-gray-200 bg-white px-5 py-3 text-gray-900 transition hover:text-gray-700 focus:outline-none focus:ring text-sm font-medium"
                href="#"
                onclick="keluar()"
              >
                Keluar
              </a>
            </button>

            <button
              class="inline-block rounded bg-indigo-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-indigo-700 focus:outline-none focus:ring"
              type="button"
            >
              <a href="comingsoon.html"> Akun </a>
            </button>
          </div>
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
      <script>
        function keluar() {
          // 1. Ambil session token dari localStorage
          const sessionToken = localStorage.getItem("session_token");

          // 2. Buat objek FormData untuk mengirimkan data ke server
          const formData = new FormData();
          formData.append("session_token", sessionToken);

          // 3. Kirim permintaan POST ke server untuk melakukan logout
          axios
            .post(
              "https://client-server-nova.000webhostapp.com/logout.php",
              formData
            )
            .then((response) => {
              // 4. Periksa respons dari server
              if (response.data.status === "success") {
                // Jika logout berhasil, hapus session token dan arahkan ke halaman login
                localStorage.removeItem("session_token");
                window.location.href = "login.html";
              } else {
                // Jika logout gagal, tampilkan pesan kesalahan
                alert("Logout gagal. Silahkan coba lagi.");
              }
            })
            .catch((error) => {
              // 5. Tangani jika terjadi kesalahan saat logout
              console.error("Terjadi kesalahan saat logout:", error);
            });
        }
      </script>
    </header>
    <!-- END NAVBAR -->

    <!-- BANNER -->
    <section class="mt-8">
      <div class="my-5 lg:items-center">
        <div class="mx-auto max-w-xl text-center">
          <h1 class="text-3xl font-extrabold sm:text-5xl">
            Selamat Datang
            <strong id="uname" class="font-extrabold text-indigo-600 sm:block">
            </strong>
          </h1>
          <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
          <script>
            function getNama() {
              const nama = localStorage.getItem("nama");
              return nama ? nama : "Tamu";
            }

            const uname = document.getElementById("uname");
            uname.innerText = `Selamat datang, ${getNama()}!`;
          </script>
          <p class="mt-4 sm:text-xl/relaxed">
            Selamat berjelajah di Dunia fashion "AQILA WARDROBE", Enjoy of the
            Shopping, and happy nice day 😘
          </p>

          
        </div>
      </div>
    </section>
    <!-- END BANNER -->
    <section>
      <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:items-center md:gap-8">
          <div>
            <div class="max-w-lg md:max-w-none">
              <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
                Dapatkan Koleksi Muslim Outfit, Casual, Vintage & Streetwear Terbaru di AQILA WARDROBE.
              </h2>
    
              <p class="mt-4 text-gray-700">
                Temukan koleksi fashion 
                <strong>Muslim Outfit</strong> yang elegan dan berkualitas. Kami menghadirkan berbagai pilihan pakaian yang sesuai 
                dengan gaya dan kebutuhan Anda, mulai dari <strong>gamis modern</strong>, <strong>tunik stylish</strong>, 
                <strong>abaya eksklusif</strong>, <strong>hijab premium</strong>, hingga berbagai outfit kasual dan trendig.
              </p>
            </div>
          </div>
    
          <div>
            <img
              src="https://images.unsplash.com/photo-1540221652346-e5dd6b50f3e7?q=80&w=1769&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
              class="rounded"
              alt=""
            />
          </div>
          
        </div>
      </div>
    </section>
    <section id="produk">
  <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
    <header>
      <span class="flex items-center">
        <h2 class="pr-6 text-xl font-bold text-gray-900 sm:text-3xl">
          Produk Kami
        </h2>
        <span class="h-px flex-1 bg-black"></span>
      </span>
    </header>

    <ul class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
      <?php foreach ($categories as $category): ?>
        <li>
          <a 
            href="<?= $category_pages[$category['category']] ?? 'default_category.php' ?>" 
            class="group block overflow-hidden"
          >
            <img
              src="<?= $category['image_url'] ?>"
              alt="<?= $category['category'] ?>"
              class="h-[350px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[450px]"
            />

            <div class="relative bg-white pt-3">
              <p class="mt-2">
                <span class="tracking-wider text-gray-900">
                  <?= $category['category'] ?>
                </span>
              </p>
            </div>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="mt-8 flex flex-wrap justify-center gap-4">
      <a
        class="block w-full rounded bg-indigo-600 px-12 py-3 text-sm font-medium text-white shadow hover:bg-indigo-600 focus:outline-none focus:ring active:bg-indigo-600 sm:w-auto"
        href="menushop.php"
      >
        Lihat Selengkapnya!!
      </a>
    </div>
  </div>
</section>


    <!-- INFORMASI -->

    <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
      <div class="mx-auto max-w-3xl text-center">
        <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
          Toko online fashion terpercaya
        </h2>
    

    
        <p class="mt-4 text-gray-500 sm:text-xl">
          Kami selalu memperbarui koleksi kami agar Anda dapat menikmati tren fashion terbaru dengan tetap mempertahankan 
          gaya yang sopan dan elegan. Temukan outfit favorit Anda untuk pria, wanita, dan anak-anak hanya di 
          <strong>AQILA WARDROBE</strong>, toko online fashion terpercaya.
        </p>
      </div>
      <dl class="mt-6 grid grid-cols-1 gap-4 sm:mt-8 sm:grid-cols-2 lg:grid-cols-4">
        <div class="flex flex-col rounded-lg bg-blue-50 px-4 py-8 text-center">
          <dt class="order-last text-lg font-medium text-gray-500">Total Sales</dt>
    
          <dd class="text-4xl font-extrabold text-blue-600 md:text-5xl">4.8 Juta</dd>
        </div>
    
        <div class="flex flex-col rounded-lg bg-blue-50 px-4 py-8 text-center">
          <dt class="order-last text-lg font-medium text-gray-500">Official Store</dt>
    
          <dd class="text-4xl font-extrabold text-blue-600 md:text-5xl">24</dd>
        </div>
    
        <div class="flex flex-col rounded-lg bg-blue-50 px-4 py-8 text-center">
          <dt class="order-last text-lg font-medium text-gray-500">Total Product</dt>
    
          <dd class="text-4xl font-extrabold text-blue-600 md:text-5xl">86</dd>
        </div>
    
        <div class="flex flex-col rounded-lg bg-blue-50 px-4 py-8 text-center">
          <dt class="order-last text-lg font-medium text-gray-500">Rating</dt>
    
          <dd class="text-4xl font-extrabold text-blue-600 md:text-5xl">4.9</dd>
        </div>
      </dl>
    </div>

    </div>
    
    
      








    <!-- END INFORMASI -->



    

    <!-- TESTIMONIAL -->
    <link
      href="https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/keen-slider.min.css"
      rel="stylesheet"
    />

    <script type="module">
      import KeenSlider from "https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/+esm";

      const keenSliderActive = document.getElementById("keen-slider-active");
      const keenSliderCount = document.getElementById("keen-slider-count");

      const keenSlider = new KeenSlider(
        "#keen-slider",
        {
          loop: true,
          defaultAnimation: {
            duration: 750,
          },
          slides: {
            origin: "center",
            perView: 1,
            spacing: 16,
          },
          breakpoints: {
            "(min-width: 640px)": {
              slides: {
                origin: "center",
                perView: 1.5,
                spacing: 16,
              },
            },
            "(min-width: 768px)": {
              slides: {
                origin: "center",
                perView: 1.75,
                spacing: 16,
              },
            },
            "(min-width: 1024px)": {
              slides: {
                origin: "center",
                perView: 3,
                spacing: 16,
              },
            },
          },
          created(slider) {
            slider.slides[slider.track.details.rel].classList.remove(
              "opacity-40"
            );

            keenSliderActive.innerText = slider.track.details.rel + 1;
            keenSliderCount.innerText = slider.slides.length;
          },
          slideChanged(slider) {
            slider.slides.forEach((slide) => slide.classList.add("opacity-40"));

            slider.slides[slider.track.details.rel].classList.remove(
              "opacity-40"
            );

            keenSliderActive.innerText = slider.track.details.rel + 1;
          },
        },
        []
      );

      const keenSliderPrevious = document.getElementById(
        "keen-slider-previous"
      );
      const keenSliderNext = document.getElementById("keen-slider-next");

      keenSliderPrevious.addEventListener("click", () => keenSlider.prev());
      keenSliderNext.addEventListener("click", () => keenSlider.next());
    </script>

    <section class="bg-white">
      <div class="mx-auto max-w-screen-xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <h2
          class="text-center text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl"
        >
          Berikut testimoni dan komentar dari customer kamii~
        </h2>

        <div class="mt-8">
          <div id="keen-slider" class="keen-slider">
            <div
              class="keen-slider__slide opacity-40 transition-opacity duration-500"
            >
              <blockquote class="rounded-lg bg-gray-50 p-6 shadow-sm sm:p-8">
                <div class="flex items-center gap-4">
                  <img
                    alt=""
                    src="https://images.unsplash.com/photo-1553457055-88e354f1257c?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1yZWxhdGVkfDExOXx8fGVufDB8fHx8fA%3D%3D"
                    class="size-14 rounded-full object-cover"
                  />

                  <div>
                    <div class="flex justify-center gap-0.5 text-green-500">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                    </div>

                    <p class="mt-0.5 text-lg font-medium text-gray-900">
                      Cokii
                    </p>
                  </div>
                </div>

                <p class="mt-4 text-gray-700">
                  Serius cuy bahan produknya bagus banget, real-pict juga.
                  Recomend banget dah pokoknya
                </p>
              </blockquote>
            </div>

            <div
              class="keen-slider__slide opacity-40 transition-opacity duration-500"
            >
              <blockquote class="rounded-lg bg-gray-50 p-6 shadow-sm sm:p-8">
                <div class="flex items-center gap-4">
                  <img
                    alt=""
                    src="https://images.unsplash.com/photo-1608533635246-800ee55aa8ab?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1yZWxhdGVkfDEwOXx8fGVufDB8fHx8fA%3D%3D"
                    class="size-14 rounded-full object-cover"
                  />

                  <div>
                    <div class="flex justify-center gap-0.5 text-green-500">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="grey"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                    </div>

                    <p class="mt-0.5 text-lg font-medium text-gray-900">
                      Kevin Julian
                    </p>
                  </div>
                </div>

                <p class="mt-4 text-gray-700">
                  Menurutku barang nya oke, cuman ada yg kurang. Yang kurang nya
                  tuh, napa diskonnya 1 tahun sekali di tgl 12 bulan 12 :V
                  Bintangnya kurangin satu dah ah :(
                </p>
              </blockquote>
            </div>

            <div
              class="keen-slider__slide opacity-40 transition-opacity duration-500"
            >
              <blockquote class="rounded-lg bg-gray-50 p-6 shadow-sm sm:p-8">
                <div class="flex items-center gap-4">
                  <img
                    alt=""
                    src="https://images.unsplash.com/photo-1456327102063-fb5054efe647?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1yZWxhdGVkfDEwNnx8fGVufDB8fHx8fA%3D%3D"
                    class="size-14 rounded-full object-cover"
                  />

                  <div>
                    <div class="flex justify-center gap-0.5 text-green-500">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                    </div>

                    <p class="mt-0.5 text-lg font-medium text-gray-900">
                      Shaynee
                    </p>
                  </div>
                </div>

                <p class="mt-4 text-gray-700">
                  Pacarku heran, katanya "kok cowo bisa beli baju yang bahan nya
                  bagus." pas gwa kasih tau harga nya berapa, eh dia malah
                  tepar, padahal harganya B aja.
                </p>
              </blockquote>
            </div>

            <div
              class="keen-slider__slide opacity-40 transition-opacity duration-500"
            >
              <blockquote class="rounded-lg bg-gray-50 p-6 shadow-sm sm:p-8">
                <div class="flex items-center gap-4">
                  <img
                    alt=""
                    src="https://images.unsplash.com/photo-1568048496249-390708208038?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1yZWxhdGVkfDI3fHx8ZW58MHx8fHx8"
                    class="size-14 rounded-full object-cover"
                  />

                  <div>
                    <div class="flex justify-center gap-0.5 text-green-500">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-5"
                        viewBox="0 0 20 20"
                        fill="indigo"
                      >
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        />
                      </svg>
                    </div>

                    <p class="mt-0.5 text-lg font-medium text-gray-900">
                      Dinda A
                    </p>
                  </div>
                </div>

                <p class="mt-4 text-gray-700">
                  Dikira bakal dikirim lap dapur soalnya harga nya gak wajar, eh
                  pas dateng, pen nangis liat barang nya kok bisa sebagus dan
                  se-realpict ini. Aku beli nya pas 12.12 sih, kata orang, hoki
                  setahun ku dah abis kepake buat beli ini
                </p>
              </blockquote>
            </div>
          </div>

          <div class="mt-6 flex items-center justify-center gap-4">
            <button
              aria-label="Previous slide"
              id="keen-slider-previous"
              class="text-gray-600 transition-colors hover:text-gray-900"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="indigo"
                class="size-5"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M15.75 19.5L8.25 12l7.5-7.5"
                />
              </svg>
            </button>

            <p class="w-16 text-center text-sm text-gray-700">
              <span id="keen-slider-active"></span>
              /
              <span id="keen-slider-count"></span>
            </p>

            <button
              aria-label="Next slide"
              id="keen-slider-next"
              class="text-gray-600 transition-colors hover:text-gray-900"
            >
              <svg
                class="size-5"
                fill="none"
                stroke="indigo"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M9 5l7 7-7 7"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </section>
    <!-- END TESTIMONIAL -->

    <!-- FOOTER -->
     <!--
  Heads up! 👋

  Plugins:
    - @tailwindcss/forms
-->

<footer class="bg-white">
  <div class="mx-auto max-w-screen-xl px-4 pb-8 pt-16 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-md">
      <strong class="block text-center text-xl font-bold text-gray-900 sm:text-3xl">
        Want us to email you with the latest blockbuster news?
      </strong>

      <form class="mt-6">
        <div class="relative max-w-lg">
          <label class="sr-only" for="email"> Email </label>

          <input
            class="w-full rounded-full border-gray-200 bg-gray-100 p-4 pe-32 text-sm font-medium"
            id="email"
            type="email"
            placeholder="aqilawardrobe@gmail.com"
          />

          <button
            class="absolute end-1 top-1/2 -translate-y-1/2 rounded-full bg-blue-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-700"
          >
            Subscribe
          </button>
        </div>
      </form>
    </div>

    <div class="mt-16 grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-32">
      <div class="mx-auto max-w-sm lg:max-w-none">
        <p class="mt-4 text-center text-gray-500 lg:text-left lg:text-lg">
          Mencari pakaian yang dapat meningkatkan penampilan Anda dan nyaman digunakan sehari-hari? Hanya ada satu tempat yang dapat menyediakan semua kebutuhan fashion Anda, mulai dari Muslim Outfit, casual, hingga streetwear, yaitu Toko Online Resmi AQILA WARDROBE.
        </p>

        <div class="mt-6 flex justify-center gap-4 lg:justify-start">
          <a
            class="text-gray-700 transition hover:text-gray-700/75"
            href="#"
            target="_blank"
            rel="noreferrer"
          >
            <span class="sr-only"> Facebook </span>

            <svg class="size-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path
                fill-rule="evenodd"
                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                clip-rule="evenodd"
              />
            </svg>
          </a>

          <a
            class="text-gray-700 transition hover:text-gray-700/75"
            href="#"
            target="_blank"
            rel="noreferrer"
          >
            <span class="sr-only"> Instagram </span>

            <svg class="size-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path
                fill-rule="evenodd"
                d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                clip-rule="evenodd"
              />
            </svg>
          </a>

          <a
            class="text-gray-700 transition hover:text-gray-700/75"
            href="#"
            target="_blank"
            rel="noreferrer"
          >
            <span class="sr-only"> Twitter </span>

            <svg class="size-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path
                d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"
              />
            </svg>
          </a>

          <a
            class="text-gray-700 transition hover:text-gray-700/75"
            href="#"
            target="_blank"
            rel="noreferrer"
          >
            <span class="sr-only"> GitHub </span>

            <svg class="size-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path
                fill-rule="evenodd"
                d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                clip-rule="evenodd"
              />
            </svg>
          </a>

          <a
            class="text-gray-700 transition hover:text-gray-700/75"
            href="#"
            target="_blank"
            rel="noreferrer"
          >
            <span class="sr-only"> Dribbble </span>

            <svg class="size-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path
                fill-rule="evenodd"
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.362zM12 3.475c2.17 0 4.154.813 5.662 2.148-.152.216-1.443 1.941-4.48 3.08-1.399-2.57-2.95-4.675-3.189-5A8.687 8.687 0 0112 3.475zm-3.633.803a53.896 53.896 0 013.167 4.935c-3.992 1.063-7.517 1.04-7.896 1.04a8.581 8.581 0 014.729-5.975zM3.453 12.01v-.26c.37.01 4.512.065 8.775-1.215.25.477.477.965.694 1.453-.109.033-.228.065-.336.098-4.404 1.42-6.747 5.303-6.942 5.629a8.522 8.522 0 01-2.19-5.705zM12 20.547a8.482 8.482 0 01-5.239-1.8c.152-.315 1.888-3.656 6.703-5.337.022-.01.033-.01.054-.022a35.318 35.318 0 011.823 6.475 8.4 8.4 0 01-3.341.684zm4.761-1.465c-.086-.52-.542-3.015-1.659-6.084 2.679-.423 5.022.271 5.314.369a8.468 8.468 0 01-3.655 5.715z"
                clip-rule="evenodd"
              />
            </svg>
          </a>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-8 text-center lg:grid-cols-3 lg:text-left">
        <div>
          <strong class="font-medium text-gray-900"> Services </strong>

          <ul class="mt-6 space-y-1">
            <li>
              <a class="text-gray-700 transition hover:text-gray-700/75" href="#"> Marketing </a>
            </li>
          </ul>
        </div>

        <div>
          <strong class="font-medium text-gray-900"> About </strong>

          <ul class="mt-6 space-y-1">
            <li>
              <a class="text-gray-700 transition hover:text-gray-700/75" href="#"> About </a>
            </li>

            <li>
              <a class="text-gray-700 transition hover:text-gray-700/75" href="#"> Careers </a>
            </li>

            <li>
              <a class="text-gray-700 transition hover:text-gray-700/75" href="#"> History </a>
            </li>

            <li>
              <a class="text-gray-700 transition hover:text-gray-700/75" href="#"> Our Team </a>
            </li>
          </ul>
        </div>

        <div>
          <strong class="font-medium text-gray-900"> Support </strong>

          <ul class="mt-6 space-y-1">
            <li>
              <a class="text-gray-700 transition hover:text-gray-700/75" href="#"> FAQs </a>
            </li>

            <li>
              <a class="text-gray-700 transition hover:text-gray-700/75" href="#"> Contact </a>
            </li>

            <li>
              <a class="text-gray-700 transition hover:text-gray-700/75" href="#"> Live Chat </a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="mt-16 border-t border-gray-100 pt-8">
      <p class="text-center text-xs/relaxed text-gray-500">
        @Copyright by 22552011171_EGA-SULANJANA_TIF-22-CID.
      </p>
    </div>
  </div>
</footer>
    <!-- END FOOTER -->
  </body>
  <script>
    const strong = document.getElementById("uname");
    const dataUser = JSON.parse(localStorage.getItem("dataUser"));
    strong.innerText = dataUser.uname;
  </script>
</html>
