<?php
require '../backend/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $productId = $_POST['product_id'] ?? null;

        switch ($_POST['action']) {
            case 'increase':
                $database_connection->query("UPDATE keranjang SET quantity = quantity + 1 WHERE product_id = $productId");
                break;
            case 'decrease':
                $database_connection->query("UPDATE keranjang SET quantity = GREATEST(quantity - 1, 1) WHERE product_id = $productId");
                break;
            case 'remove':
                $database_connection->query("DELETE FROM keranjang WHERE product_id = $productId");
                break;
            case 'checkout':
                if (!empty($_POST['selected_products'])) {
                    foreach ($_POST['selected_products'] as $selectedProduct) {
                        $product = json_decode($selectedProduct, true);
                        $productId = $product['product_id'];
                        $varian = $product['varian'];
                        $ukuran = $product['ukuran'];

                        $stmt = $database_connection->prepare("DELETE FROM keranjang WHERE product_id = ? AND varian = ? AND ukuran = ?");
                        $stmt->execute([$productId, $varian, $ukuran]);
                    }
                    header('Location: keranjang.php?success=1');
                    exit;
                } else {
                    header('Location: keranjang.php?success=0');
                    exit;
                }
                break;
        }
    }
    header('Location: keranjang.php');
    exit;
}

  $keranjang = $database_connection->query("
      SELECT products.id as product_id, products.name, products.price, products.category, products.image_url, keranjang.quantity, keranjang.varian, keranjang.ukuran 
      FROM keranjang 
      JOIN products ON keranjang.product_id = products.id
    ")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Keranjang</title>
    <script>
      function updateTotal() {
        const checkboxes = document.querySelectorAll('.product-checkbox:checked');
        let total = 0;

        checkboxes.forEach(checkbox => {
          const productRow = checkbox.closest('.product-row');
          const price = parseFloat(productRow.dataset.price);
          const quantity = parseInt(productRow.querySelector('.quantity-input').value);
          total += price * quantity;
        });

        document.getElementById('subtotal').textContent = 'Rp. ' + total.toLocaleString('id-ID');
      }

      function submitForm(action, productId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '';

        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = action;
        form.appendChild(actionInput);

        if (productId) {
          const productIdInput = document.createElement('input');
          productIdInput.type = 'hidden';
          productIdInput.name = 'product_id';
          productIdInput.value = productId;
          form.appendChild(productIdInput);
        }

        document.body.appendChild(form);
        form.submit();
      }

      function confirmCheckout() {
        const selectedProducts = Array.from(document.querySelectorAll('.product-checkbox:checked'))
          .map(checkbox => {
            const productRow = checkbox.closest('.product-row');
            return {
              product_id: checkbox.value,
              varian: productRow.querySelector('.product-varian').value,
              ukuran: productRow.querySelector('.product-ukuran').value
            };
          });

        if (selectedProducts.length === 0) {
          alert('Silakan pilih produk yang ingin di-checkout.');
          return;
        }

        if (confirm('Apakah Anda yakin ingin checkout produk yang dipilih?')) {
          const form = document.createElement('form');
          form.method = 'POST';
          form.action = '';

          const actionInput = document.createElement('input');
          actionInput.type = 'hidden';
          actionInput.name = 'action';
          actionInput.value = 'checkout';
          form.appendChild(actionInput);

          selectedProducts.forEach(product => {
            const productIdInput = document.createElement('input');
            productIdInput.type = 'hidden';
            productIdInput.name = 'selected_products[]';
            productIdInput.value = JSON.stringify(product);
            form.appendChild(productIdInput);
          });

            document.body.appendChild(form);
            form.submit();
        }
      }

      function handleSuccess() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('success') === '1') {
          alert('Pembelian Berhasil!');
        } else if (urlParams.get('success') === '0') {
          alert('Silakan pilih produk untuk checkout!');
        }
      }

      window.onload = handleSuccess;
    </script>
  </head>
  <body>
    <section>
      <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="mx-auto max-w-3xl">
          <header class="text-center">
            <h1 class="text-xl font-bold text-gray-900 sm:text-3xl">
              Keranjang
            </h1>
          </header>

          <div class="mt-8">
            <ul class="space-y-4">
              <?php foreach ($keranjang as $item): ?>
              <li class="flex items-center gap-4 product-row" data-price="<?= htmlspecialchars($item['price']) ?>">
                <input type="checkbox" class="product-checkbox" value="<?= $item['product_id'] ?>" onclick="updateTotal()" />
                <input type="hidden" class="product-varian" value="<?= htmlspecialchars($item['varian']) ?>" />
                <input type="hidden" class="product-ukuran" value="<?= htmlspecialchars($item['ukuran']) ?>" />

                <img
                  src="<?= htmlspecialchars($item['image_url']) ?>"
                  alt="<?= htmlspecialchars($item['name']) ?>"
                  class="h-16 w-16 rounded object-cover"
                />

                <div>
                  <h3 class="text-sm text-gray-900"> <?= htmlspecialchars($item['name']) ?></h3>
                  <dl class="mt-0.5 space-y-px text-[10px] text-gray-600">
                    <div>
                      <dt class="inline">Varian:</dt>
                      <dd class="inline"> <?= htmlspecialchars($item['varian']) ?></dd>
                    </div>

                    <div>
                      <dt class="inline">Ukuran:</dt>
                      <dd class="inline"> <?= htmlspecialchars($item['ukuran']) ?></dd>
                    </div>
                  </dl>
                </div>

                <div class="flex flex-1 items-center justify-end gap-2">
                  <button onclick="submitForm('decrease', <?= $item['product_id'] ?>)" class="text-gray-600 transition hover:text-red-600"> - </button>

                  <input
                    type="number"
                    min="1"
                    value="<?= htmlspecialchars($item['quantity']) ?>"
                    class="h-8 w-12 rounded border-gray-200 bg-gray-50 p-0 text-center text-xs text-gray-600 quantity-input"
                    readonly
                  />

                  <button onclick="submitForm('increase', <?= $item['product_id'] ?>)" class="text-gray-600 transition hover:text-green-600"> + </button>

                  <button onclick="submitForm('remove', <?= $item['product_id'] ?>)" class="text-gray-600 transition hover:text-red-600">
                    <span class="sr-only">Remove item</span>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      class="h-4 w-4"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                      />
                    </svg>
                  </button>
                </div>
              </li>
              <?php endforeach; ?>
            </ul>

            <div class="mt-8 flex justify-end border-t border-gray-100 pt-8">
              <div class="w-screen max-w-lg space-y-4">
                <dl class="space-y-0.5 text-sm text-gray-700">
                  <div class="flex justify-between !text-base font-medium">
                    <dt>Total Harga:</dt>
                    <dd id="subtotal">Rp. 0</dd>
                  </div>
                </dl>
              </div>
            </div>

            <div class="mt-8 flex justify-end pt-8">
              <div class="w-screen max-w-lg space-y-4">
                <div class="flex justify-end">
                  <button type="button" onclick="confirmCheckout()" class="block rounded bg-gray-700 px-5 py-3 text-sm text-gray-100 transition hover:bg-gray-600">
                    Checkout
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
