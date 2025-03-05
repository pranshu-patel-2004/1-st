<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/a.css') }}">
</head>
<body>


<div class="container mt-5">
<div class="log-out">
    
    <h1>Add Products</h1>
    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit" style="background-color: #218838; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer;">
            Logout</button>
    </form>
</div>
    <nav>
        <a href="{{ route('products.index') }}">Products List</a>

        <a href="{{ route('product.create') }}">Add Products</a>
    
    </nav>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data"><br>
        @csrf
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" placeholder="Enter A Product Name" name="product_name" required>
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">Upload Images</label>
            <input type="file" class="form-control" name="images[]" multiple required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" placeholder="Enter A Description" required></textarea>
        </div>

        <div class="mb-3">
            <label for="tags" class="form-label">Tags</label>
            <input type="text" class="form-control" name="tags" id="tags" placeholder="Enter A Tag" data-role="tagsinput" required>
        </div>

        <h4>Product Details</h4>
        <div id="variantContainer">
            <div class="row variantRow">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="variant[]" placeholder="Variant" required>
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control" name="quantity[]" placeholder="Quantity" required>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" class="form-control" name="price[]" placeholder="Price" required>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-danger removeRow">Delete</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-primary mt-3" id="addMore">Add More</button>
        <button type="submit" class="btn btn-success mt-3">Submit</button>
    </form><br><br>
    



</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>


