<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/a.css') }}">
</head>
<body>



<div class="container mt-5">
    <div class="log-out">
    
    <h1>Products List</h1>
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
    
   <br>
    @if ($products->isEmpty())
        <div class="alert alert-warning mt-3">
            No products are listed.
        </div>
    @else
    @foreach ($products as $product)
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title"> Product Name:- {{ $product->product_name }}</h5>
                <h6 class="card-text">Description:- {{ $product->description }}</h6>
                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->product_name }}" width="100">

                <div class="mt-3">
                    
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal{{ $product->id }}">View</button>
                    
                    <form action="{{ route('products.delete', $product->id) }}" method="POST" style="display: inline;">
                       @csrf
                       @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                          Delete
                    </button>
                </form>
                </div>

                <!-- View Modal -->
                <div class="modal fade" id="viewModal{{ $product->id }}" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel">Product Details</h5>
                               
                            </div>
                            <div class="modal-body">

        
                            <h5>Product_name:</h5>
                                <p>{{ $product-> product_name}}</p> 

                                <h5>Description:</h5>
                                <p>{{ $product-> description}}</p>

                                <h5>Tags:</h5>
                                <p>{{ $product->tags }}</p>  

                                <h5>Variants:</h5>
                                <ul>
                                    @foreach ($product->variants as $variant)
                                        <li>{{ $variant->variant }} - Quantity: {{ $variant->quantity }} - Price: Rs{{ $variant->price }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @endif
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
