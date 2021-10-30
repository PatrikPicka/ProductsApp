<?php
$user = new User();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrace pro přístup do administrace</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand">Welcome <?= $user->data()->username ?></a>
            <a onclick="logout()" class="logoutText">
                <p>Logout</p>
            </a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card" style="width: 100%;">
            <div class="text-center">
                <h5 class="card-header">Products</h5>
            </div>
            <div class="card-body">
                <div class="card-title d-flex justify-content-between">
                    <input type="text" class="form-controll" placeholder="Search your product.." style="width: 40%; border: none; border-radius: 5px;" id="searchProduct">
                    <button style="width:30%;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductModal">New product</button>
                </div>
                <div class="card-text" id="cardText">
                    <!-- <div class="list-group">
                        <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <a href="login" class="productLink">
                                <h5>Product title</h5>
                            </a><button class="editBtn"><span class="badge rounded-pill"><i class="fas fa-pencil-alt" style="color: orange;font-size: 25px;"></i></span></button>
                        </div>
                    </div> -->
                    <div class="container text-center loading" id="loading">
                        <div class="spinner-border text-dark" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <!-- Modal for data-->
                    <div class="modal fade" id="productDataModal" tabindex="-1" aria-labelledby="productDataModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="DataModalLabel">

                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="DataModalBody"></div>
                                    <div class="container text-center loading" id="loadingData">
                                        <div class="spinner-border text-dark" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for edit-->
                    <div class="modal fade" id="productEditModal" tabindex="-1" aria-labelledby="productEditModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="modal-title" id="EditModalTitle">
                                        <label for="#editProductTitle" class="form-label">Name of the product:</label>

                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="EditModalBody">
                                    </div>
                                    <div class="container text-center loading" id="loadingEditData">
                                        <div class="spinner-border text-dark" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">

                                    <div id="footer-btn" class="d-flex justify-content-between align-items-center" style="width: 100%;">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Create new product modal-->
                    <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="modal-title" id="EditModalTitle">
                                        <label for="#createProductTitle" class="form-label">Name of the product:</label>
                                        <input type="text" id="createProductTitle" class="form-controll" style="width: 100%; border: 1px solid lightgrey;" placeholder="Here goes name of the product...">
                                    </div>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="#createDescription" class="form-label">Description for the product:</label>
                                    <textarea name="createDescription" id="createDescription" style="width: 100%; border: 1px solid lightgrey;" rows="10" placeholder="Here goes description of the product..."></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="createProduct()">Create product</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/27d71ea5c6.js" crossorigin="anonymous"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>
    <script>
        let products;
        $(window).on("load", () => {
            $.ajax({
                type: "GET",
                url: '<?= REQUEST_URL ?>products/products',
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(resp, textStatus, jqXHR) {
                    if (jqXHR.status === 200) {
                        products = resp;
                        products.forEach(element => {
                            $("#cardText").append('<div class="list-group generatedProducts"><div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"><a class="productLink" data-bs-toggle="modal" data-bs-target="#productDataModal" onclick="getDataForProduct(' + element.id + ')"><h5>' + element.name + '</h5></a><button class="editBtn" onclick="editProduct(' + element.id + ')" data-bs-toggle="modal" data-bs-target="#productEditModal"><span class="badge rounded-pill"><i class="fas fa-pencil-alt" style="color: orange;font-size: 25px;"></i></span></button></div></div>');
                        });
                        $("#loading").css("display", "none");
                    }
                },
                error: function(xhr, textStatus, error) {
                    if (xhr.status === 500) {

                    }
                }
            })
        })


        function updateProductsData() {
            $("#loading").css("display", "block");
            $.ajax({
                type: "GET",
                url: '<?= REQUEST_URL ?>products/products',
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(resp, textStatus, jqXHR) {
                    if (jqXHR.status === 200) {
                        products = resp;
                        $(".generatedProducts").remove();
                        products.forEach(element => {
                            $("#cardText").append('<div class="list-group generatedProducts"><div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"><a class="productLink" data-bs-toggle="modal" data-bs-target="#productDataModal" onclick="getDataForProduct(' + element.id + ')"><h5>' + element.name + '</h5></a><button class="editBtn" onclick="editProduct(' + element.id + ')" data-bs-toggle="modal" data-bs-target="#productEditModal"><span class="badge rounded-pill"><i class="fas fa-pencil-alt" style="color: orange;font-size: 25px;"></i></span></button></div></div>');
                        });
                        $("#loading").css("display", "none");
                    }
                },
                error: function(xhr, textStatus, error) {
                    if (xhr.status === 500) {

                    }
                }
            })
        }


        let product;

        function getDataForProduct(id) {
            $(".generatedData").remove();
            $.ajax({
                type: "GET",
                url: `<?= REQUEST_URL ?>products/products/${id}`,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(resp, textStatus, jqXHR) {
                    if (jqXHR.status === 200) {
                        product = resp;
                        $("#DataModalLabel").append('<div class="generatedData">' + product.name + '</div>');
                        $("#DataModalBody").append('<p class="generatedData">' + product.description + '</p>');

                        $("#loadingData").css("display", "none");
                    }
                },
                error: function(xhr, textStatus, error) {
                    if (xhr.status === 500) {

                    }
                }
            })
        }


        async function editProduct(id) {
            $(".generatedData").remove();
            let productData;
            await $.ajax({
                type: "GET",
                url: `<?= REQUEST_URL ?>products/products/${id}`,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(resp, textStatus, jqXHR) {
                    if (jqXHR.status === 200) {
                        productData = resp;
                    }
                },
                error: function(xhr, textStatus, error) {
                    if (xhr.status === 500) {
                        return null;
                    }
                }
            })
            if (productData !== null || productData !== undefined) {
                $("#EditModalTitle").append('<input type="text" id="editProductTitle" class="form-controll generatedData" value="' + productData.name + '">');
                $("#EditModalBody").append('<textarea type="text" id="editProductDescription" class="form-controll generatedData" rows="6" style="width: 100%;">' + productData.description + '</textarea>');
                $("#footer-btn").append('<button type="button" class="btn btn-danger generatedData" onclick="deleteProduct(' + productData.id + ')">Delete product</button>');
                $("#footer-btn").append('<button type="button" class="btn btn-primary generatedData" onclick="updateProductData(' + productData.id + ')">Save changes</button>');
                $("#loadingEditData").css("display", "none");
            }

        }




        //-----Lazy solution = new request after patching the data - more complicated solution = change it inside products variable and rerender the products without making another call
        //      to the backand and to the database so so that would be a better solution for real life aplication
        function updateProductData(id) {
            let newName = $("#editProductTitle").val();
            let newDescription = $("#editProductDescription").val();

            let data = {
                name: newName,
                description: newDescription
            };
            $.ajax({
                type: "PATCH",
                url: `<?= REQUEST_URL ?>products/products/${id}`,
                data: JSON.stringify(data),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(resp, textStatus, jqXHR) {
                    if (jqXHR.status === 200) {
                        updateProductsData();
                        $("#productEditModal").modal("hide");
                    }
                },
                error: function(xhr, textStatus, error) {
                    if (xhr.status === 500) {
                        console.log("error");
                    }
                }
            })
        }

        function logout() {
            $.ajax({
                type: "POST",
                url: `<?= REQUEST_URL ?>register/logout`,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(resp, textStatus, jqXHR) {
                    if (jqXHR.status === 200) {
                        var url = "login";
                        $(location).attr('href', url);
                    }
                }
            })
        }

        $("#searchProduct").on("input", () => {
            let input = $("#searchProduct").val().toLowerCase();
            $(".generatedProducts").remove();
            let rs = products.filter(product => {
                return product.name.toLowerCase().includes(input)
            });
            rs.forEach(element => {
                $("#cardText").append('<div class="list-group generatedProducts"><div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"><a class="productLink" data-bs-toggle="modal" data-bs-target="#productDataModal" onclick="getDataForProduct(' + element.id + ')"><h5>' + element.name + '</h5></a><button class="editBtn" onclick="editProduct(' + element.id + ')" data-bs-toggle="modal" data-bs-target="#productEditModal"><span class="badge rounded-pill"><i class="fas fa-pencil-alt" style="color: orange;font-size: 25px;"></i></span></button></div></div>');
            });
        })


        function createProduct() {
            let nameValue = $("#createProductTitle").val();
            let descriptionValue = $("#createDescription").val();

            let data = {
                name: nameValue,
                description: descriptionValue
            };
            $.ajax({
                type: "POST",
                url: `<?= REQUEST_URL ?>products/products`,
                data: JSON.stringify(data),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(resp, textStatus, jqXHR) {
                    if (jqXHR.status === 201) {
                        updateProductsData();
                        $("#createProductModal").modal("hide");
                    }
                },
                error: function(xhr, textStatus, error) {
                    if (xhr.status === 500) {
                        console.log("error");
                    }
                }
            })
        }

        function deleteProduct(id) {
            $.ajax({
                type: "DELETE",
                url: `<?= REQUEST_URL ?>products/products/${id}`,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(resp, textStatus, jqXHR) {
                    if (jqXHR.status === 204) {
                        updateProductsData();
                        $("#productEditModal").modal("hide");
                    }
                },
                error: function(xhr, textStatus, error) {
                    if (xhr.status === 500) {
                        console.log("error");
                    }
                }
            })
        }
    </script>
</body>

</html>