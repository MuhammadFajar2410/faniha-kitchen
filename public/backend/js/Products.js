$(document).ready(function () {});

function formatRupiah(amount) {
    let number_string = amount.toString(),
        sisa = number_string.length % 3,
        rupiah = number_string.substr(0, sisa),
        ribuan = number_string.substr(sisa).match(/\d{3}/g);

    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    return "Rp. " + rupiah;
}

$.ajax({
    type: "GET",
    url: "/products",
    dataType: "JSON",
    success: function (response) {
        const products = response.products;
        $.each(products, function (index, product) {
            $(".modal-view").on("click", function () {
                const productSlug = $(this).data("slug");
                const product = products.find((p) => p.slug === productSlug);
                const imgPath = "backend/uploads/image/products/" + product.img;
                const productName = product.product_name;

                if (product) {
                    $(".modals").modal("show");
                    $("#modalTitle").text("Detail Produk : " + productName);
                    $("#modalBody").html(
                        `<div class="container-fluid" style="overflow-y: auto">
                                <div class="row" style="height: max-content">
                                    <div class="col-4">
                                        <img src="${imgPath}" alt="${productName}" width="240" height="300">
                                    </div>
                                    <div class="offset-1 col-7">
                                        <span class="text-muted" style="font-weight:bold">Nama Product :</span>
                                        <span class="d-block my-1" style="font-size:1.3rem">${productName}</span>
                                        <hr>
                                        <span class="text-muted" style="font-weight:bold">Deskripsi :</span>
                                        <span class="d-block my-1" style="text-align:justify">${
                                            product.description
                                        }</span>
                                        <hr>
                                        <span class="text-muted" style="font-weight:bold">Stock :</span>
                                        <span class="d-block my-1">${
                                            product.stock
                                        }</span>
                                        <hr>
                                        <span class="text-muted" style="font-weight:bold">Harga :</span>
                                        <span class="d-block my-1">${formatRupiah(
                                            product.price
                                        )}</span>
                                    </div>
                                </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>`
                    );
                }
            });

            // Modal Edit
            $(".modal-edit").on("click", function () {
                const productSlug = $(this).data("slug");
                const product = products.find((p) => p.slug === productSlug);
                const productName = product.product_name;

                if (product) {
                    $(".modals-edit").modal("show");
                    $("#modal-edit-title").text("Edit Produk : " + productName);
                    $("#input-wrapper").html(
                        `<div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="product_name" class="form-label">Nama Product</label>
                            <input type="text" name="product_name" id="product_name" class="form-control" required value="${productName}">
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" id="editor" cols="30" rows="5" required>${
                                product.description
                            }</textarea>
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="price" class="form-label">Harga</label>
                            <input type="number" name="price" id="price" class="form-control" required value="${
                                product.price
                            }">
                        </div>
                        <div class="form-group">
                            <span class="text-danger">*</span>
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" name="stock" id="stock" class="form-control" required value="${
                                product.price
                            }">
                        </div>
                        <div class="form-group">
                            <label for="stock" class="form-label d-block">Status</label>
                            <input type="radio" name="status" id="status_aktif" ${
                                product.status ? "checked" : ""
                            } class="mx-2" value="1"> Aktif
                            <input type="radio" name="status" id="status_nonaktif" ${
                                !product.status ? "checked" : ""
                            } class="mx-2" value="0">Tidak Aktif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                  `
                    );
                }
            });
        });
    },
    error: function (xhr, status, error) {
        // Menangani error
        console.error("Error: " + error);
    },
});

// Modal Add
$(".modal-add").on("click", function () {
    let url = "/products";
    let method = "POST";
    let csrf = $('meta[name="csrf-token"]').attr("content");
    $(".modals").modal("show");
    $("#modalTitle").text("Tambah Produk");
    $("#modalBody").html(
        ` <form enctype="multipart/form-data" id="form-add-product" method="${method}" action="${url}">
            <input type="hidden" name="_token" value="${csrf}" autocomplete="off">
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="product_name" class="form-label">Nama Product</label>
                <input type="text" name="product_name" id="product_name" class="form-control" required>
            </div>
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" id="description" cols="30" rows="8" required></textarea>
            </div>
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="price" class="form-label">Harga</label>
                <input type="number" name="price" id="price" class="form-control" required>
            </div>
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="stock" class="form-label">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" required>
            </div>
            <div class="form-group">
                <span class="text-danger">*</span>
                <label for="img" class="form-label">Gambar Product</label>
                <input type="file" name="img" id="img" class="form-control-file" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="add-submit-product">Save changes</button>
            </div>
        </form>`
    );
});

// Modal view
